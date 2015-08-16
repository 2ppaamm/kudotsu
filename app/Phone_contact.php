<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone_contact extends Model
{
    /** Relationships */
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function activities(){
        return $this->hasManyThrough('App\Transaction_log','App\User');
    }

    public function FIs(){
        return $this->hasManyThrough('App\FI','App\User');
    }

    public function account_types(){
        return $this->hasManyThrough('App\Account_type','App\User');
    }
}
