<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftconTradePost extends Model
{
    protected $guarded = [];

    //
    public function giftcon()
    {
        return $this->has(Giftcon::class);
    }


}
