<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Transaction_codes;

class TransactionCodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transaction_code = Transaction_codes::create([
            'Code' => '0200',
            'Type' => 'ISO8583',
            'description' => 'Acquirer Financial Request'
        ]);
        $transaction_code = Transaction_codes::create([
            'Code' => '0230',
            'Type' => 'ISO8583',
            'description' => 'Issuer Response to Financial Request'
        ]);
        $transaction_code = Transaction_codes::create([
            'Code' => 'CURDR',
            'Type' => 'Kudotsu Internal',
            'description' => 'Cash Debit'
        ]);
        $transaction_code = Transaction_codes::create([
            'Code' => 'CURCR',
            'Type' => 'Kudotsu Internal',
            'description' => 'Cash Credit'
        ]);
        $transaction_code = Transaction_codes::create([
            'Code' => 'KUDDR',
            'Type' => 'Kudotsu Internal',
            'description' => 'Kudos Debit'
        ]);
        $transaction_code = Transaction_codes::create([
            'Code' => 'KUDCR',
            'Type' => 'Kudotsu Internal',
            'description' => 'Kudos Credit'
        ]);
    }
}