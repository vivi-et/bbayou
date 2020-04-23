@extends('layouts.master')

@section('content')

<br>
<div class="col-sm-8 blog-main">
    <h2 class="blog-post-title">{{$post->title}}</h2>
<p class="blog-post-meta"> {{ $post -> created_at->toFormattedDateString() }} <a href="#">{{ $post->user->name }}</a></p>


    <hr>
    {{$post->body}}
    <br>
    <hr>
    <br>
    <div class="comments">
        <ul class="list-group">
            @foreach ($post->comments as $comment)
            <li class="list-group-item">
                <strong>
                    {{ $comment->created_at->diffforhumans() }}
                </strong>
                <br>
                {{ $comment->body }}
            </li>
            @endforeach
        </ul>
    </div>

    <hr>

    {{-- add a comment --}}

    <div class="card">

        <div class="card-block">

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


    @endsection