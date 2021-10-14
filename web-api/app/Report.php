<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'reason',
        'post_id',
        'user_id',
        'comment_id',
        'closed',
        'moderator_id',
        'report_conclusion_id'

    ];

    protected $hidden = [
        'user_id', 'post_id', 'comment_id', 'moderator_id', 'report_conclusion_id'
    ];

    protected $with = ["post", 'user', 'comment', 'report_conclusion', 'moderator'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function report_conclusion()
    {
        return $this->belongsTo(ReportConclusion::class);
    }

    public function moderator()
    {
        return $this->belongsTo('App\User', 'moderator_id');
    }
}
