<?php

namespace App\Console\Commands;

use App\Classes\Payment\Gateway\GatewayFactory;
use App\Transaction;
use App\Transactiongateway;
use App\Http\Controllers\OnlinePaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Requests\Request;
use Illuminate\Console\Command;
use App\Classes\Payment\Gateway\Zarinpal\Zarinpal;
use Zarinpal\Zarinpal as ZarinpalComposer;

class HandleUnverifiedTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alaaTv:unverifiedTransactions:handle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Confirm Unverified Transactions';

    /**
     * @var TransactionController $transactionController
     */
    private $transactionController;

    /**
     * @var OnlinePaymentController $onlinePaymentController
     */
    private $onlinePaymentController;

    /**
     * @var Request $request
     */
    private $request;

    private $merchantNumber;

    private $gateWay;
    /**
     * Create a new command instance.
     *
     * @param TransactionController $transactionController
     * @param OnlinePaymentController $onlinePaymentController
     * @param Request $request
     */
    public function __construct(TransactionController $transactionController, OnlinePaymentController $onlinePaymentController, Request $request)
    {
        parent::__construct();
        $this->request = $request;
        $this->transactionController = $transactionController;
        $this->onlinePaymentController = $onlinePaymentController;

        //ToDo : At this time this only works for Zarinpal
        $paymentMethod = 'zarinpal';
        $transactiongateway = Transactiongateway::where('name', $paymentMethod)->first();
        $this->merchantNumber = $transactiongateway->merchantNumber;
        $data['merchantID'] = $this->merchantNumber;
        $this->gateWay = (new GatewayFactory())->setGateway($paymentMethod, $data);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $notExistTransactions = [];
        $unverifiedTransactionsDueToError = [];

        $this->info('getting data from zarinpal ...');
        $result = $this->getUnverifiedTransactions();
        if($result['Status'] == 'success') {
            $this->info('Untrusted transactions received.');
            $transactions = $result['Authorities'];
            foreach ($transactions as $transaction) {

                /*$result = [
                    'sendSMS' => false,
                    'Status' => 'error'
                ];*/
                $this->request->offsetSet('Authority', $transaction['Authority']);
                $this->request->offsetSet('Status', 'OK');
                /*$data = [
                    'request' => $this->request,
                    'result' => $result
                ];*/
                $this->info($transaction['Authority']);

                $transaction = Transaction::authority($transaction['Authority'])->first();

                if(!isset($transaction)) {
                    array_push($notExistTransactions, $transaction);
                } else {
                    $transaction['Status'] = 'OK';
                    array_push($unverifiedTransactionsDueToError, $transaction);
                    $gateWayVerify = $this->gateWay->verify($transaction->cost, $transaction);

                    if($gateWayVerify['Status'] == 'error') {
                        array_push($unverifiedTransactionsDueToError, $transaction);
                    }
                }
            }

            if(count($unverifiedTransactionsDueToError)>0) {
                $this->info('Unverified Transactions Due To Error:');
                foreach ($unverifiedTransactionsDueToError as $item) {
                    $authority = $item['Authority'];
                    $amount = $item['Amount'];
                    $channel = $item['Channel'];
                    /*$callbackURL = $item['CallbackURL'];
                    $referer = $item['Referer'];
                    $email = $item['Email'];*/
                    $cellPhone = $item['CellPhone'];
                    $date = $item['Date'];
                    $this->info('authority: {'.$authority.'} amount: {'.$amount.'} channel: {'.$channel.'} cellPhone: {'.$cellPhone.'} date: {'.$date.'}');
                }
            }

            if(count($notExistTransactions)>0) {
                foreach ($notExistTransactions as $item) {
                    $authority = $item['Authority'];
                    $amount = $item['Amount'];
                    $channel = $item['Channel'];
                    /*$callbackURL = $item['CallbackURL'];
                    $referer = $item['Referer'];
                    $email = $item['Email'];*/
                    $cellPhone = $item['CellPhone'];
                    $date = $item['Date'];
                    $this->info('authority: {'.$authority.'} amount: {'.$amount.'} channel: {'.$channel.'} cellPhone: {'.$cellPhone.'} date: {'.$date.'}');
                }
                if ($this->confirm('The above transactions are not available. \n\rDo you wish to force verify?', true)) {
                    foreach ($notExistTransactions as $item) {
                        $zarinpal = new ZarinpalComposer($this->merchantNumber);
                        $zarinpal->verify('OK', $item['Amount'], $item['Authority']);
                    }
                }
            }
        } else {
            $this->info('There is a problem with receiving unverified transactions with Status: '.$result['Status']);
        }
        return null;
    }

    private function getUnverifiedTransactions() {
        $data['merchantID'] = $this->merchantNumber;
        $zarinpal = new Zarinpal($data);
        $result = $zarinpal->getUnverifiedTransactions();
        return $result;
    }
}
