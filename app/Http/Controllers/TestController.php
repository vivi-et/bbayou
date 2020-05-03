<?php

namespace App\Http\Controllers;

use App\r;
use App\Post;
use Com\Tecnick\Barcode\Barcode;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Giftcon;
use DateTime;
use PDO;

class TestController extends Controller
{
    // 테스트 페이지 입니다.

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 테스트 설정
        $initOrderNo = 711113115;
        $initPost = Post::where('hasGiftconOrderNO', $initOrderNo)->first()->id;
        $getPostIDWithInit = Post::find($initPost);
        $fileNameToStore = $getPostIDWithInit->cover_image;


        $fileNameToStore = 'Screenshot_20200427-124526_KakaoTalk_1588416799.jpg';

        // 파일 불러옴
        $string = shell_exec('tesseract /home/viviet/bbayou/public/storage/cover_images/' . $fileNameToStore . ' stdout -l kor');

     
        preg_match('/(?:\d[ \-]*){12,16}/', $string, $barcodeNo);
        $barcodeNo[0] = preg_replace('/\D/', '', $barcodeNo[0]);

        // barcodeNo 가공

        // str_replace(' ','',$barcodeNo[0]);

        // if (preg_match('/\d\d\d\d \d\d\d\d \d\d\d\d \d\d\d\d/', $string, $barcodeNo));
        // else (preg_match('/\d\d\d\d \d\d\d\d \d\d\d\d/', $string, $barcodeNo));
        // preg_match('/\d\d\d\d \d\d\d\d \d\d\d\d \d\d\d\d/', $string, $barcodeNo);


        // $barcodeNo[0] =  wordwrap($barcodeNo[0], 4, ' ', true);

        //일부 글 날려버리기
        //하드코딩, 가능할경우 추후 개선
        $toRemove = '모바일교환권';
        if (substr_count($string, $toRemove))
            $string = str_replace($toRemove, '', $string);


        // 기프티콘 제목에 교환권, 교환처 등이 있을경우 제거
        $countEXCHANGE = substr_count($string, "교환");
        if ($countEXCHANGE == 2) {
            $findstr = "교환";
            $pos = strpos($string, $findstr);
            $string = substr_replace($string, '', $pos, strlen($findstr));
        }

        //문자열 $string 추가 가공
        $string = str_replace("\n", "\\n\n", $string);
        $string = str_replace("\t", "\\t\t", $string);

        //이게 왜있었지
        //@(.*?)[\s], @ to space 까지
        // $string = preg_replace('/교......../', '교환처', $string);

        // 뽑아낼 항목들 지정
        $cat[0] = '유효기간';
        $cat[1] = '주문번호';
        $cat[2] = '교환처';
        $cat[3] = '선물수신일';
        $cat[4] = '쿠폰상태';
        $cat[5] = '바코드';


        //특정 문자열(이경우 항목)을 분리하는 함수
        function get_string_between($string, $start, $end)
        {
            $string = ' ' . $string;
            $ini = strpos($string, $start);
            if ($ini == 0) return '';
            $ini += strlen($start);
            $len = strpos($string, $end, $ini) - $ini;
            return substr($string, $ini, $len);
        }



        // 년 월 도 string 날짜를 y m d date 형식으로 변경
        function strtodate($input)
        {
            if (substr_count($input, "년")) {
                $toRemove = array("년 ", "월 ", ".");
                $input = str_replace($toRemove, '-', $input);
                $input = mb_substr($input, 0, -1);
            } else {
                $input = str_replace('.', '-', $input);
            }
            $date = date_create_from_format('d/m/Y:H:i:s', $input);
            return $input;
        }



        //항목(cat[]) 이후 이어지는 값을 찾아서 catdata[]에 저장
        $nn = '\n';
        for ($i = 0; $i < 5; $i++) {
            $catdata[$i] = get_string_between($string, $cat[$i], $nn);
        }



        // $aa = 'false';

        // if (strpos($catdata[2], '뻬') || strpos($catdata[2], '태')) {
        //     $aa = 'true';
        // }

        // return $aa;



        //각 항목 마지막 가공 (아직 하드코딩, 개선바람)

        //catdata[0], 유통기한
        $key = array_search($cat[0], $cat);
        $catdata[0] = strtodate($catdata[$key]);


        $savedcatdata2 = $catdata[2];
        // catdata[2], 교환처
        if (strpos($catdata[2], '6525'))
            $catdata[2] = 'GS25';
        elseif (strpos($catdata[2], '7'))
            $catdata[2] = '7ELEVEN';
        elseif (strpos($catdata[2], '0'))
            $catdata[2] = 'CU';
        elseif (strpos($catdata[2], '뻬') || strpos($catdata[2], '태'))
            $catdata[2] = 'BHC';
        elseif (strpos($catdata[2], '개') && strpos($catdata[2], '웨'))
            $catdata[2] = '7ELEVEN/바이더웨이';
        else
            $catdata[2] = $savedcatdata2;

        //catdata[5], 바코드

        $catdata[5] = $barcodeNo[0];
        /*
        6525 : GS25
        CU : 0
        7ELELVEN : 76ㄷ1ㄴ6ㅁ0641
        BHC : 빼<   태ㅇ

        7ELEVEN/바이더웨이 : 개/64/바이더웨이

        */

        // $giftcon = Giftcon::find($orde)
        // $giftcon = DB::table('giftcons')->where('orderno',$orderno)->get('id');

        $giftconID = Giftcon::where('orderno', $initOrderNo)->first()->id;
        $giftcon = Giftcon::find($giftconID);


        //giftcon을 view에 보낼경우 개별 데이터 추출시 timeout 에러, 추후 해결
        //추후 코드 개선 요망, Eloquent::find() 로만 보내야 추출할수있음
        // $giftcon = Giftcon::where('orderno', '=', $orderno)->get();

        $barcode = new \Com\Tecnick\Barcode\Barcode();
        $bobj = $barcode->getBarcodeObj(
            'C128',                     // barcode type and additional comma-separated parameters
            $barcodeNo[0],          // data string to encode
            -1,                             // bar width (use absolute or negative value as multiplication factor)
            -90,                             // bar height (use absolute or negative value as multiplication factor)
            'black',                        // foreground color
            array(-1, -1, -1, -1)           // padding (use absolute or negative values as multiplication factors)
        )->setBackgroundColor('white'); // background color

        // output the barcode as HTML div (see other output formats in the documentation and examples)

        $package = [
            'cat' => $cat,
            'catdata' => $catdata,
            'giftcon' => $giftcon,
            'bobj' => $bobj,
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
    public function show(Giftcon $giftcon)


    {


        return view('test', compact('giftcon'));
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
