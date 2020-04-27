@extends('layouts.master')

@section('content')

<h1>
    Create a Post
</h1>

<form method="POST" action="/post" enctype="multipart/data">
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
        <label for="exampleInputFile">File input</label>
        <input type="file" id="exampleInputFile" name='cover_image'>
        <p class="help-block">Example block-level help text here.</p>
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