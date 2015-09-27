<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OAuth_clients extends Model
{
    protected $table = 'oauth_clients';

    public function user(){
        return $this->belongsTo('App\User');
    }
}
