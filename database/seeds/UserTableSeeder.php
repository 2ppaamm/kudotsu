<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $user = User::create([
            'name' => 'pamelalim',
            'email' => 'pamelaliusm@gmail.com',
            'password' => Hash::make('123456'),
            'is_admin' => TRUE,
            'account_status_id' => 1,
            'address' =>'88 Eighth Ave, Someplace, QLD 4067',
            'kudos_ledger_balance' => 400000,
            'kudos_onhold_amt' =>0,
            'kudos_available_balance' =>400000,
            'kudos_used_today' => 400,
            'kudos_beginning_day_balance' => 500000,
            'number_of_txn_day' => 4,
            'net_day_txn_kudos' => 100000,
            'account_currency_id' => 2,
            'daily_limit_kudos' => 1000000000,
            'transaction_limit_kudos' => 1000000
        ]);
        $user = User::create([
            'name' => 'kenthoie',
            'email' => 'yinkuan.2006@gmail.com',
            'password' => Hash::make('kenthoie'),
            'is_admin' => TRUE,
            'account_status_id' => 1,
            'address' =>'98 Some street, Someplace, Singapore 348790',
            'kudos_ledger_balance' => 800000,
            'kudos_onhold_amt' =>100000,
            'kudos_available_balance' =>700000,
            'kudos_used_today' => 40000,
            'kudos_beginning_day_balance' => 10000000,
            'number_of_txn_day' => 3,
            'net_day_txn_kudos' => 300000,
            'account_currency_id' => 3,
            'daily_limit_kudos' => 1000000,
            'transaction_limit_kudos' => 100000
        ]);
        $user = User::create([
            'name' => 'kennethgoh',
            'email' => 'jazken@gmail.com',
            'password' => Hash::make('kennethgoh'),
            'is_admin' => TRUE,
            'account_status_id' => 1,
            'address' =>'78 Some Cushy Island, The place to be at, USA 38792-098',
            'kudos_ledger_balance' => 4000000,
            'kudos_onhold_amt' =>0,
            'kudos_available_balance' =>4000000,
            'kudos_used_today' => 40000,
            'kudos_beginning_day_balance' => 5000000,
            'number_of_txn_day' => 4,
            'net_day_txn_kudos' => 1000000,
            'account_currency_id' => 4,
            'daily_limit_kudos' => 1000000,
            'transaction_limit_kudos' => 1000
        ]);

        for ($i = 0; $i < 20; $i++)
        {
            $user = User::create(array(
                'name' => $faker->userName,
                'email' => $faker->email,
                'password' => Hash::make('password'),
                'account_status_id' => 1,
                'is_admin'=>False,
                'address' => $faker->address,
                'kudos_ledger_balance' => $faker->numberBetween(0,1000000),
                'kudos_onhold_amt' =>$faker->numberBetween(0,100000),
                'kudos_available_balance' => $faker->numberBetween(0,900000),
                'kudos_beginning_day_balance' => $faker->numberBetween(0,1200000),
                'number_of_txn_day' => $faker->numberBetween(1,10),
                'net_day_txn_kudos' => $faker->numberBetween(0,1200000),
                'account_currency_id' => 4,
                'daily_limit_kudos' => 1000,
                'transaction_limit_kudos' => 100
            ));
        }
   }
}