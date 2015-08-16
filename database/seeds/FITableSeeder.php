<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\FI;

class FITableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fi = FI::create([
            'bank_name' => 'DBS Singapore',
            'bank_identifier_code' => 'DBSSSGSG',
            'home_currency' => 3,
            'ledger_balance' => 9387000000,
            'onhold' => 938000
        ]);
        $fi = FI::create([
            'bank_name' => 'ANZ Australia',
            'bank_identifier_code' => 'ANZBAU3M',
            'home_currency' => 4,
            'ledger_balance' => 387000000,
            'onhold' => 38000
        ]);
        $fi = FI::create([
            'bank_name' => 'Citibank US',
            'bank_identifier_code' => 'CITIUS33VCM',
            'home_currency' => 2,
            'ledger_balance' => 37000000,
            'onhold' => 3000
        ]);
    }
}