@extends('layouts.master')

@section('content')

<style>
    .editablediv {
        width: 600px;
    }
</style>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    {{-- <div>
        {{$post = $package['post']}}
    {{$giftcon = $package['giftcon']}}
    </div> --}}
</head>

<br>
<div class="col-sm-8 blog-main">
    <h2 class="blog-post-title">{{$post->title}}</h2>
    <br>
    <p class="blog-post-meta"> {{ $post -> created_at->toFormattedDateString() }} <a
            href="#">{{ $post->user->name }}</a></p>
    <br>

    <img style="max-width:100%;
    max-height:100%;" class="center" src="/storage/cover_images/{{ $post->cover_image }}">

    <br>
    <br>
    {{ $post->body}}
    <hr>
    <br>

    <div>
        유효기간 : {{$giftcon->expire_date}}
        <br>
        주문번호 : {{$giftcon->orderno}}
        <br>
        교환처 : {{$giftcon->place}}
        <br>



    </div>



    <br>
    <hr>
    <br>



    @if(auth()->user()->id == $post->user_id)
    <div class="btn-group" style="float:right;">
        <a href="/post/{{$post->id}}/edit">
            <button class="btn btn-primary">Edit</button>
        </a>

        <form method="POST" action="/post/{{$post->id}}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-primary" style="margin-left:5px;">Delete</button>

        </form>
    </div>
    @endif
    <br style="clear:both;">



    <hr>
    <div class="comments">
        <ul class="list-group">
            @foreach ($post->comments as $comment)
            <li class="list-group-item">
                <strong>
                    {{ $comment->created_at->diffforhumans() }}
                </strong>
                <br>
                <div class="editdiv" style="width:100px;">{{ $comment->body }}</div>
                <button class="btn">Edit</button>
    </div>


    </li>
    @if(auth()->user()->id == $comment->user_id)

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            Dropdown button
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <button class="btn">Edit</button>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
        </div>
    </div>
    @endif
    <br style="clear:both;">
    @endforeach
    </ul>

    <br>

    {{-- add a comment --}}

    <div>

        <div>

            <form method="POST" action="/post/{{ $post->id }}/comment">
                {{ csrf_field() }}

                {{-- {{method_field('PATCH')}} --}}

                <div class="form-group">
                    <textarea 3name="body" placeholder="Comment" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            @include('layouts.error')
        </div>
    </div>

    <script>
        function divClicked() {
    var divHtml = $(this).prev('div').html();
    var editableText = $("<textarea class='editablediv'/>");
    editableText.val(divHtml);
    $(this).prev('div').replaceWith(editableText);
    editableText.focus();
    // setup the blur event for this new textarea
    editableText.blur(editableTextBlurred);
}

function editableTextBlurred() {
    var html = $(this).val();
    var viewableText = $("<div>");
    viewableText.html(html);
    $(this).replaceWith(viewableText);
    // setup the click event for this new div
    viewableText.click(divClicked);
}

$(document).ready(function () {
    $(".btn").click(divClicked);
});
    </script>

    @endsection

    <style>
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            /* width: 50%; */
        }
    </style>