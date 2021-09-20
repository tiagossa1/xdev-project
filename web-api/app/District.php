<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    /*public function users()
    {
        //return $this->belongsToMany(User::class);
        return $this->hasMany(User::class);
    }*/
}
