<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostPhoto extends Model
{
    protected $fillable = [
        'url',
        'post_id',
    ];

    public $timestamps = false;

    public function posts()
    {
        return $this->belongsTo(Post::class);
    }
}
