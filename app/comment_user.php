<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comment_user extends Model
{
    protected $fillable = [
        'comment_id'
    ];

    public function table_user_post()
    {
        return $this->belongsTo('App\table_user_post','id');
    }
    public function user()
    {
        return $this->belongsTo('App\user','id');
    }
    public function like_user()
    {
        return $this->belongsTo('App\like_user','id');
    }
}
