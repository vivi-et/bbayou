@extends('layouts.master')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
</script>

@if($flash = session('message'))
<div class="alert alert-success" role="alert">
    {{ $flash }}
</div>




@endif 
@section('content')
<a href="/giftcon/create">
    <button class="btn btn-primary">CREATE</button>
</a>

<a href="/giftcon/trade">
    <button class="btn btn-primary">TRADE</button>
</a>
<br>

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


    @include('layouts.coccard')



</main>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>


<script>
    function makeImage(x) {
      

        $.ajax({
            type: "PUT",
            url: "/giftcon/" + x,
            cache: false,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            data: {
                'text1': '1',
                'text2': '2',
                'text3': '3',
            },
            processData: false,
            success: function (data) {
            let base64image = data.barcode;
            let ajaxbarcodeno = data.barcodeno;
            let downloadAs = data.downloadAs;

            // alert(data.barcode);
            let theDiv = document.getElementById('theBarcode' + x);
            let theBarcodeno = document.getElementById('theBarcodeno' + x);
            let htmloutput = '<img src="data:image/png;base64,' +base64image+'">';
    
                
                theDiv.innerHTML += htmloutput;
                theBarcodeno.innerHTML +=  ajaxbarcodeno;

                let thisGiftcon = document.getElementById('giftcon' + x);

                html2canvas([thisGiftcon], {
                    onrendered: function (canvas) {
                        var data = canvas.toDataURL('image/jpeg');


                        var link = document.createElement('a');
                        link.download = downloadAs;
                        link.href = data;
                        link.click();

                    }

                });
            }
        });

    };

</script>
<style>
    .one-third:hover,
    .one-third:focus {
        background: rgb(141, 87, 21);
        cursor: pointer;
    }
</style>

@endsection