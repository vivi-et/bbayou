@extends('layouts.master')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
</script>


@section('content')

내 기프티콘들

<main role="main">
    <section class="jumbotron text-center">
        <div class="container">
            <h2>내 기프티콘들</h2>

            <p>
                <a href="/giftcon/create" class="btn btn-primary my-2">기프티콘 추가하기</a>
                <a href="#" class="btn btn-secondary my-2">Secondary action</a>
            </p>
        </div>
    </section>

    @if (count($giftcons))
    @include('layouts.coccard')
    @endif



</main>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>



<style>
    .one-third:hover,
    .one-third:focus {
        background: rgb(141, 87, 21);
        cursor: pointer;
    }
</style>

@endsection