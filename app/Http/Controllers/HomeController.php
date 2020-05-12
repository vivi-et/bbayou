<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\GiftconTradePost;
use App\Giftcon;
use SebastianBergmann\Environment\Console;
use thiagoalessio\TesseractOCR\TesseractOCR;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $giftcons = GiftconTradePost::select('giftcon_trade_posts.*', 'giftcons.*', 'users.name')
        ->Join('giftcons', 'giftcons.id', '=', 'giftcon_trade_posts.giftcon_id')
        ->Join('users', 'users.id', '=', 'giftcon_trade_posts.user_id')
        ->get()->take(6);


        $posts = Post::latest()->get()->take(6);
        return view('home')->with('giftcons', $giftcons);
    }
}
