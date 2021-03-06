<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackType extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
