<?php

namespace App\Console\Commands;

use AlaaTV\Gateways\Contracts\OnlineGateway;
use AlaaTV\Gateways\Contracts\OnlinePaymentVerificationResponseInterface;
use AlaaTV\ZarinpalGatewayDriver\VerificationResponse;
use App\Repositories\TransactionRepo;
use App\Transaction;
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
        $this->comment('Getting data from ZarinPal...');
        $result = $this->getUnverifiedTransactions();
        if ($result['Status'] != 'success') {
            $this->error('Failed on receiving data from ZarinPal. Response status: ' . $result['Status']);
            return null;
        }

        $transactions = $result['Authorities'];

        if(is_null($transactions)){
            $this->info('There are no unverified transactions');
            return null;
        }

        if ($this->confirm('Found '.count($transactions) . ' unverified transactions. Do you want to proceed?', true)) {
            $this->info('Verification process started:');
            [$notExistTransactions, $unverifiedTransactionsDueToError] = $this->handleTransactions($transactions);


            $unverifiedTransactionsCount = count($unverifiedTransactionsDueToError);
            if ($unverifiedTransactionsCount > 0) {
                $this->info("\n");
                $this->info('ZarinPal did not verify ' . $unverifiedTransactionsCount . ' transaction(s):');
                $this->logError($unverifiedTransactionsDueToError);
            }

            $notExistTransactionsCount = count($notExistTransactions);
            if ($notExistTransactionsCount > 0) {
                $this->info("\n");
                $this->info('There were ' . $notExistTransactionsCount . ' unknown transaction(s):');
                $this->logError($notExistTransactions);
            }
        }

        $this->comment('Verification process ended successfully');

        return null;
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
        $bar = $this->output->createProgressBar(count($transactions));
        foreach ($transactions as $key => $item) {


            $authority = $item['Authority'];
            $amount    = $item['Amount'];
            $skip = true;
            if ($this->confirm('Transaction number '.($key+1).' => cost : '.$amount.' authority: '.$authority.'. Would you like to proceed? type No if you want to skip this transaction.' , true)) {
                $skip = false;
            }

            if($skip){
                continue;
            }

            /** @var Transaction $transaction */
            $transaction = TransactionRepo::getTransactionByAuthority($authority)->getValue(null);

            if (is_null($transaction)) {
                $this->error('No transaction found for this authority');

                array_push($notExistTransactions, $item);
                $bar->advance();
                continue;
            }

            $this->info('Found transaction '.$transaction->id.' for this authority');

            $gateWayVerify = $this->verifyTransaction($transaction->cost, $authority);

            if ($gateWayVerify->isSuccessfulPayment()) {
                $transactionUpdateResult = $transaction->update([
                    'transactionstatus_id' => config('constants.TRANSACTION_STATUS_SUCCESSFUL'),
                    'transactionID'        => $gateWayVerify->getRefId(),
                    'managerComment'       => 'به سایت برنگشته بود - ثبت با کامند',
                ]);

                if($transactionUpdateResult){
                    $this->info('Transaction '.$transaction->id.' has been updated successfully');

                    $order = $transaction->order;
                    if(isset($order)){
                        $order->update([
                            'orderstatus_id' => config('constants.ORDER_STATUS_CLOSED'),
                            'paymentstatus'  => config('constants.PAYMENT_STATUS_PAID')
                        ]);
                        $this->info('Order '.$order->id.' of transaction '.$transaction->id.' has been updated successfully');
                    }
                }
                $bar->advance();
                continue;
            }
            $this->error('ZarinPal did not verify transaction '.$transaction->id);

            array_push($unverifiedTransactionsDueToError, $item);

            $bar->advance();
        }

        $bar->finish();

        return [$notExistTransactions, $unverifiedTransactionsDueToError];
    }

    /**
     * @param $cost
     * @param $authority
     *
     * @return OnlinePaymentVerificationResponseInterface
     */
    private function verifyTransaction(int $cost, string $authority): OnlinePaymentVerificationResponseInterface
    {
        $result = $this->gateway->verify($cost, $authority);
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
            $this->error('authority: {' . $authority . '} amount: {' . $amount . '} channel: {' . $channel . '} cellPhone: {' . $cellPhone . '} date: {' . $date . '}');
        }
    }
}
