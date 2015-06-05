<div class="tab-container ">
    <fieldset>

    <legend>Koop of gift info</legend>

        @if(Session::has('message'))
        <div id="koopOfGiftInfoMessage" class="alert-danger alert">
            <strong>{{ Session::get('message') }}</strong>
        </div>
        @endif
        <div class="buyOrGiftPanel">
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default @if($buyOrGift == 'BUY') active @endif">
                    <input id="buyRadioButton" type="radio" name="buyOrGift" value="BUY" @if($buyOrGift == 'BUY') checked @endif/> Gekocht
                </label>
                <label class="btn btn-default @if($buyOrGift == 'GIFT') active @endif">
                    <input id="giftRadioButton" type="radio" name="buyOrGift" value="GIFT" @if($buyOrGift == 'GIFT') checked @endif/> Gekregen
                </label>
            </div>
        </div>
        <div id="buyInfoPanel" @if($buyOrGift == 'GIFT') hidden @endif>
            @include('book/create/buyInfo')
        </div>
        <div id="giftInfoPanel" @if($buyOrGift == 'BUY') hidden @endif>
            @include('book/create/giftInfo')
        </div>
    </fieldset>
</div>
 {{ HTML::script('assets/js/createBook/buyOrGiftInfo.js'); }}