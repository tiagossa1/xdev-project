<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'email', 'name', 'birth_date', 'password', 'github_url', 'linkedin_url', 'facebook_url', 'instagram_url', 'district_id', 'user_type_id', 'school_class_id'
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

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
