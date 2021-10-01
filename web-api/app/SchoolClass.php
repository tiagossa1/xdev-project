<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = [
        'name',
        'school_id'
    ];

    protected $hidden = [
        'school_id'
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
