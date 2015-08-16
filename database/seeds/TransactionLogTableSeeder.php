<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use App\Transaction_log;

class TransactionLogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++)
        {
            $transaction_id = $faker->uuid;
            $transaction_amt = $faker->randomFloat(4);
            $address = $faker->address;
            $kudos = $faker->randomNumber(5);
            $consumer_address = $faker->address;
            $buyer = $faker->numberBetween(1,23);
            $seller = $faker->numberBetween(1,23);
            $activity = Transaction_log::create([
                'transaction_code' => 4,                    //credit from payment gateway
                'transaction_id' => $transaction_id,
                'user_id' => $buyer,
                'merchant_code' => $seller,
                'bank_account_id' => $faker->numberBetween(1,40),
                'txn_currencyid' => $faker->numberBetween(1,4),
                'amount_in_txn_currency' => $transaction_amt,
                'acc_currencyid' => $faker->numberBetween(1,4),
                'amount_in_acc_currency' =>$faker->randomFloat(8,2),
                'amount_in_kudos' => $kudos,
                'transaction_address' => $address,
                'billing_address' => $consumer_address
            ]);
            $activity = Transaction_log::create([
                'transaction_code' => 3,                    //debit account to buy kudos
                'transaction_id' => $transaction_id,
                'user_id' => $buyer,
                'bank_account_id' => $faker->numberBetween(1,40),
                'merchant_code' => $seller,
                'txn_currencyid' => $faker->numberBetween(1,4),
                'amount_in_txn_currency' => $transaction_amt,
                'acc_currencyid' => $faker->numberBetween(1,4),
                'amount_in_acc_currency' =>$faker->randomFloat(8,2),
                'amount_in_kudos' => $kudos,
                'transaction_address' => $address,
                'billing_address' => $consumer_address
            ]);
            $activity = Transaction_log::create([
                'transaction_code' => 6,                    //credit kudos account
                'transaction_id' => $transaction_id,
                'user_id' => $buyer,
                'bank_account_id' => $faker->numberBetween(1,40),
                'merchant_code' => $seller,
                'txn_currencyid' => $faker->numberBetween(1,4),
                'amount_in_txn_currency' => $transaction_amt,
                'acc_currencyid' => $faker->numberBetween(1,4),
                'amount_in_acc_currency' =>$faker->randomFloat(8,2),
                'amount_in_kudos' => $kudos,
                'transaction_address' => $address,
                'billing_address' => $consumer_address
            ]);
            $activity = Transaction_log::create([
                'transaction_code' => 5,                    //debit kudos account
                'transaction_id' => $transaction_id,
                'user_id' => $buyer,
                'bank_account_id' => $faker->numberBetween(1,40),
                'merchant_code' => $seller,
                'txn_currencyid' => $faker->numberBetween(1,4),
                'amount_in_txn_currency' => $transaction_amt,
                'acc_currencyid' => $faker->numberBetween(1,4),
                'amount_in_acc_currency' =>$faker->randomFloat(8,2),
                'amount_in_kudos' => $kudos,
                'transaction_address' => $address,
                'billing_address' => $consumer_address
            ]);
            $activity = Transaction_log::create([
                'transaction_code' => 6,                    //credit kudos account
                'transaction_id' => $transaction_id,
                'user_id' => $seller,
                'bank_account_id' => $faker->numberBetween(1,40),
                'merchant_code' => $seller,
                'txn_currencyid' => $faker->numberBetween(1,4),
                'amount_in_txn_currency' => $transaction_amt,
                'acc_currencyid' => $faker->numberBetween(1,4),
                'amount_in_acc_currency' =>$faker->randomFloat(8,2),
                'amount_in_kudos' => $kudos,
                'transaction_address' => $address,
                'billing_address' => $consumer_address
            ]);
        }
   }
}