<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction_codes extends Model
{
    public function activities(){
        return $this->hasMany('App\Transaction_log');
    }
}
