@push('header')
    <link href="{{ asset('css/card.css') }}" rel="stylesheet" />
    @endpush
    <div class="row">
        {{-- barcode 번호 hidden 으로 숨겨짐! --}}
        @foreach ($giftcons as $giftcon)
        <div class="col-md-4" style="text-align: center">
            <div class="slide-container">
                <div class="wrapper" style="float: left; margin-left:5%">
                    <div class="clash-card barbarian" id="giftcon{{ $giftcon->id }}">
                        <div class="clash-card__image clash-card__image--barbarian">
                            <div style="  border-top-left-radius: 14px; border-top-right-radius: 14px;background-image: url('/storage/giftcon_images/{{ $giftcon->imagepath }}'); width: 100%;
                                    height: 100%;background-position: center center; background-repeat: no-repeat;"
                                alt="barbarian"></div>
                        </div>
                        <div class="clash-card__level clash-card__level--barbarian">
                            <a href="#">{{ $giftcon->user->name }}</a>
                        </div>
                        <div class="clash-card__unit-name" style="overflow: hidden; margin:0 20px; font-size:22px;">
                            {{ $giftcon->title }}</div>
                        <div class="clash-card__unit-description">
                            번호 : {{$giftcon->id}}
                            <br />
                            유효기간 : {{$giftcon->expire_date}}
                            <br />
                            {{-- 주문번호 : {{$giftcon->orderno}}
                            <br />
                            --}} 교환처 : {{$giftcon->place}}
                            <br />
                            {{-- 바코드 : {{wordwrap($giftcon->barcode, 4, ' ', true)}} --}}
                            상태 : {{ $giftcon->used }}
                            <br />
                            <br />
                            <div id="theBarcode{{ $giftcon->id }}"></div>
                            <div style="font-size: 20px; padding-top:8px" id="theBarcodeno{{ $giftcon->id }}"></div>
                            <br>
                            <p class="blog-post-meta">
                                {{ $giftcon->created_at->diffforhumans()}}
                            </p>
                        </div>

                        <div class="clash-card__unit-stats clash-card__unit-stats--giant clearfix">
                            <div class="one-third">
                                <div class="stat">선물하기</div>
                                <div class="stat-value">Present</div>
                            </div>

                            <div class="one-third" tabindex="0" onclick="makeImage({{ $giftcon->id }})">
                                <div class="stat">사용하기</div>
                                <div class="stat-value">Use</div>
                            </div>

                            <div class="one-third no-border">
                                <div class="stat">거래하기</div>
                                <div class="stat-value">Trade</div>
                            </div>
                        </div>
                    </div>
                    <!-- end clash-card barbarian-->
                </div>
                <!-- end wrapper -->
            </div>
            <!-- end container -->
        </div>


        @endforeach
    </div>