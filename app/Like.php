<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'posts_like';
    protected $fillable = [
        'post_id',
        'user_id',
    ];
    public function post()
    {
        return $this->belongsTo('App\Post','post_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
