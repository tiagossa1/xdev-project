<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $fillable = [
        'name',
        'hexColorCode'
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
