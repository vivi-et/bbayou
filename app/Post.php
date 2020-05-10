<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];
    // $fillable = whitelist
    // $guarded = blacklist
    
    public function user()
    //$comment->post->user
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function addComment($body)
    {
        // $this->comments() = all this post's comments
        $this->comments()->create(compact('body'));
    }

    public function tags()
    {
        return $this->belongsTo(Tag::class);
    }
}
