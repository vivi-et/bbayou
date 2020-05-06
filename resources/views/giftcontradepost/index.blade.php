@extends('layouts.master')


@if($flash = session('message'))
<div class="alert alert-success" role="alert">
    {{ $flash }}
</div>
@endif


@section('content')



<main role="main">

    <section class="jumbotron text-center">
        <div class="container">
            <h2>BBAYOU</h2>
            <h1>뭐</h1>
            <p class="lead text-muted">디자인 구진거 안다</p>
            <p>
                <a href="#" class="btn btn-primary my-2">Main call to action</a>
                <a href="#" class="btn btn-secondary my-2">Secondary action</a>
            </p>
        </div>
    </section>

    <div class="row">
        @foreach ($user->giftcons->reverse() as $giftcon)
        <div class="col-md-4">
            <div class="slide-container">

                <div class="wrapper" style="float: left">
                    <div class="clash-card barbarian">
                        <div class="clash-card__image clash-card__image--barbarian">
                            <div style="background-image: url('/storage/giftcon_images/{{ $giftcon->imagepath }}'); width: 100%;
                                    height: 100%;background-position: center center; background-repeat: no-repeat;"
                                alt="barbarian">
                            </div>
                        </div>
                        <div class="clash-card__level clash-card__level--barbarian"><a href="#">{{ $giftcon->user->name }}</a></div>
                        <div class="clash-card__unit-name">{{ $giftcon->title }}</div>
                        <div class="clash-card__unit-description">



                            번호 : {{$giftcon->id}}
                            <br>
                            유효기간 : {{$giftcon->expire_date}}
                            <br>
                            {{-- 주문번호 : {{$giftcon->orderno}}
                            <br> --}}
                            교환처 : {{$giftcon->place}}
                            <br>
                            {{-- 바코드 : {{wordwrap($giftcon->barcode, 4, ' ', true)}} --}}
                            상태 : {{ $giftcon->used }}
                            <br>
                            <br>
                            <p class="blog-post-meta"> 
                                {{ $giftcon->created_at->diffforhumans()}} </p>


                        </div>

                        <div class="clash-card__unit-stats clash-card__unit-stats--giant clearfix">
                            <div class="one-third">
                                <div class="stat">선물하기</div>
                                <div class="stat-value">Present</div>
                            </div>

                            <div class="one-third">
                                <div class="stat">사용하기</div>
                                <div class="stat-value">Use</div>
                            </div>

                            <div class="one-third no-border">
                                <div class="stat">거래하기</div>
                                <div class="stat-value">Trade</div>
                            </div>

                        </div>


                    </div><!-- end clash-card barbarian-->
                </div><!-- end wrapper -->


            </div> <!-- end container -->
        </div>

        @endforeach
    </div>






    <link href="{{ asset('css/card.css') }}" rel="stylesheet">


    {{-- @if(count($giftcons))
    @include('layouts.card')
    @endif --}}

</main>





@endsection


<script>
    // <div class="col-sm">
//     <img style="max-width:100%;
//     max-height:100%;" class="center" src="/storage/giftcon_images/{{ $giftcon->imagepath }}">

// </div>
// <div class="col-sm">
//     <h2 class="blog-post-title">{{$giftcon->title}} </h2>

    // 번호 : {{$giftcon->id}}
    // <br> 
    // 유효기간 : {{$giftcon->expire_date}}
    // <br>
    // {{-- 주문번호 : {{$giftcon->orderno}}
    // <br> --}}
    // 교환처 : {{$giftcon->place}}
    // <br>
    // {{-- 바코드 : {{wordwrap($giftcon->barcode, 4, ' ', true)}} --}}
    // 상태 : {{ $giftcon->used }}
    // <br>
    // <br>
    // <p class="blog-post-meta"> <a href="#">{{ $giftcon->user->name }}</a>
    //     {{ $giftcon->created_at->diffforhumans()}} </p>
// </div>
</script>