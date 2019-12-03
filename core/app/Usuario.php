<?php

namespace App;



use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'z1_usuarios';
    public $timestamps = false;
    protected $guarded = [];

    protected $hidden = [
        'password','remember_token'
    ];
}
