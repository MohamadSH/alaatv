<?php

use App\Productvoucher;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class FillProductvouchersContractorId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $vouchers = Productvoucher::all();

        $output = new ConsoleOutput();
        $output->writeln('Filling vouchers contractors...');
        $progress = new ProgressBar($output, $vouchers->count());
        foreach ($vouchers as $voucher) {
            $voucher->update(['contractor_id' => Productvoucher::CONTRANCTOR_ASIATECH]);
            $progress->advance();
        }

        $progress->finish();
    }
}
