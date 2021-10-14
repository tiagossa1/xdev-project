<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    protected $fillable = [
        'description',
        'user_id',
        'post_id'
    ];

    protected $hidden = [
        'user_id', 'post_id'
    ];

    protected $with = ['user', 'post'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
