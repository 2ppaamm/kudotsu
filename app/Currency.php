<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public function bank_accounts(){
        return $this->hasMany('App\Bank_account');
    }
}
