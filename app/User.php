<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\MailResetPasswordNotification;

//class User extends Authenticatable implements JWTSubject
class User extends AuthenticatableForUser implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',  'last_name', 'email', 'password','phone','gender', 'avatar', 'status','type','address','birth_date',
        'provider_id', 'provider','access_token'
    ];
   

    public function sendPasswordResetNotification($token){

        $this->notify(new MailResetPasswordNotification($token));
    }
    public function sendEmailVerificationNotification(){

        $this->notify(new VerifyEmail);
    }
    public function posts(){
        return $this->hasMany('App\Models\Post');
    }
    public function favorites(){
        return $this->hasMany('App\Models\Favorite');
    }
    public function users_views(){
        return $this->hasMany('App\Models\UserView');
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
   
}
