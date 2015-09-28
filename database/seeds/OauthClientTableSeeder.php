<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;
use App\OAuth_clients;

class OAuthClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $client = OAuth_clients::create([
            'id' =>1,
            'name' => 'pamelalim',
            'secret' => '123456',
            'user_id' => 1
        ]);
        $client = OAuth_clients::create([
            'id'=>3,
            'name' => 'kenthoie',
            'secret' => 'kenthoie',
            'user_id' => 2
        ]);
        $client = OAuth_clients::create([
            'id'=>2,
            'name' => 'kennethgoh',
            'secret' => 'kennethgoh',
            'user_id' => 3
        ]);

        for ($i = 4; $i < 20; $i++)
        {
            $client = OAuth_clients::create([
                'id' =>$i,
                'name' => $faker->userName,
                'secret' => 'password',
                'user_id' => $i
           ]);
        }
   }
}