<?php

namespace App\Http\Controllers;

use App\GiftconTradeComment;
use Illuminate\Support\Facades\Auth;
use App\Giftcon;
use App\GiftconTradePost;
use Illuminate\Http\Request;

class GiftconTradeCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        
        // 해야할것
        // GiftconTradeComment 생성
        // 주인 Giftcon 의 on trade 처리
        // 코멘트로 제시된 Giftcon 들의 on trade 처리
        $getThis = $request->this;
        $for = $request->for;


        for($i = 0; $i < 5; $i++){
            if(empty($for[$i]))
            $for[$i] = 0;
        }



        // $getThisGiftcon = Giftcon::find($getThis);
        // $getThisGiftcon->on_trade = 1;
        // $getThisGiftcon->save();


        // $forGiftcon = Giftcon::find($for);
        // $forGiftcon->on_trade = 1;
        // $forGiftcon->save();

        GiftconTradeComment::create([
            'giftcon_id1' => $for[0],
            'giftcon_id2' => $for[1],
            'giftcon_id3' => $for[2],
            'giftcon_id4' => $for[3],
            'giftcon_id5' => $for[4],
            'user_id'=> Auth::user()->id,
            'post_id'=> $request->post_id,
            'traded'=> 0,
            // 'created_at' => now(),
            // 'updated_at' => now(),

        ]);

        return response()->json([
            'message' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GiftconTradeComment  $giftconTradeComment
     * @return \Illuminate\Http\Response
     */
    public function show(GiftconTradeComment $giftconTradeComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GiftconTradeComment  $giftconTradeComment
     * @return \Illuminate\Http\Response
     */
    public function edit(GiftconTradeComment $giftconTradeComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GiftconTradeComment  $giftconTradeComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GiftconTradeComment $giftconTradeComment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GiftconTradeComment  $giftconTradeComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(GiftconTradeComment $giftconTradeComment)
    {
        //
    }
}
