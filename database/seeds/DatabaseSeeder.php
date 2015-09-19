<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
            $this->call(CurrencyTableSeeder::class);
            $this->call(UserTableSeeder::class);
            $this->call(TransactionCodeTableSeeder::class);
            $this->call(PhoneContactTableSeeder::class);
            $this->call(FITableSeeder::class);
            $this->call(AccountTypeTableSeeder::class);
            $this->call(BankAccountTableSeeder::class);
            $this->call(TransactionLogTableSeeder::class);
            $this->call(OAuthClientTableSeeder::class);
        Model::reguard();
    }
}
