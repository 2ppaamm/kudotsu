<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Account_status;

class AccountStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account_status = Account_status::create([
            'status' => 'active',
            'description' => 'active account'
        ]);

        $account_status = Account_status::create([
            'status' => 'onhold',
            'description' => 'onhold account'
        ]);

        $account_status = Account_status::create([
            'status' => 'closed',
            'description' => 'closed account'
        ]);

        $account_status = Account_status::create([
            'status' => 'inactive',
            'description' => 'inactive account'
        ]);

        $account_status = Account_status::create([
            'status' => 'compromised',
            'description' => 'compromised account'
        ]);
    }
}