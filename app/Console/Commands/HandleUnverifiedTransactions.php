<?php

namespace App\Console\Commands;

use Zarinpal\Zarinpal;
use AlaaTV\Gateways\Money;
use App\Http\Requests\Request;
use Illuminate\Console\Command;
use AlaaTV\Gateways\PaymentDriver;
use App\Repositories\TransactionRepo;
use AlaaTV\Gateways\Contracts\OnlineGateway;

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
     * @var Request $request
     */
    private $request;
    
    /**
     * Create a new command instance.
     *
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //ToDo : At this time this only works for Zarinpal
        $paymentMethod = 'zarinpal';

        $paymentClient = PaymentDriver::select($paymentMethod);
        
        $this->info('getting data from zarinpal ...');
        $result = $this->getUnverifiedTransactions();

        if ($result['Status'] != 'success') {
            $this->info('There is a problem with receiving unverified transactions with Status: '.$result['Status']);
            return null;
        }

        $this->info('Untrusted transactions received.');
        $transactions = $result['Authorities'];
        list($notExistTransactions, $unverifiedTransactionsDueToError) = $this->handleTransactions($transactions, $paymentClient);

        if (count($unverifiedTransactionsDueToError) > 0) {
            $this->info('Unverified Transactions Due To Error:');
            $this->logError($unverifiedTransactionsDueToError);
        }

        if (count($notExistTransactions) == 0) {
            return null;
        }
        $this->logError($notExistTransactions);

        if ($this->confirm('The above transactions are not available. \n\rDo you wish to force verify?', true)) {
            foreach ($notExistTransactions as $item) {
                $gateWayVerify = $paymentClient->verifyPayment(Money::fromTomans($item['Amount']), $item['Authority']);
            }
        }
    }
    
    private function getUnverifiedTransactions()
    {
        return (new Zarinpal(['merchantID' => $this->merchantNumber]))->getUnverifiedTransactions();
    }

    /**
     * @param array $items
     * @return mixed
     */
    private function logError(array $items)
    {
        foreach ($items as $item) {
            $authority = $item['Authority'];
            $amount = $item['Amount'];
            $channel = $item['Channel'];
            $cellPhone = $item['CellPhone'];
            $date = $item['Date'];
            $this->info('authority: {'.$authority.'} amount: {'.$amount.'} channel: {'.$channel.'} cellPhone: {'.$cellPhone.'} date: {'.$date.'}');
        }
    }

    /**
     * @param $transactions
     * @param \AlaaTV\Gateways\Contracts\OnlineGateway $paymentClient
     * @return array
     */
    private function handleTransactions($transactions, OnlineGateway $paymentClient): array
    {
        $notExistTransactions = [];
        $unverifiedTransactionsDueToError = [];
        foreach ($transactions as $transaction) {

            $authority = $transaction['Authority'];
            $this->info($authority);

            $transaction = TransactionRepo::getTransactionByAuthority($authority)->getValue(null);

            if (is_null($transaction)) {
                array_push($notExistTransactions, $transaction);
                continue;
            }
            $transaction['Status'] = 'OK';

            $gateWayVerify = $paymentClient->verifyPayment(Money::fromTomans($transaction->cost), $authority);

            if (!$gateWayVerify->isSuccessfulPayment()) {
                array_push($unverifiedTransactionsDueToError, $transaction);
            }
        }

        return [$notExistTransactions, $unverifiedTransactionsDueToError];
    }
}
