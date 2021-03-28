<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName','lastName','userName', 'email', 'password','avatar','cover','channelDescription','isAdmin'
    ];

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
     /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'avatar' => 'https://pngtree.com/freepng/black-default-avatar_5944719.html',
        'cover'=>'https://www.google.com/url?sa=i&url=https%3A%2F%2Fcodepen.io%2Ftag%2Fyoutube%2520progress%2520bar&psig=AOvVaw3suQuXh7hG8QrlLvkX6bTG&ust=1616842790255000&source=images&cd=vfe&ved=0CAIQjRxqFwoTCOiukPzmze8CFQAAAAAdAAAAABAD',


    ];


public function getJWTIdentifier()
{
    return $this->getKey();
}

public function getJWTCustomClaims()
{
    return [];
}
public function setPasswordAttribute($password)
{
    if ( !empty($password) ) {
        $this->attributes['password'] = bcrypt($password);
    }
}    
    public function video(){ return $this->hasMany(videos::class,'user_id');}

}