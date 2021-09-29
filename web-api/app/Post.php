<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'post_type_id'
    ];

    protected $hidden = [
        'pivot',
    ];

    public function post_type()
    {
        return $this->belongsTo(PostType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function post_photos(){
        return $this->hasMany(PostPhoto::class);
    }

    use softDeletes;
}
