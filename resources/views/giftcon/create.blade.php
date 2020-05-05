@extends('layouts.master')

@section('content')


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
            <div class="form-group">
                <button type="submit" id="finalsubmitbtn" class="btn btn-primary">기프티콘 등록</button>
        </form>
    </div>
</div>


</div>

@push('modal')

<div id=uploadedimageModal class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload and Crop Image</h4>

            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 text-center">
                        <div class="image_demo" style="width:350px; margin-top:30px;">

                        </div>
                        <div class="col-md-4" style="padding-top:30px;">
                            <button class="btn btn-success crop_image"> Crop & Upload Image</button>
                        </div>
                        <br><br>
                    </div>
                </div>
            </div>

            <script>
                $.(document).ready(function(){
                        $image_crop = $('#image_demo').coppie({
                            enableExif

                        });
                });
            </script>

            @endpush

        </div>
    </div>


</div>





</div>




@include('layouts.error')


@endsection

@push('headertest')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script src="/js/cropper.js"></script><!-- Cropper.js is required -->
<link href="/css/cropper.css" rel="stylesheet">
<script src="/js/cropper.js"></script>
@endpush

@push('script')
{{-- cropper --}}
<script>
// $("#image").cropper();

</script>

{{-- file preview --}}
<script type="text/javascript">
    var x = document.getElementById("img_prv");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
    $('#cover_image').on('change', function(ev){
    console.log("here inside");
    var filedata=this.files[0];
    var imgtype=filedata.type;
    var match=['image/jpeg', 'image/jpg', 'image/png'];
    if(!((imgtype==match[0])||(imgtype==match[1])||(imgtype==match[2]))){
        $('#mgs_ta').html('<p style="color:red"> jpg, jpeg, png 파일만 업로드가 가능합니다. </p>')
        x.style.display = "none";
    }else{
    var reader = new FileReader();
    reader.onload=function(ev){
        $('#img_prv').attr('src',ev.target.result)
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
    .cropper-crop{}
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
    $(document).ready(function(){

        var finalsubmitbtn = document.getElementById("result_col_sm");
  if (finalsubmitbtn.style.display === "none") {
    finalsubmitbtn.style.display = "block";
  } else {
    finalsubmitbtn.style.display = "none";
  }
    
     $('#main_form').on('submit', function(event){
      event.preventDefault();
      $.ajax({
       url:"{{ route('ajaxupload.action') }}",
       method:"POST",
       data:new FormData(this),
       dataType:'JSON',
       contentType: false,
       cache: false,
       processData: false,
       success:function(data)
       {

        console.log('ajax json recieved');
        

        let  ajaxData = [
            data.expire_date, 
            data.orderno, 
            data.place, 
            data.recieved_date, 
            data.usedstr,
            data.sepbarcode, 
            data.filepath,
        ];

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
            "파일경로",
        ];

    
        let table = document.getElementById("result-table");
        
        
        if(table.rows.length>2){
        while(table.rows.length>1) table.deleteRow(1);
    }
        
        let i = ajaxData.length;
        while(i>=0){
            
            console.log(i);
            if(ajaxData[i]){
                
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
        alert(data.message);
        finalsubmitbtn.style.display = "block";
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