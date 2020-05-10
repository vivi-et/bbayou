@extends('layouts.master')

@section('content')

{{ $boardname }}
<br>
<br>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">제목</th>
            <th scope="col">글쓴이</th>
            <th scope="col">작성일</th>
            <th scope="col">조회</th>
            <th scope="col">추천</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($posts as $post)
        <tr>
            <th scope="row">{{ $post->id }}</th>

            <td><a href="/post/{{ $post->id }}">{{ $post->title }} </a></td>
            <td>{{ $post->user->name }}</td>
            <td>{{ $post->created_at->diffforhumans()}}</td>
            <td>{{ $post->views }}</td>
            <td>{{ $post->ups }}</td>
        </tr>

        @endforeach




    </tbody>
</table>









{{ $posts->links() }}
@endsection