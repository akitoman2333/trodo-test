<?php

namespace App\Jobs;


use App\API\V1\Services\HistoryOfCurrencies\ApiCurrencies;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateCurrencies implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ApiCurrencies $currencies;

    /**
     * Create a new job instance.
     */
    public function __construct(ApiCurrencies $currencies)
    {
        $this->currencies = $currencies;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $apiCurrencies = $this->currencies->api(config('services.currencies.key'));
        $apiCurrencies->setCurrencies();
    }
}
