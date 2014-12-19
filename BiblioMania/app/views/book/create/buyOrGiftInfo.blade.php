 {{ HTML::script('assets/js/creatBook/personalBookInfo.js'); }}

<div class="tab-container ">
    <fieldset>

    <legend>Koop of gift info</legend>

        @if(Session::has('message'))
        <div id="koopOfGiftInfoMessage" class="alert-danger alert">
            <strong>{{ Session::get('message') }}</strong>
        </div>
        @endif
        <div class="buyOrGiftPanel">
            <div>
                Gekocht: {{ Form::radio('buyOrGift', 'buy', true) }}
                Gekregen: {{ Form::radio('buyOrGift', 'gift') }}
            </div>
        </div>
        @include('book/create/buyInfo')
    </fieldset>
</div>