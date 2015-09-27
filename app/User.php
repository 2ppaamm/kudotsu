<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;
use App\Phone_contact as Phone_contact;

class User extends Model implements BillableContract, AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Billable;

    /** rules */
    private $rules = [
        'name' => 'required|unique:users',
        'email' => 'required|unique:users',
        'password' => 'required',
        'account_currency' => 'required',
        'address' => 'required'
    ];

    public function validate(){
        $v = \Validator::make($this->attributes, $this->rules);
        if ($v->passes()) return true;
        $this->errors = $v->messages();
        return false;
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    /**
     * For Stripe
     * @var array
     */
    protected $dates = ['trial_ends_at', 'subscription_ends_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'account_currency', 'address'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password'];

    /** Relationships */
    public function phone_contacts(){
        return $this->hasMany('Phone_Contact');
    }

    public function transactions(){
        return $this->hasMany('App\Transaction_log');
    }

    public function bank_accounts(){
        return $this->hasMany('App\Bank_account');
    }

    public function oauth_clients(){
        return $this->hasMany('App\Oauth_clients');
    }
}
