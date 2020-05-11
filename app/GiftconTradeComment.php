<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftconTradeComment extends Model
{
    protected $guarded = [];

    //
    public function tradePost()
    {
        return $this->hasMany(GiftconTradePost::class);
    }

    public function gitcons()
    {
        return $this->hasMany(Giftcon::class);
    }
}
