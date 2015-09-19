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
        $user = OAuth_clients::create([
            'id' =>1,
            'name' => 'pamelalim',
            'secret' => '123456',
        ]);
        $user = OAuth_clients::create([
            'id'=>2,
            'name' => 'kenthoie',
            'secret' => 'kenthoie',
        ]);
        $user = OAuth_clients::create([
            'id'=>3,
            'name' => 'kennethgoh',
            'secret' => 'kennethgoh',
        ]);

        for ($i = 4; $i < 25; $i++)
        {
            $user = OAuth_clients::create([
                'id' =>$i,
                'name' => $faker->userName,
                'secret' => 'password',
           ]);
        }
   }
}