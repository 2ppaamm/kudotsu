<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction_log extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function bank_account(){
        return $this->belongsTo('App\Bank_account');
    }

    public function currency(){
        return $this->belongsTo('App\Currency', 'txn_currencyid');
    }

    public function transaction_code(){
        return $this->belongsTo('App\Transaction_code');
    }

    protected $fillable = ['user_id', 'bank_account_id', 'txn_currencyid', 'amount_in_txn_currency', 'transaction_address', 'merchant_code', 'acc_currencyid'];
}