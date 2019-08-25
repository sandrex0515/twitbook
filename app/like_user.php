<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class like_user extends Model
{
    protected $fillable = [
        'like_id' 
    ];

    public function table_user_post()
    {
        return $this->belongsTo('App\table_user_post','id');
    }
    public function user()
    {
        return $this->belongsTo('App\user','id');
    }
    public function comment_user()
    {
        return $this->belongsTo('App\comment_user','id');
    }
   
}
