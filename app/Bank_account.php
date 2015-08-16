<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank_account extends Model
{
    protected $hidden = ['update_at', 'created_at', 'user_id'];

    protected $fillable = ['fi_id', 'account_number', 'account_type_id','user_id', 'currency_id'];

    public function currency(){
        return $this->hasOne('App\Currency');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function FI(){
        return $this->belongsTo('App\FI');
    }

    public function account_type(){
        return $this->belongsTo('App\Account_type');
    }

    public function activities(){
        return $this->hasMany('App\Transaction_log');
    }
}