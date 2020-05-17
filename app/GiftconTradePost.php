<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftconTradePost extends Model
{
    protected $guarded = [];

    //
    public function giftcon()
    {
        return $this->hasMany(Giftcon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(GiftconTradeComment::class);
    }
}
