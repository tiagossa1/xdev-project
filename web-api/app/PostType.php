<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
    protected $fillable = [
        'name',
        'iconName'
    ];

    public $timestamps = false;

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
