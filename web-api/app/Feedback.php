<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'user_id',
        'feedback_type_id',
        'description'
    ];

    public $timestamps = false;

    public function feedback_type()
    {
        return $this->belongTo(FeedbackType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
