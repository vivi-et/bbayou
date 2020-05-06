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




    @foreach ($user->giftcons->reverse() as $giftcon)


    <div class="row" id="test" style="outline: 5px dotted green; overflow:hidden;">

        <div class="col-sm-4">
            <a href="#">
                <img class="img-fluid rounded mb-3 mb-md-0" src="/storage/giftcon_images/{{ $giftcon->imagepath }} alt="">
            </a>
        </div>
        <div style="margin-right: 10px"></div>
        <div class=" col-sm-10">
                <h3>{{ $giftcon->title }}</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laudantium veniam exercitationem
                    expedita laborum at voluptate. Labore, voluptates totam at aut nemo deserunt rem magni
                    pariatur quos perspiciatis atque eveniet unde.</p>
                <a class="btn btn-primary" href="#">View Project</a>
        </div>




    </div>


    @endforeach

    <div style="clear: both"></div>



    {{-- @if(count($giftcons))
    @include('layouts.card')
    @endif --}}

</main>

<style>
    #test {
        float: left;
        width: 45%;
    }
</style>


@endsection


<script>
    // <div class="col-sm">
//     <img style="max-width:100%;
//     max-height:100%;" class="center" src="/storage/giftcon_images/{{ $giftcon->imagepath }}">

// </div>
// <div class="col-sm">
//     <h2 class="blog-post-title">{{$giftcon->title}} </h2>

//     번호 : {{$giftcon->id}}
//     <br> 
//     유효기간 : {{$giftcon->expire_date}}
//     <br>
//     {{-- 주문번호 : {{$giftcon->orderno}}
//     <br> --}}
//     교환처 : {{$giftcon->place}}
//     <br>
//     {{-- 바코드 : {{wordwrap($giftcon->barcode, 4, ' ', true)}} --}}
//     상태 : {{ $giftcon->used }}
//     <br>
//     <br>
//     <p class="blog-post-meta"> <a href="#">{{ $giftcon->user->name }}</a>
//         {{ $giftcon->created_at->diffforhumans()}} </p>
// </div>
</script>