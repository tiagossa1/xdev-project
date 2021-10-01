<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'reason',
        'post_id',
        'user_id',
        'post_comment_id'
    ];

    protected $hidden = [
        'user_id', 'post_id', 'post_comment_id'
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->belongsTo(Comment::class);
    }
}
