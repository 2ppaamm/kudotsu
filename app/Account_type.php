<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account_type extends Model
{
    public function transactions(){
        return $this->hasManyThrough('App\Transaction_log','App\Bank_account');
    }

    public function bank_accounts(){
        return $this->hasMany('App\Bank_account');
    }
}
