<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormRecipients extends Model
{

    protected $dates = ['expiry_date'];

    public function form(){
        return $this->belongsTo('App\Form');
    }
}
