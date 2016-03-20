<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{

    protected $dates = ['expiry_date'];


    public function user(){
        return $this->belongsTo('App\User');
    }

    public function recipients(){
        return $this->hasMany('App\FormRecipient');
    }

    public function respondents(){
        return $this->hasMany('App\FormRespondent');
    }
}
