<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftconTradeComment extends Model
{
    protected $guarded = [];

    //


    public function giftcons()
    {
        return $this->belongsToMany(Giftcon::class,'giftcon_giftcon_trade_comment', 'giftcon_id', 'giftcon_trade_comment_id');
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
