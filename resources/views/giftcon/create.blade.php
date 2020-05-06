@extends('layouts.master')

@section('content')

{{ Session::forget('key') }}
<h1>
    기프티콘 등록
</h1>

<br>
<hr>
<div class="row">
    <div id="firstSm" class="col-sm" style="text-align: center">
        <form id="main_form" method="POST" action="/post" enctype="multipart/form-data">
            @csrf
            <div style="display: inline-block;">
                <img id="img_prv" style="max-height: 500px; max-width:300 px; " src="/storage/noimage.png"
                    class="img-thumbnail">
            </div>



            <input type="file" id="cover_image" name='cover_image' style="display:none;">
            <div>(2mb 이내인 jpg, jpeg, png 파일만 가능합니다.)</div>
            <br>

            <label id="label_test" for="cover_image" class="btn btn-primary" style="width:300px;">기프티콘 업로드</label>
            <div id='mgs_ta'>

            </div>
            <div class="form-group">
                <button type="submit" id="submitbtn" class="btn btn-primary" style="width:300px;">기프티콘 확인</button>
            </div>
        </form>

        <div id="modalButtonWrapper" style="display: none;">
            <button id="btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"
                style="width:300px;">
                상품이미지 등록
            </button>
        </div>
        <br>

        {{-- asdfasdfa;fjasdl;fjaskdl;fjl --}}


    </div>

    <div class="col-sm" style="text-align: center" id="result_col_sm">
        <form id="giftcon-form" action="/giftcon" method="POST">

            <table id="result-table" class="table">

                <tr>
                    <td>
                        상품명
                    </td>
                    <td>
                        <input id="title" name="title">
                    </td>

                </tr>

            </table>

            @csrf
            {{-- <input id="title" name="title" hidden> --}} 
            <input id="expire_date" name="expire_date" hidden>
            <input id="orderno" name="orderno" hidden>
            <input id="place" name="place" hidden>
            <input id="recieved_date" name="recieved_date" hidden>
            <input id="used" name="used" hidden>
            <input id="barcode" name="barcode" hidden>
            <input id="filepath" name="filepath" hidden>
            <br>
            <div id="croppedWarpper" style="display: none;">
                <img src="" id="cropped">
            </div>
            <br>
            <div class="form-group">
                <button type="submit" id="finalsubmitbtn" class="btn btn-primary">기프티콘 등록</button>
        </form>
        <br>
    
    </div>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">상품 이미지를 선택해주세요</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="/storage/temp_images/1587974964455-4_1588712682.png" id="cropbox">
                <!-- This is the image we're attaching Jcrop to -->

                <!-- This is the form that our event handler fills -->
                <div style="display: none;">
                <form onsubmit="return false;" class="coords">
                    @csrf
                    <label>X1 <input type="text" size="4" id="x1" name="x1" /></label>
                    <label>Y1 <input type="text" size="4" id="y1" name="y1" /></label>
                    <label>X2 <input type="text" size="4" id="x2" name="x2" /></label>
                    <label>Y2 <input type="text" size="4" id="y2" name="y2" /></label>
                    <label>W <input type="text" size="4" id="w" name="w" /></label>
                    <label>H <input type="text" size="4" id="h" name="h" /></label>
                </form>
            </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                <button type="button" id="modal-submit" class="btn btn-primary">확인</button>
            </div>
        </div>
    </div>

</div>







@include('layouts.error')


@endsection

@push('headertest')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/js/Jcrop.js"></script>
<link rel="stylesheet" href="http://jcrop-cdn.tapmodo.com/v2.0.0-RC1/css/Jcrop.css" type="text/css">
@endpush

@push('script')

{{-- 모달 이미지 편집후 확인버튼 누를시 --}}
<script type="text/javascript">
    $("#modal-submit").click(function(e) {
        // e.preventDefault();

        var x = document.getElementById('x1').value;
        var y = document.getElementById('y1').value;
        var width = document.getElementById('w').value;
        var height = document.getElementById('h').value;
        var originalImagePath = document.getElementById('filepath').value;

        console.log(originalImagePath);
        console.log('from modalguy');

        $.ajax({
            type: "POST",
            url: "{{ route('ajaxupload.crop') }}",
            dataType: 'JSON',
            data: {
                'x': x,
                'y': y,
                'width': width,
                'height': height,
                'originalImagePath': originalImagePath
            },
            // contentType: false,
            // cache: false,
            // processData: false,

            success: function(data) {
                $('#myModal').modal('toggle');

                var crop = data.croppedImagePath;
                var croppedWarpper = document.getElementById("croppedWarpper");
                croppedWarpper.style.display = "block";
                document.getElementById("cropped").src = "/storage/giftcon_images/" + crop;
                document.getElementById("filepath").value = crop;
                // var x = document.getElementById("img_prv");
                // x.style.display = "block";

                // alert(data.ext);



            }
        });
    });
</script>

