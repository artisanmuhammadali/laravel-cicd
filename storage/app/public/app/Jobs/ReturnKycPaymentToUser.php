<?php

namespace App\Jobs;

use App\Services\Admin\User\ReturnKycPaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ReturnKycPaymentToUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $id;
    /**
     * Create a new job instance.
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $service = new ReturnKycPaymentService;
        Log::info('Returning KYC Payment to user init......');
        $service->returnPayment($this->id);
        Log::info('Returning KYC Payment to user ter.......');
    }
}
