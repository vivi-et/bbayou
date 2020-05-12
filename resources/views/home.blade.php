@extends('layouts.master')


@section('content')


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

    @if(count($giftcons))

    @include('layouts.card')
    @endif

</main>

@endsection