<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FI extends Model
{
    protected $table = 'FIs';

    public function activities(){
        return $this->hasManyThrough('App\Transaction_log', 'App\Bank_account');
    }

    public function users(){
        return $this->hasManyThrough('App\User', 'App\Bank_account');
    }
    public function phone_contacts(){
        return $this->hasManyThrough('App\Phone_contact', 'App\Bank_account', 'App\User');
    }
}
