<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $currencies = [
            'USD', 'EUR', 'PEN'
        ];

        DB::table('currencies')->truncate();

        foreach ($currencies as $currency) {
            Currency::create([
                'iso' => $currency,
            ]);
        }
    }
}
