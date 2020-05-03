<?php

namespace App\Http\Controllers;

use App\r;
use App\Post;
use Illuminate\Http\Request;

class GiftconController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->get();
        //tasks
        return view('giftcon.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {



        // Post::create([
        //     'title' => request('title'),
        //     'body' => request('body'),
        //     'body' => request('title'),
        //     // 'body' => $a,
        //     'user_id' => auth()->id(),
        //     'hasGiftconOrderNO' => (int) $catdata[1],
        //     'cover_image' => $fileNameToStore,

        //     //auto saved!
        // ]);


        return view('giftcon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        Giftcon::create([
            'expire_date' => request('expire_date'),
            'orderno' => (int) request('orderno'),
            'place' => request('place'),
            'recieved_date' => request('recieved_date'),
            'used' => request('used'),
            'user_id' => auth()->id(),
            'barcode' => request('barcode'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function show(r $r)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function edit(r $r)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, r $r)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function destroy(r $r)
    {
        //
    }
}
