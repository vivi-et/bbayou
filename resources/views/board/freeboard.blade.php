@extends('layouts.master')



@section('content')

<a href="/post/create">
    <button class="btn btn-primary">CREATE</button>
</a>




    @if(count($posts))
    @include('layouts.card')
    @endif

</main>

@endsection