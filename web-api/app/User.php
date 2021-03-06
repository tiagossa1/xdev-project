<?php

namespace App;

use Illuminate\Contracts\Auth\CanResetPassword;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, Notifiable;

    protected $with = ["district", 'school_class', "user_type", 'tags'];

    protected $fillable = [
        'suspended', 'email', 'name', 'birth_date', 'password', 'github_url', 'linkedin_url', 'facebook_url', 'instagram_url', 'district_id', 'user_type_id', 'school_class_id'
    ];

    protected $hidden = [
        'password', 'remember_token', 'pivot', 'district_id', 'school_class_id', 'user_type_id', 'deleted_at', 'email_verified_at'
    ];

    public function scopeIsModerator($query) {
        return $query->whereIn('user_type_id', [2,4]);
    }

    public function scopeIsSheriff($query) {
        return $query->where('user_type_id', 3);
    }

    public function scopeIsFromTheSameClass($query, $schoolClassId) {
        //$userSchoolClass = Auth::user()->school_class->id;
        return $query->where('school_class_id', $schoolClassId);
    }

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
        return $this->belongsToMany(Tag::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function favorite_posts()
    {
        return $this->belongsToMany('App\Post', 'post_user');
    }

    public function liked_posts()
    {
        return $this->belongsToMany('App\Post', 'post_like');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function school_class()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function user_type()
    {
        return $this->belongsTo(UserType::class);
    }

}
