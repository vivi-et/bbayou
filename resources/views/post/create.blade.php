@extends('layouts.master')
@push('header')

@endpush
@section('content')

<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
           $('.summernote').summernote({
            height: 600,
            dialogsInBody: true,
            callbacks:{
                onInit:function(){
                $('body > .note-popover').hide();
                }
             },
         });
      });
</script>


{{ $boardname }}
<hr>
<br>


<form method="POST" action="/post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <input name="title" id="title" type="text" class="form-control" placeholder="제목" required>
    </div>
    
    <div class="form-group">
        <textarea name="body" id="body" class="summernote" required></textarea>
    </div>

    <input type="hidden" id="board" name="board" value={{ $board }}>
    <div class="form-group">
        <button type="submit" id="submitbtn" class="btn btn-primary">Submit</button>
    </div>
</form>



@endsection





</form>