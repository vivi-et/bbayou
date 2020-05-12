<?php

namespace App\Http\Controllers;

use App\r;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\GiftconTradePost;
use App\Giftcon;
use App\User;
use Picqer\Barcode\BarcodeGeneratorPNG;

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



        $user = Auth::user();

        $giftcons = GiftconTradePost::select('giftcons.*', 'users.name' ,'giftcon_trade_posts.*' )
        ->Join('giftcons', 'giftcons.id', '=', 'giftcon_trade_posts.giftcon_id')
        ->Join('users', 'users.id', '=', 'giftcon_trade_posts.user_id')
        ->get();



        // $giftcons = Giftcon::latest()->get();

        //tasks
        return view('giftcon.index', compact('giftcons'));
    }

    public function mygiftcons()
    {

        $giftcons = Auth::user()->giftcons->reverse();

        return view('giftcon.mygiftcons')->with('giftcons', $giftcons);
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
    public function edit(Giftcon $giftcon)
    {

        //

        // $seperatedBarcode = wordwrap($barcodeNo[0], 4, ' ', true);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Giftcon $giftcon)
    {
        //기프티콘 사용처리할것

        $generator = new BarcodeGeneratorPNG();
        $barcodeno = $giftcon->barcode;
        $downloadAs = $giftcon->title . '_' . $giftcon->id . '.jpg';

        $base64image = base64_encode($generator->getBarcode($barcodeno, $generator::TYPE_CODE_128, 2, 100));
        $seperatedBarcode = wordwrap($giftcon->barcode, 4, ' ', true);

        $giftcon->used = 1;
        $giftcon->save();


        return response()->json([
            'barcode' => $base64image,
            'barcodeno' => $seperatedBarcode,
            'downloadAs' => $downloadAs,
        ]);
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
