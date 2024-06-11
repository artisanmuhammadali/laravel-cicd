<?php

namespace App\Console\Commands\Mtg\Cron;

use App\Models\User;
use App\Services\Admin\User\ReturnKycPaymentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ReturnKycPayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:return-kyc-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(ReturnKycPaymentService $service)
    {
        // $service->returnPayment();
        Log::info('User: Kyc Payment Returning...');
    }
}
