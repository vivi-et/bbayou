<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
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

        $posts = Post::latest()->get()->take(6);
        $giftcons = Giftcon::latest()->get()->take(6);
        return view('home', compact('giftcons'));
    }
}
