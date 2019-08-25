<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class table_user_post extends Model
{
    protected $fillable = [
        
         'id', 'post', 'path'
    ];
    // protected $primaryKey = 'post_id';

    public function user()
    {
        return $this->belongsTo('App\user','id');
    }
    public function comment_user()
    {
        return $this->belongsTo('App\comment_user','id');
    }
    public function like_user()
    {
        return $this->belongsTo('App\like_user','id');
    }

}
