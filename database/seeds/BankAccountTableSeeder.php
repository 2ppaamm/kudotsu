<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Bank_account;
class  BankAccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 40; $i++) {

            $bank_account = Bank_account::create([
                'user_id' => $faker->numberBetween(1,23),
                'fi_id' => $faker->numberBetween(1,3),
                'account_number'=>$faker->regexify('[0-9]+\-[0-9]{2,4}'),
                'account_type_id'=>$faker->numberBetween(1,4),
                'currency_id'=>$faker->numberBetween(1,4),
                'transaction_limit' => 50,
                'daily_limit' =>1000,
                'is_primary' => TRUE
            ]);
        }
    }
}