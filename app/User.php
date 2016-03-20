<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;


class User extends Model implements Authenticatable
{

    use \Illuminate\Auth\Authenticatable;

    public function forms(){
        return $this->hasMany('App\Form');
    }

    public function respondents(){
        return $this->hasMany('App\FormRespondent');
    }

}
