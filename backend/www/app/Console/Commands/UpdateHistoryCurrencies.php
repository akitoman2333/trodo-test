<?php

namespace App\Console\Commands;


use App\API\V1\Services\HistoryOfCurrencies\ApiCurrencies;
use Illuminate\Support\Facades\Bus;
use Illuminate\Console\Command;
use App\Jobs\UpdateCurrencies;
class UpdateHistoryCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:history-currencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update historical currency data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Bus::dispatch(new UpdateCurrencies(app(ApiCurrencies::class)));
        $this->info('Historical currency data updated successfully.');
    }
}
