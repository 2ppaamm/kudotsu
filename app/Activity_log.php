<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity_log extends Model
{
    protected $primaryKey = 'activity_id';

    public function payer(){
        return $this->belongsTo('App\User', 'payer_id');
    }

    public function payee(){
        return $this->belongsTo('App\User', 'payee_id');
    }

    public function currency(){
        return $this->belongsTo('App\Currency', 'txn_currencyid');
    }

    protected $fillable = ['id','payer_id', 'payee_id', 'txn_currencyid', 'amount_in_txn_currency'];
}