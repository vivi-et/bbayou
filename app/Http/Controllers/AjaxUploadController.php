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
            $path = $request->file('cover_image')->storeAs('public/temp_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
            return response()->json([
                'message'   => '이미지가 없습니다',
                'uploaded_image' => '$fileNameToStore',
            ]);
        }

        //OCR 실행, 텍스트 추출 
        $string = shell_exec('tesseract /home/viviet/bbayou/public/storage/temp_images/' . $fileNameToStore . ' stdout -l kor');

        //공백 포함 연속된 12~16개의 숫자를 저장 = 바코드번호
        preg_match('/(?:\d[ \-]*){12,16}/', $string, $barcodeNo);

        //연속된 9자리 숫자를 저장 = 주문번호
        preg_match('/\b\d{9}\b/', $string, $ocrorderno);

        //바코드 번호 이전 모든 문자를 삭제
        $expStr = explode($barcodeNo[0], $string);
        //바코드 번호사이 공백지우기
        $barcodeNo[0] = preg_replace('/\D/', '', $barcodeNo[0]);
        //expStr 1 offset 오류 상황재현 가능? // 해결됨
        $string = $barcodeNo[0] . $expStr[1];

        //교환처가 없고 저 로 나올떄
        //하드코딩(Hardcoding) 가능할경우 개선
        //인식률 상향 필요
        $hasPlace =  substr_count($expStr[1], '교환처');
        if(!$hasPlace){
       
            $string = str_replace('저','교환처',$string);
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
            // $date = date_create_from_format('d/m/Y:H:i:s', $input);
            return $input;
        }

        //catdata[] 입력
        //항목(cat[]) 이후 이어지는 값을 찾아서 catdata[]에 저장
        $nn = '\n';
        for ($i = 0; $i < 5; $i++) {
            $catdata[$i] = get_string_between($string, $cat[$i], $nn);
        }



        //catdata[0, 3], 유효기한, 받은날짜
        $catdata[0] = strtodate($catdata[0]);
        $catdata[3] = strtodate($catdata[3]);

        if(!$catdata[3]){
            $catdata[3] = null;
        }
        // $catdata[3] = date("Y-m-d");

        //catdata[1], 주문번호
        //regex 9자리가 아닌경우
        if (!empty($ocrorderno))
            $catdata[1] = $ocrorderno[0];


        // catdata[2], 교환처
        $savedcatdata2 = $catdata[2];

        // 하드코딩임, 가능할경우 개선
        if (strpos($catdata[2], '6525'))
            $catdata[2] = 'GS25';
        elseif (strpos($catdata[2], '7'))
            $catdata[2] = '7ELEVEN';
        elseif (strpos($catdata[2], '립'))
            $catdata[2] = '빕스';
        elseif (strpos($catdata[2], '0'))
            $catdata[2] = 'CU';
        elseif (strpos($catdata[2], '뻬') || strpos($catdata[2], '태'))
            $catdata[2] = 'BHC';
        elseif (strpos($catdata[2], '개') && strpos($catdata[2], '웨'))
            $catdata[2] = '7ELEVEN/바이더웨이';
        else
            $catdata[2] = $savedcatdata2;

        //빈 공백 쳐내기
        for ($i = 0; $i < 5; $i++) {
            $catdata[$i] = str_replace(' ', '', $catdata[$i]);
        }


        //catdata[4] 기프티콘 사용 여부 확인
        $used = 2;
        $usedstr = '미기재';
        if ($catdata[4] == '사용완료') {
            $used = 1;
            $usedstr = '사용완료';
        } elseif ($catdata[4] == '사용안함') {
            $used = 0;
            $usedstr = '사용안함';
        }

        //catdata[5], 바코드
        $catdata[5] = $barcodeNo[0];

        //바코드 4자리 단위로 분리
        $seperatedBarcode = wordwrap($barcodeNo[0], 4, ' ', true);

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



        //

        return response()->json([
            'message' => '성공!',
            'expire_date' => $catdata[0],
            'orderno' => $catdata[1],
            'place' => $catdata[2],
            'recieved_date' => $catdata[3],
            'used' => $used,
            'usedstr' => $usedstr,
            'barcode' => $catdata[5],
            'filepath' => $fileNameToStore,
            'sepbarcode' => $seperatedBarcode
        ]);
    }
}
