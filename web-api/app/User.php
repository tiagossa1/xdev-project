<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password','user_type'
    ];

    protected $hidden = [
        'password', 'remember_token', 'pivot',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }
}
