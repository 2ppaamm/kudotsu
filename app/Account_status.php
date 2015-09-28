<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account_status extends Model
{
    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function bank_accounts(){
        return $this->belongsToMany('App\Bank_account');
    }
}
