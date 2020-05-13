<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Giftcon extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'barcode',
        'imagepath',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function GiftconTradeComments()
    {
        return $this->belongsTo(GiftconTradeComment::class);
    }


    
    public function GiftconTradePosts()
    {
        return $this->belongsToMany(GiftconTradePost::class);
    }



    



    
}
