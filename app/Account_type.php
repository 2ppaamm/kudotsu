<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account_type extends Model
{
    public function activities(){
        return $this->hasManyThrough('App\Transaction_log','App\Bank_account');
    }
}
