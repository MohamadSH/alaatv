<?php

namespace App\Console\Commands;

use App\Transactiongateway;
use App\Http\Controllers\OnlinePaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Requests\Request;
use Illuminate\Console\Command;
use App\Classes\Payment\GateWay\Zarinpal\Zarinpal;
use App\Classes\Payment\GateWay\GateWayFactory;
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
        $this->gateWay = new GateWayFactory($this->transactionController);
        $zarinGate = Transactiongateway::where('name', 'zarinpal')->first();
        $this->merchantNumber = $zarinGate->merchantNumber;
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

        $result = $this->getUnverifiedTransactions();
        if($result['Status'] == 'success') {
            $transactions = $result['Authorities'];
            foreach ($transactions as $transaction) {
                $result = [
                    'sendSMS' => false,
                    'Status' => 'error'
                ];
                $this->request->offsetSet('Authority', $transaction['Authority']);
                $this->request->offsetSet('Status', 'OK');
                $data = [
                    'request' => $this->request,
                    'result' => $result
                ];
                $result = $this->gateWay->setGateWay('zarinpal')->verify($data);

                if($result['Status'] == 'error' &&
                    (
                        array_search( 'Transaction not found', $result['Message']) !== false ||
                        array_search( 'Order not found', $result['Message']) !== false
                    )
                ) {
                    array_push($notExistTransactions, $transaction);
                } else if($result['Status'] == 'error') {
                    array_push($unverifiedTransactionsDueToError, $transaction);
                }
            }

            if(count($unverifiedTransactionsDueToError)>0) {
                $this->info('Unverified Transactions Due To Error:');
                foreach ($unverifiedTransactionsDueToError as $item) {
                    $authority = $item['Authority'];
                    $amount = $item['Amount'];
                    $channel = $item['Channel'];
                    $callbackURL = $item['CallbackURL'];
                    $referer = $item['Referer'];
                    $email = $item['Email'];
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
                    $callbackURL = $item['CallbackURL'];
                    $referer = $item['Referer'];
                    $email = $item['Email'];
                    $cellPhone = $item['CellPhone'];
                    $date = $item['Date'];
                    $this->info('authority: {'.$authority.'} amount: {'.$amount.'} channel: {'.$channel.'} cellPhone: {'.$cellPhone.'} date: {'.$date.'}');
                }
                if ($this->confirm('The above transactions are not available. \n\rDo you wish to force verify?', true)) {
                    foreach ($unverifiedTransactionsDueToError as $item) {
                        $zarinpal = new ZarinpalComposer($this->merchantNumber);
                        $zarinpal->verify('OK', $item['Amount'], $item['Authority']);
                    }
                }
            }
        } else {
            $this->info('get zarinpal Unverified Transactions Status: '.$result['Status']);
        }
    }

    private function getUnverifiedTransactions() {
        $zarinpal = new Zarinpal((new TransactionController()));
        $result = $zarinpal->getUnverifiedTransactions();
        return $result;
    }
}
