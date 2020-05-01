@extends('layouts.master')
@section('content')
<div>
    <br>
    From OCR
    <br>
    @for ($i = 0; $i < 5; $i++) 
    @if(!empty($package['catdata'][$i])) 
    {{-- $package[{{$i}}] :  --}}
    {{$package['cat'][$i]}} :{{$package['catdata'][$i]}} 
    <br>

        @endif
        @endfor
        <br>
        From MYSQL
        <br>
        유효기간 : {{$package['giftcon']->expire_date}}
        <br>
        주문번호 : {{$package['giftcon']->orderno}}
        <br>
        교환처 : {{$package['giftcon']->place}}
        <br>


        {!! $package['bobj']->getHtmlDiv() !!}
        1126 8536 6699 HARDCODED!!

    <br>

    @endsection