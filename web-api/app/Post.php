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
        'post_type_id',
        'suspended'
    ];

    protected $hidden = [
        'user_id', 'post_type_id'
    ];

    protected $with = ['post_type', 'user', 'comments', 'likes', 'tags', 'users_saved'];

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

    public function likes()
    {
        return $this->belongsToMany('App\User', 'post_like');
    }

    public function users_saved() {
        return $this->belongsToMany('App\User', 'post_user');
    }
}
