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
        'password', 'remember_token', 'pivot', 'district_id', 'school_class_id', 'user_type_id', 'deleted_at', 'email_verified_at'
    ];

    public function getProfilePictureAttribute() {
        if(!is_null($this->attributes["profile_picture"])) {
            $path = dirname(public_path(), 1) . '/' . $this->attributes['profile_picture'];
            $value = base64_encode(file_get_contents($path));
            return $value;
        }

        return $this->attributes["profile_picture"];
    }

    public function setProfilePicture($profile_picture_path) {
        $path = dirname(public_path(), 1) . '/' . $profile_picture_path;

        $value = base64_encode(file_get_contents($path));

        $this->attributes['profile_picture'] = $value;
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
