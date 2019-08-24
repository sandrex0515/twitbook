<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class table_user_post extends Model
{
    protected $fillable = [
        'id', 'post', 'path'
    ];
}
