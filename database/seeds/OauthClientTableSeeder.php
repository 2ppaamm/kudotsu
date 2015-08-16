<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use OA as OAuth;

class OauthClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $user = OAuth::create([
            'name' => 'pamelalim',
            'secret' => Hash::make('123456'),
        ]);
        $user = OAuth::create([
            'name' => 'kenthoie',
            'secret' => Hash::make('kenthoie'),
        ]);
        $user = OAuth::create([
            'name' => 'kennethgoh',
            'secret' => Hash::make('kennethgoh'),
        ]);

        for ($i = 0; $i < 20; $i++)
        {
            $user = OAuth::create([
                'name' => $faker->userName,
                'secret' => Hash::make('password'),
           ]);
        }
   }
}