<?php

namespace App\Models;

use Chimak\Autorisation\Models\Profile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username','password','phone','birth_date','photo','status'
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
    protected $dates = ['birth_date'];

    /**
     * @param $name
     */
    public function setNameAttribute($name){
        $this->attributes['name'] = strtoupper($name);
    }

    /**
     * @param $login
     */
    public function setUsernameAttribute($login){
        $this->attributes['username'] = strtolower($login);
    }

    /**
     * @param $email
     */
    public function setEmailAttribute($email){
        $this->attributes['email'] = strtolower($email);
    }

    /***
     * Association Entre les Modèles    pages (1,n) et Profil (1.n)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * @since    Disponible depuis la version 1.0.0
     * @author   KOUA A. Michel <michel.koua@fpmnet.ci>
     *
     * @version  1.0.0
     */
    public function profiles()
    {
        return $this->belongsToMany(Profile::class)
            ->withPivot('profile_opened_at', 'profile_closed_at','profile_user_status')
            ->withTimestamps();
    }

    public function profilesActifs()
    {
        return $this->belongsToMany(Profile::class)
            ->withPivot('profile_opened_at', 'profile_closed_at','profile_user_status')
            ->withTimestamps()
            ->where('profile_status',1)
            ->wherePivot('profile_user_status',1);
    }

    /**
     * Cette méthode vérifie que l'utilisateur connecté a un profils donné
     *
     * @copyright  Copyright (c) 2017 Fonds de Prévoyance Militaire. (http://www.fpmnet.ci)
     * @license     BSD License
     * @version    Version  1.0.0
     * @since      Cette Méthode est disponible depuis la version 1.0.0
     * @author     KOUA A. Michel <michel.koua@fpmnet.ci>
     * @var array|string $profil<profils ou liste de profils>
     * @return boolean
     */

    public function hasProfile($profil)
    {
        if(is_string($profil)) {

//            return $this->profiles->contains('profile_name', $profil);
            return $this->profilesActifs->contains('profile_name', $profil);
        }
        return !! $profil->intersect($this->profilesActifs)->count();
//        return !! $profil->intersect($this->profiles)->count();
    }

}
