<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'pivot', 
    ];
//'posts_count'
    // protected $with = ['posts'];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
