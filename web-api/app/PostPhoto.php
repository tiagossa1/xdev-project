<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostPhoto extends Model
{
    protected $fillable = [
        'url',
        'post_id',
    ];

    protected $hidden = [
        'post_id', 'post.suspended'
    ];

    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

}
