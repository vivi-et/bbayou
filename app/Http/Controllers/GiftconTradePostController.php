<?php

namespace App\Http\Controllers;

use App\GiftconTradePost;
use App\GiftconTradeComment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Giftcon;
use App\r;
use Illuminate\Support\Facades\Auth;

class GiftconTradePostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }


    public function index()
    {
        $user = Auth::user();

        $giftcons = GiftconTradePost::select('giftcons.*', 'users.name', 'giftcon_trade_posts.*')
            ->Join('giftcons', 'giftcons.id', '=', 'giftcon_trade_posts.giftcon_id')
            ->Join('users', 'users.id', '=', 'giftcon_trade_posts.user_id')
            ->get();



        // 바코드 생성기 개체
        // 결국 view에서 data를 처리하는데 맞는 설계인가?
        // ajax 없이 controller에서 foreach 마다 다르게 생성해줄수있는가
        // return $generator->getBarcode('946058883978', $generator::TYPE_CODE_128);

        //tasks
        return view('giftcontradepost.index')->with('giftcons', $giftcons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('giftcontradepost.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $giftcon = Giftcon::find($request)->first();
        $day = Carbon::now()->day;
        $month = Carbon::now()->month;



        // 같은날, 같은 사용자가, 중복된 기프티콘을 거래할려는지 확인
        // $whereClause = ['user_id' => Auth::user()->id, 'giftcon_id' => $giftcon->id];
        $results = GiftconTradePost::where('giftcon_id', '=', $giftcon->id)
            ->whereDay('created_at', '=', $day)
            ->whereMonth('created_at', '=', $month)
            ->get();

        if (count($results)) {
            return redirect()->back()->withErrors('error', '이미 등록하신 기프티콘입니다');
        } else {
            GiftconTradePost::create([
                'giftcon_id' => $giftcon->id,
                'user_id' => Auth::user()->id,
            ]);

            session()->flash('message', '기프티콘이 거래게시판에 등록되었습니다!');


            // $giftcons = GiftconTradePost::select('giftcon_trade_posts.*')
            // ->Join('giftcons', 'giftcons.id', '=', 'giftcon_trade_posts.giftcon_id')
            // ->get();

            return redirect()->back();
        }



        GiftconTradePost::create([
            'giftcon_id' => $giftcon->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show(GiftconTradePost $trade)
    {

        $thispost = $trade;

        $myGiftcons = Auth::user()->giftcons->where('on_trade', '!=', 1)->all();

        $giftcon = GiftconTradePost::select('giftcon_trade_posts.*', 'giftcons.*', 'users.name')
            ->Join('giftcons', 'giftcons.id', '=', 'giftcon_trade_posts.giftcon_id')
            ->Join('users', 'users.id', '=', 'giftcon_trade_posts.user_id')
            ->where('giftcon_trade_posts.id', '=', $thispost->id)
            ->first();


        // $comments = $thispost->comments;



        // for ($i = 0; $i < count($comments); $i++) {
        //     for ($j = 0; $j < 5; $j++) {
        //         $idx = 'giftcon_id' . ($j + 1);
        //         $commentGiftconsArrays[$i][$j] = $comments[$i]->$idx;
        //         if ($commentGiftconsArrays[$i][$j] === 0)
        //             unset($commentGiftconsArrays[$i][$j]);
        //     }
        // }


        // for ($i = 0; $i < count($comments); $i++) {
        //     for ($j = 0; $j < 5; $j++) {
        //         $idx = 'giftcon_id' . ($j + 1);
        //         $commentGiftconsArrays[$i][$j] = Giftcon::find($comments[$i]->$idx);
        //         if (empty($commentGiftconsArrays[$i][$j]))
        //             unset($commentGiftconsArrays[$i][$j]);
        //     }
        // }
        


        // return max(array_map('count', $commentGiftconsArrays));




        // return $commentGiftconsArrays[0][0]->user;

        // return $commentGiftconsArrays[];

        // return $commentGiftconsArrays;

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

        return view('giftcontradepost.show')
        ->with('giftcon', $giftcon)
        ->with('status', $status)
        ->with('myGiftcons', $myGiftcons)
        ->with('thispost', $thispost);
        // ->with('comments',$comments);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy(cr $cr)
    {
        //
    }
}
