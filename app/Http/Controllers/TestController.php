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
        // 1588022438127-3_1588600236.jpg


        // $src = 'storage/cover_images/1588022438127-3_1588600236.jpg';

        // $filename = $src;
        // $percent = 0.5;
        
        // list($width, $height) = getimagesize($filename);
        
        // $new_width  = 730;
        // $new_height = 665;
        
        // $image_p = imagecreatetruecolor($new_width, $new_height);
        // $image = imagecreatefromjpeg($filename);
        
        // $a = imagecopyresampled($image_p, $image, 0, 0 , 31 , 36 , $new_width, $new_height, $new_width, $new_height);
        // // Outputs the image
        // header('Content-Type: image/jpeg');
        // // imagejpeg($image_p, null, 100);
        // $fileNameToStore = time() . '.' . 'jpg';
        // imagejpeg($image_p, "storage/cover_images/".$fileNameToStore);
        // // $path = $image_p->storeAs('public/cover_images', $fileNameToStore);


        // return $a;

       






        $callfromDB = 0;
        // 테스트 설정
        // if ($callfromDB = 1) {
        //     $initOrderNo = 516459089;
        //     $initPost = Post::where('hasGiftconOrderNO', $initOrderNo)->first()->id;
        //     $getPostIDWithInit = Post::find($initPost);
        //     $fileNameToStore = $getPostIDWithInit->cover_image;
        // }

        //1588022438127-6_1588591104.jpg 안됨 해결요망
        //1588022438127-6_1588591104.jpg 안됨 해결요망
        //1588022438127-6_1588591104.jpg 안됨 해결요망

        $fileNameToStore = '1588022438127-10_1588598745.jpg';

        // 파일 불러옴
        $string = shell_exec('tesseract /home/viviet/bbayou/public/storage/cover_images/' . $fileNameToStore . ' stdout -l kor');


        // 공백 포함 연속된 12~16개의 숫자를 저장 = 바코드번호
        preg_match('/(?:\d[ \-]*){12,16}/', $string, $barcodeNo);
        $barcodeWithSpace = $barcodeNo[0];
        $expStr = explode($barcodeNo[0], $string);
        $barcodeNo[0] = preg_replace('/\D/', '', $barcodeNo[0]);



        //연속된 9자리 숫자를 저장 = 주문번호
        //범위로 찾을경우 바코드 번호랑 겹칠수도 있음
        //추가 explode 를 통해 해결가능해보임
        preg_match('/\b\d{9}\b/', $string, $ocrorderno);


        //바코드 번호 이전 모든 문자를 삭제
        $string = $barcodeNo[0] . $expStr[1];

        //교환처가 없고 저 로 나올떄
        //인식률 상향 필요
        $hasPlace =  substr_count($expStr[1], '교환처');
        if (!$hasPlace) {

            $string = str_replace('저', '교환처', $string);
        }

        //특정 오타 교정
        // 하드코딩, 가능할경우 추후 개선필요
        // 날짜형식으로 분홍,노랑 기프티콘 분류 가능한지?
        // (노랑 기프티콘) = y년 m월 d일
        // (분홍 기프티콘) = y.m.d
        $findthis = "교헌제";
        $countEXCHANGE = substr_count($string, $findthis);
        if ($countEXCHANGE) {
            $pos = strpos($string, $findthis);
            $string = substr_replace($string, '교환처', $pos, strlen($findthis));
        }



        // barcodeNo 가공

        // str_replace(' ','',$barcodeNo[0]);

        // if (preg_match('/\d\d\d\d \d\d\d\d \d\d\d\d \d\d\d\d/', $string, $barcodeNo));
        // else (preg_match('/\d\d\d\d \d\d\d\d \d\d\d\d/', $string, $barcodeNo));
        // preg_match('/\d\d\d\d \d\d\d\d \d\d\d\d \d\d\d\d/', $string, $barcodeNo);


        // $barcodeNo[0] =  wordwrap($barcodeNo[0], 4, ' ', true);

        //일부 글 날려버리기
        //하드코딩, 가능할경우 추후 개선




        // 기프티콘 제목에 교환권, 교환처 등이 있을경우 제거
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
        // $key = array_search($cat[0], $cat);
        $catdata[0] = strtodate($catdata[0]);

        //catdata[1], 주문번호
        //regex 9자리가 아닌경우
        if (!empty($ocrorderno))
            $catdata[1] = $ocrorderno[0];


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

        //바코드 4자리 단위로 분리
        $seperatedBarcode = wordwrap($barcodeNo[0], 4, ' ', true);


        // $giftcon = Giftcon::find($orde)
        // $giftcon = DB::table('giftcons')->where('orderno',$orderno)->get('id');

        // $giftconID = Giftcon::where('orderno', $initOrderNo)->first()->id;
        // $giftcon = Giftcon::find($giftconID);


        //giftcon을 view에 보낼경우 개별 데이터 추출시 timeout 에러, 추후 해결
        //추후 코드 개선 요망, Eloquent::find() 로만 보내야 추출할수있음
        // $giftcon = Giftcon::where('orderno', '=', $orderno)->get();

        //바코드 생성기
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
            // 'giftcon' => $giftcon,
            'bobj' => $bobj,
            'path' => $fileNameToStore,
            'sepCode' => $seperatedBarcode
        ];

        return view('test4');
        // return view('test', compact('package'));
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
