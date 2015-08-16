<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Phone_contact;
use Faker\Factory as Faker;

class PhoneContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 40; $i++)
        {
            $phone = Phone_contact::create([
                'deviceid' => $faker->randomNumber(7),
                'user_id' => $faker->numberBetween(1,23),
            ]);
        }
    }
}