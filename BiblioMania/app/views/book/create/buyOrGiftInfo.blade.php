<div class="tab-container ">
    <fieldset>

    <legend>Koop of gift info</legend>

        @if(Session::has('message'))
        <div id="koopOfGiftInfoMessage" class="alert-danger alert">
            <strong>{{ Session::get('message') }}</strong>
        </div>
        @endif
        <div class="buyOrGiftPanel">
            <table>
                <tr>
                    <td>
                        Gekocht: {{ Form::radio('buyOrGift', 'BUY', true, array('id'=>'buyRadioButton')) }}
                    </td>
                </tr>
                <tr>
                    <td>
                        Gekregen: {{ Form::radio('buyOrGift', 'GIFT', false, array('id'=>'giftRadioButton')) }}
                    </td>
                </tr>
            </table>   
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