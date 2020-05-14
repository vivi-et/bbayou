<?php

namespace App\Http\Controllers;

use App\GiftconTradeComment;
use Illuminate\Support\Facades\Auth;
use App\Giftcon;
use App\GiftconTradePost;
use App\giftcon_comment;
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
        $getThis = $request->this;  //이걸 팝니다 Post
        $for = $request->for;       //이걸로 삽니다 Comment

        $comment = GiftconTradeComment::create([
            'user_id' => Auth::user()->id,
            'giftcon_trade_post_id' => $request->post_id,
            'traded' => 0,
        ]);


        $comment->giftcons()->sync($for);

        
       
        // 해야할것
        // GiftconTradeComment 생성
        // 주인 Giftcon 의 on trade 처리
        // 코멘트로 제시된 Giftcon 들의 on trade 처리


        // for ($i = 0; $i < count($for); $i++) {
        //     giftcon_comment::create([
        //         'giftcon_id' => $for[$i],
        //         'giftcon_trade_comment_id' => $comment->id,

        //     ]);
        // }

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
