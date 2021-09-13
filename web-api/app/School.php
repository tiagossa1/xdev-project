<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function school_classes()
    {
        return $this->hasMany(SchoolClass::class);
    }
}