{{-- file preview --}}
<script type="text/javascript">
    var x = document.getElementById("img_prv");
    if (x.style.display === "none") {
        x.style.display = "block";

    } else {
        x.style.display = "none";
    }
    $('#cover_image').on('change', function(ev) {

        console.log("here inside");
        var filedata = this.files[0];
        var imgtype = filedata.type;
        var match = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!((imgtype == match[0]) || (imgtype == match[1]) || (imgtype == match[2]))) {
            $('#mgs_ta').html('<p style="color:red"> jpg, jpeg, png 파일만 업로드가 가능합니다. </p>')
            x.style.display = "none";
        } else {
            var reader = new FileReader();
            reader.onload = function(ev) {
                $('#img_prv').attr('src', ev.target.result)
                var x = document.getElementById("img_prv");
                x.style.display = "block";


            }
            reader.readAsDataURL(this.files[0]);
        }

        var submitbtn = document.getElementById("submitbtn");
        submitbtn.disabled = false;
        submitbtn.style.visibility = "visible";

        document.getElementById("label_test").innerHTML = "다른 기프티콘 업로드";


    });
</script>

{{-- css 스타일 --}}
<style>
    #result-table td {
        width: 300px;
    }

    .cropper-crop {}
</style>


{{-- JS 스타일 --}}
<script>
    // finalsubmitbtn 크기 관련
    $(document).ready(function() {
        $("#finalsubmitbtn").css({
            'width': ($("#result_col_sm").width() + 'px')
        });
    });

    // submitbtn 보이기
    var submitbtn = document.getElementById("submitbtn");
    submitbtn.disabled = true;
    submitbtn.style.visibility = "hidden";
</script>

{{-- AJAX용 CSRF 토큰 --}}
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

{{-- 기프티콘 확인 관련 JS/AJAX --}}
<script>
    $(document).ready(function() {

        var finalsubmitbtn = document.getElementById("result_col_sm");
        var modalButtonWrapper = document.getElementById("modalButtonWrapper");
        if (finalsubmitbtn.style.display === "none") {
            finalsubmitbtn.style.display = "block";
        } else {
            finalsubmitbtn.style.display = "none";
        }

        $('#main_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: "{{ route('ajaxupload.action') }}",
                method: "POST",
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {

                    console.log('ajax json recieved');


                    let ajaxData = [
                        data.expire_date,
                        data.orderno,
                        data.place,
                        data.recieved_date,
                        data.usedstr,
                        data.sepbarcode,
                        data.filepath,

                    ];

                    // alert(data.filepath);
                    getImage(data.filepath);

                    let ajaxCat = [
                        "expire_date",
                        "orderno",
                        "place",
                        "recieved_date",
                        "used",
                        "barcode",
                        "filepath",

                    ];

                    let ajaxText = [
                        "유효기한",
                        "주문번호",
                        "교환처",
                        "선물수신일",
                        "쿠폰상태",
                        "바코드",
                        "파일명//추후삭제",
                    ];


                    let table = document.getElementById("result-table");



                    if (table.rows.length > 2) {
                        while (table.rows.length > 1) table.deleteRow(1);
                    }

                    let i = ajaxData.length;
                    while (i >= 0) {

                        console.log(i);
                        if (ajaxData[i]) {

                            var row = table.insertRow(1);
                            var cell1 = row.insertCell(0);
                            var cell2 = row.insertCell(1);
                            cell1.innerHTML = ajaxText[i];
                            cell2.innerHTML = ajaxData[i];
                        }
                        i--;
                    }
                    document.getElementById('expire_date').value = data.expire_date;
                    document.getElementById('orderno').value = data.orderno;
                    document.getElementById('place').value = data.place;
                    document.getElementById('recieved_date').value = data.recieved_date;
                    document.getElementById('used').value = data.used;
                    document.getElementById('barcode').value = data.barcode;
                    document.getElementById('filepath').value = data.filepath;
                    // alert(data.message);
                    finalsubmitbtn.style.display = "block";
                    modalButtonWrapper.style.display = "block";
                }
            })
        });
        // $('#expire_date').value(data.expire_date);
        // $('#orderno').value(data.orderno);
        // $('#place').value(data.place);
        // $('#recieved_date').value(data.recieved_date);
        // $('#used').value(data.usedstr);
        // $('#barcode').value(data.barcode);
        // $('#filepath').value(data.filepath);
    });
</script>


{{-- ModalJCrop 관련 스크립트 --}}
<script type="text/javascript">
    console.log('from modal JCrop');

    function getImage(path) {
        document.getElementById('cropbox').src = "/storage/temp_images/" + path;


        // 472, 961

        jQuery('#cropbox').Jcrop({
            onChange: showCoords,
            onSelect: showCoords
        });


        // Simple event handler, called from onChange and onSelect
        // event handlers, as per the Jcrop invocation above
        function showCoords(c) {
            jQuery('#x1').val(c.x);
            jQuery('#y1').val(c.y);
            jQuery('#x2').val(c.x2);
            jQuery('#y2').val(c.y2);
            jQuery('#w').val(c.w);
            jQuery('#h').val(c.h);

        };
    };
</script>

{{-- 상품명 값을 form에 넣기 --}}
{{-- <script>
    function getInputValue(){
        
            var inputVal = document.getElementById("title").value;
            document.getElementById('title').value = inputVal
            document.getElementById("myForm").submit();
            document.getElementById("giftcon-form").submit();
            alert("sent");
        }
</script> --}}




@endpush