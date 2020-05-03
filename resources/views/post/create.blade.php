@extends('layouts.master')

@section('content')


<h1>
    Create a Post
</h1>


<div class="row">
    <div class="col-sm">
        <form id="main_form" method="POST" action="/post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Title</label>
                <input type="text" class="form-control" name="title">
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Body</label>
                <textarea name="body" id="body" cols="30" rows="10" class="form-control"></textarea>
            </div>



            <input type="file" id="cover_image" name='cover_image' style="display:none;">
            <label for="cover_image" class="btn btn-primary">기프티콘 업로드</label>
            <span id='mgs_ta'></span>
            <br>
            <label for="cover_image">(2mb 이내인 jpg, jpeg, png 파일만 가능합니다.)</label>
            <div class="form-group">
                <button type="submit" id="submitbtn" class="btn btn-primary">기프티콘 확인</button>
            </div>
        </form>
    </div>
    <div class="col-sm">

        <div style="display: inline-block;">
            <img id="img_prv" style="max-height: 500px; max-width:300 px; " src="/storage/noimage.png"
                class="img-thumbnail">
        </div>
        <div>
            <br>
        </div>
    </div>
    <div class="col-sm">
        <div id="expire_date">expire_date</div> <br>
        <div id="orderno">orderno</div> <br>
        <div id="place">place</div> <br>
        <div id="recieved_date">recieved_date</div> <br>
        <div id="used">used</div> <br>
        <div id="barcode">barcode</div> <br>


        </span>

    </div>

</div>









@include('layouts.error')


@endsection

@push('headertest')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endpush

@push('script')
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

    

});

</script>

{{-- 
<script type="text/javascript">
    $("form").submit(function () {
    if ($(this).valid()) {
        $(this).submit(function () {
            return false;
        });
        return true;
    }
    else {
        return false;
    }
});
</script> --}}

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
</script>

<script>
    $(document).ready(function(){
    
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
                $('#expire_date').html(data.expire_date);
                $('#orderno').html(data.orderno);
                $('#place').html(data.place);
                $('#recieved_date').html(data.recieved_date);
                $('#used').html(data.used);
                $('#barcode').html(data.barcode);
       
       alert(data.message);
       }
      })
     });
    
    });
</script>




@endpush