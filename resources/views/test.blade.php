@extends('layouts.master')

@section('content')

<Div>

    <br>



    @for ($i = 0; $i < 5; $i++) {{$package['cat'][$i]}} : {{$package['catdata'][$i]}} <br>

        @endfor

        {{-- @foreach($text as $re)
    {{$re}}
        <br>

        @endforeach --}}


</Div>

@endsection