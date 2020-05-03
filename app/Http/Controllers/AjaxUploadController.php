<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class AjaxUploadController extends Controller

{
    function action(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        if ($validation->passes()) {
            $image = $request->file('cover_image');
            // $new_name = rand() . '.' . $image->getClientOriginalExtension();
            // $image->move(public_path('/storage/cover_images'), $new_name);


            //파일이름 & 확장자
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();

            //파일이름만
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //확장자만
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            //db에 저장할 파일이름
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;
            //이미지 업로드
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
            return response()->json([
                'message'   => $validation->errors()->all(),
                'uploaded_image' => '$fileNameToStore',
            ]);
        }



        //tesseract 실행
        $string = shell_exec('tesseract /home/viviet/bbayou/public/storage/cover_images/' . $fileNameToStore . ' stdout -l kor');

        if (preg_match('/\d\d\d\d \d\d\d\d \d\d\d\d \d\d\d\d/', $string, $barcodeNo));
        else (preg_match('/\d\d\d\d \d\d\d\d \d\d\d\d/', $string, $barcodeNo));
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
        $string = preg_replace('/교......../', '교환처', $string);


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

        //catdata[0, 3], 유통기한
        $key = array_search($cat[0], $cat);
        $catdata[0] = strtodate($catdata[$key]);
        $key = array_search($cat[3], $cat);
        $catdata[3] = strtodate($catdata[$key]);
        $catdata[3] = date("Y-m-d");




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
        //빈 공백 쳐내기
        for ($i = 0; $i < 5; $i++) {
            $catdata[$i] = str_replace(' ', '', $catdata[$i]);
        }

        //catdata[4] 기프티콘 사용 여부 확인
        $used = false;
        if ($catdata[4] == '사용완료') {
            $used = true;
        } elseif ($catdata[4] == '사용안함') {
            $used = false;
        }

        //catdata[5], 바코드
        preg_match('/(?:\d[ \-]*){12,16}/', $string, $barcodeNo);
        $barcodeNo[0] = preg_replace('/\D/', '', $barcodeNo[0]);
        $catdata[5] = $barcodeNo[0];


        // return response()->json([
        //     'message' => '성공!',
        //     'expire_date' => $catdata[0],
        //     'orderno' => $catdata[1],
        //     'place' => $catdata[2],
        //     'recieved_date' => $catdata[3],
        //     'used' => $catdata[4],
        //     'barcode' => $catdata[5],
        //     'filepath' => $fileNameToStore,
        // ]);

        return response()->json([
            'message' => '성공!',
            'expire_date' => $catdata[0],
            'orderno' => $catdata[1],
            'place' => $catdata[2],
            'recieved_date' => $catdata[3],
            'used' => $catdata[4],
            'barcode' => $catdata[5],
            'filepath' => $fileNameToStore,
        ]);
    }
}
