@extends('layouts.master')

@section('content')



<h1>
    Create a Post
</h1>

<form method="POST" action="/post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="exampleInputEmail1">Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1">Body</label>
        <textarea name="body" id="body" cols="30" rows="10" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label for="imageUp">이미지 업로드 (2mb 이내인 jpg, jpeg, png 파일만 가능합니다.)</label>
        <br>
        <input type="file" id="imageUp" name='cover_image'>
        <span id='mgs_ta'></span>
    </div>

    <div>
        <img id="img_prv" style="max-width:150 px; max-height: 150px;" src="/storage/noimage.png" class="img-thumbnail">
    </div>

    {{-- <div class="checkbox">
        <label>
            <input type="checkbox"> Check me out
        </label>
    </div> --}}

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>


@include('layouts.error')


@endsection

@push('script')
<script type="text/javascript">
    var x = document.getElementById("img_prv");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }


    $('#imageUp').on('change', function(ev){
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
@endpush