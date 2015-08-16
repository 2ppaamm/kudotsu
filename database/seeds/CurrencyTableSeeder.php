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
            'description' => 'Kudos'
        ]);
        $currency = Currency::create([
            'ISO_symbol' => 'USD',
            'Kudos_exchange' => 10000.00,
            'country_organization' => 'US',
            'type' => 'Country',
            'description' => 'US Dollar'
        ]);
        $currency = Currency::create([
            'ISO_symbol' => 'SGD',
            'Kudos_exchange' => 7142.00,
            'country_organization' => 'SG',
            'type' => 'Country',
            'description' => 'Singapore Dollar'
        ]);
        $currency = Currency::create([
            'ISO_symbol' => 'AUD',
            'Kudos_exchange' => 7400.00,
            'country_organization' => 'AU',
            'type' => 'Country',
            'description' => 'Australian Dollar'
        ]);
    }
}