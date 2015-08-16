<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Account_type;

class AccountTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account_type = Account_type::create([
            'account_type' => 'debit',
            'description' => 'deposit account'
        ]);

        $account_type = Account_type::create([
            'account_type' => 'credit',
            'description' => 'credit card account'
        ]);

        $account_type = Account_type::create([
            'account_type' => 'paypal',
            'description' => 'paypal account'
        ]);

        $account_type = Account_type::create([
            'account_type' => 'kudos',
            'description' => 'kudos account'
        ]);
    }
}