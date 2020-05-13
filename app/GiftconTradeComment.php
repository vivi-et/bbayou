<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftconTradeComment extends Model
{
    protected $guarded = [];

    //


    public function giftcons()
    {
        return $this->hasMany(Giftcon::class);
    }

    public function user()
    //$comment->post->user
    {
        return $this->belongsToMany(User::class);
    }

    public function post()
    //$comment->post->user
    {
        return $this->belongsTo(GiftconTradePost::class);
    }
}
