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
                <label class="btn btn-default active">
                    <input id="buyRadioButton" type="radio" name="buyOrGift" value="BUY" checked/> Gekocht
                </label>
                <label class="btn btn-default">
                    <input id="giftRadioButton" type="radio" name="buyOrGift" value="GIFT"/> Gekregen
                </label>
            </div>
        </div>
        <div id="buyInfoPanel">
            @include('book/create/buyInfo')
        </div>
        <div id="giftInfoPanel" hidden>
            @include('book/create/giftInfo')
        </div>
    </fieldset>
</div>
 {{ HTML::script('assets/js/createBook/buyOrGiftInfo.js'); }}