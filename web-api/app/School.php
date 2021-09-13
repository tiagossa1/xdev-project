<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public $timestamps = false;

    use softDeletes;

    public function school_classes()
    {
        return $this->hasMany(SchoolClass::class);
    }
}
