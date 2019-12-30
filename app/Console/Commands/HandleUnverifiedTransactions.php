<?php

namespace App\Console\Commands;

use AlaaTV\Gateways\Contracts\OnlineGateway;
use AlaaTV\Gateways\Contracts\OnlinePaymentVerificationResponseInterface;
use AlaaTV\Gateways\Money;
use AlaaTV\ZarinpalGatewayDriver\VerificationResponse;
use App\Repositories\TransactionRepo;
use Illuminate\Console\Command;
use Zarinpal\Zarinpal;

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
    protected $description = 'Confirms unverified transactions of  ZarinPal gateway';

    private $gateway;

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->gateway = $this->getGatewayComposer();
    }

    public function getGatewayComposer()
    {
        return new Zarinpal(config('Zarinpal.merchantID'));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //ToDo : At this time this only works for Zarinpal
        $this->info('getting data from zarinpal ...');
        $result = $this->getUnverifiedTransactions();

        if ($result['Status'] != 'success') {
            $this->info('Failed on receiving unverified transactions. Response status: ' . $result['Status']);
            return null;
        }

        $transactions = $result['Authorities'];
        $this->info(count($transactions) . ' unverified transactions were received');
        $this->info('Verifying transactions started:');
        [$notExistTransactions, $unverifiedTransactionsDueToError] = $this->handleTransactions($transactions);
        $this->info('Verifying transactions finished');

        if (count($unverifiedTransactionsDueToError) > 0) {
            $this->info('Gateway did not verify these transactions:');
            $this->logError($unverifiedTransactionsDueToError);
        }

        if (count($notExistTransactions) == 0) {
            return null;
        }

        $this->info('These transactions were not found on Database');
        $this->logError($notExistTransactions);

        if ($this->confirm('Do you wish to force-verify these transactions?', true)) {
            $unverifiedTransactions = [];
            foreach ($notExistTransactions as $item) {
                $gateWayVerify = $this->verifyTransaction(Money::fromTomans($item['Amount']), $item['Authority']);
                if (!$gateWayVerify->isSuccessfulPayment()) {
                    array_push($unverifiedTransactions, $item);
                }
                $this->logError($unverifiedTransactions);
            }
        }
    }

    private function getUnverifiedTransactions()
    {
        return $this->gateway->getDriver()->unverifiedTransactions(['MerchantID' => config('Zarinpal.merchantID')]);
    }

    /**
     * @param                                          $transactions
     * @param OnlineGateway $paymentClient
     *
     * @return array
     */
    private function handleTransactions($transactions): array
    {
        $notExistTransactions             = [];
        $unverifiedTransactionsDueToError = [];
        foreach ($transactions as $item) {

            $authority = $item['Authority'];
            $this->info($authority);

            $transaction = TransactionRepo::getTransactionByAuthority($authority)->getValue(null);

            if (is_null($transaction)) {
                array_push($notExistTransactions, $item);
                continue;
            }

            $gateWayVerify = $this->verifyTransaction($transaction->cost, $authority);

            if ($gateWayVerify->isSuccessfulPayment()) {
                //ToDo : close order
                continue;
            }

            array_push($unverifiedTransactionsDueToError, $item);
        }

        return [$notExistTransactions, $unverifiedTransactionsDueToError];
    }

    /**
     * @param $cost
     * @param $authority
     *
     * @return OnlinePaymentVerificationResponseInterface
     */
    private function verifyTransaction($cost, $authority): OnlinePaymentVerificationResponseInterface
    {
        //ToDo : Bug with Money::fromTomansx
//        $result = $this->gateway->verify(Money::fromTomans($cost), $authority);
        $result['Status'] = 'success';
        return VerificationResponse::instance($result);
    }

    /**
     * @param array $items
     *
     * @return mixed
     */
    private function logError(array $items)
    {
        foreach ($items as $item) {
            $authority = $item['Authority'];
            $amount    = $item['Amount'];
            $channel   = $item['Channel'];
            $cellPhone = $item['CellPhone'];
            $date      = $item['Date'];
            $this->info('authority: {' . $authority . '} amount: {' . $amount . '} channel: {' . $channel . '} cellPhone: {' . $cellPhone . '} date: {' . $date . '}');
        }
    }
}
