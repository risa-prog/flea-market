<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function member(){
        return $this->hasOne('App\Models\Member');
    }

    public function items(){
        return $this->hasMany('App\Models\Item');
    }

    public function likes(){
        return $this->hasMany('App\Models\Like');
    }

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    public function profile(){
        return $this->hasOne('App\Models\Profile');
    }

    public function transactionComments() {
        return $this->hasMany('App\Models\TransactionComment');
    }

    public function transactionReviews() {
        return $this->hasMany('App\Models\TransactionReview', 'reviewee_id');
    }
}
