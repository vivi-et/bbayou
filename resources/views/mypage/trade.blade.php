<?php use App\Giftcon;?>
@extends('layouts.master')

@section('content')

<div style="text-align: center;">
    내 기프티콘 거래글
</div>

@foreach ($posts as $post)


<?php 

$giftcon = Giftcon::find($post->giftcon_id);

echo $giftcon['title'];

?>
    
@endforeach



<div style="text-align: center;">
    내 기프티콘 거래댓글
</div>



    
@endsection


