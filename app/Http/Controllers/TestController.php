<?php

namespace App\Http\Controllers;

use App\r;
use Illuminate\Http\Request;
use App\Giftcon;
use DateTime;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $string = '0""의1 오후 5:08 8 80%68「\n \n < ^×\n \n 스타벅스\n \n 아이스 카페모카 13||\n \n @ 08) 카카오페이로 추가결제\n \n 965632070036 =\n \n 유효기간 2019년 5월 29일\n \n 주문번호 563974109\n \n 교환처 스타벅스\n \n 선물수신일 2019년 2월 25일\n \n 쿠폰상태 사용완료\n \n 고객센터 :@상담하기: 2 문의하기 ： 도움말\n 교환권 취소/환불 안내\n \n \n';

        $fileNameToStore = '1588022438127-8_1588132866.jpg';
        $string = shell_exec('tesseract /home/viviet/bbayou/public/storage/cover_images/' . $fileNameToStore . ' stdout -l kor');


        $string = str_replace("\n", "\\n\n", $string);
        $string = str_replace("\t", "\\t\t", $string);

        // $arr = explode('\n', $string);
        // $arr = explode('유효기간', $string, 1);
        // $arr = explode('주문번호', $string);
        // $arr = explode('교환처', $string);
        // $arr = explode('선물수신일', $string);
        // $arr = explode('쿠폰상태', $string);


        // $key[0] = array_search('유효기간', $arr);
        // $key[1] = array_search('주문번호', $arr);
        // $key[2] = array_search('교환처', $arr);
        // $key[3] = array_search('선물수신일', $arr);
        // $key[4] = array_search('쿠폰상태', $arr);

        $nn = '\n';


        $cat[0] = '유효기간';
        $cat[1] = '주문번호';
        $cat[2] = '교환처';
        $cat[3] = '선물수신일';
        $cat[4] = '쿠폰상태';


        // 'orderno' => '주문번호',
        // 'location' => '교환처',
        // 'recieved' => '선물수신일',
        // 'status' => '선물수신일'

        // Giftcon::create([
        //     'title' => request('title'),
        //     'body' => request('body'),
        //     'body' => $a,
        //     'user_id' => auth()->id(),
        //     'cover_image' => $fileNameToStore,


        // ]);

        function get_string_between($string, $start, $end)
        {
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }




        function strtodate($input)
        {
            $toRemove = array("년 ", "월 ", ".");
            $input = str_replace($toRemove, '-', $input);
            $input = mb_substr($input, 0, -1);
            $input = date("y-m-d", strtotime($input));
            return $input;
        }


        for ($i = 0; $i < 5; $i++) {
            $catdata[$i] = get_string_between($string, $cat[$i], $nn);
        }
        $key = array_search($cat[0],$cat);
        $catdata[0] = strtodate($catdata[$key]);

        // foreach ($cat as $c) {
        //     $c = get_string_between($string, $c, $nn);
        // }


        // return $cat;

        $text = $cat;

        // Giftcon::create([
        //     'title' => request('title'),
        //     'body' => request('body'),
        //     'body' => $a,
        //     'user_id' => auth()->id(),
        //     'cover_image' => $fileNameToStore,


        // ]);



        // $res = $text;


        $package = [
            'cat' => $cat,
            'catdata' => $catdata
        ];


        return view('test', compact('package'));
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
        //
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
