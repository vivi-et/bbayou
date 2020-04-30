@extends('layouts.master')
@section('content')
<div>
    <br>
    @for ($i = 0; $i < 5; $i++) 
    @if(!empty($package['catdata'][$i]))
    {{$package['cat'][$i]}} : {{$package['catdata'][$i]}}
    <br>
    @endif
    @endfor

        {{-- @foreach($text as $re)
    {{$re}}
        <br>

        @endforeach --}}


</div>

@endsection