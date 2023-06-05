<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $date = Carbon::now()->subDays(30)->startOfDay();

        for ($i = 0; $i < 30; $i++) {
            $rate = [
                'AUD' => mt_rand(15800, 16300) / 10000,
                'EUR' => 1,
                'GBP' => mt_rand(8300, 8700) / 10000,
                'USD' => mt_rand(9000, 11500) / 10000,
            ];

            Currency::insert([
                'currency' => 'EUR',
                'rate' => json_encode($rate),
                'created_at' => $date,
                'updated_at' => $date,
            ]);

            $date->addDay();
        }
        Artisan::call('update:history-currencies');
    }
}
