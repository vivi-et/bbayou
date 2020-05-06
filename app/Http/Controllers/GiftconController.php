<?php

namespace App\Http\Controllers;

use App\r;
use App\Post;
use Illuminate\Http\Request;
use App\Giftcon;
use App\User;

class GiftconController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $giftcons = Giftcon::latest()->get();

        //tasks
        return view('giftcon.index', compact('giftcons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


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

        $this->validate(request(), [
            'title' => 'required|max:30'
        ]);


        Giftcon::create([
            'title' => request('title'),
            'expire_date' => request('expire_date'),
            'orderno' => (int) request('orderno'),
            'place' => request('place'),
            'recieved_date' => request('recieved_date'),
            'used' => request('used'),
            'barcode' => request('barcode'),
            'imagepath' => request('filepath'),
            'user_id' => auth()->id(),
        ]);



        session()->flash('message', 'Giftcon Created!');


        $giftcons = Giftcon::latest()->get();
        return redirect('giftcon')->with('giftcons');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function show(Giftcon $giftcon)
    {
        $status = $giftcon->used;

        switch ($status) {
            case 0;
                $status = '사용안함';
                break;
            case 1;
                $status = '사용함';
                break;
            case 2;
                $status = '미기재';
                break;
        }

        return view('giftcon.show')->with('giftcon', $giftcon)->with('status', $status);
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
