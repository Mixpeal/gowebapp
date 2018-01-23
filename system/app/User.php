<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable

{


    protected $fillable = [

        'name', 'email', 'password','twitter_id'

    ];


    protected $hidden = [

        'password', 'remember_token',

    ];


    public function addNew($input)

    {

        $check = static::where('twitter_id',$input['twitter_id'])->first();


        if(is_null($check)){

            return static::create($input);

        }


        return $check;

    }

}