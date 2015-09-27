<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Currency;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currency = Currency::create([
            'ISO_symbol' => 'KUD',
            'Kudos_exchange' => 1.00,
            'country_organization' => 'Kudotsu',
            'type' => 'Virtual',
            'description' => 'Kudos',
            'daily_limit' => 1000.00,
            'transaction_limit' => 100.00
        ]);
        $currency = Currency::create([
            'ISO_symbol' => 'USD',
            'Kudos_exchange' => 10000.00,
            'country_organization' => 'US',
            'type' => 'Country',
            'description' => 'US Dollar',
            'daily_limit' => 1000.00,
            'transaction_limit' => 100.00
        ]);
        $currency = Currency::create([
            'ISO_symbol' => 'SGD',
            'Kudos_exchange' => 7142.00,
            'country_organization' => 'SG',
            'type' => 'Country',
            'description' => 'Singapore Dollar',
            'daily_limit' => 1000.00,
            'transaction_limit' => 50.00
        ]);
        $currency = Currency::create([
            'ISO_symbol' => 'AUD',
            'Kudos_exchange' => 7400.00,
            'country_organization' => 'AU',
            'type' => 'Country',
            'description' => 'Australian Dollar',
            'daily_limit' =>2000.00,
            'transaction_limit' => 100.00
        ]);
    }
}