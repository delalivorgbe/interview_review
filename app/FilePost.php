<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilePost extends Model
{
    protected $fillable = ['id', 'name', 'path'];
}
