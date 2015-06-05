<fieldset>

    <legend>Gift info</legend>

    <div class="form-container">
        <!-- COVER PRICE -->
        <div class="form-group">
            {{ Form::label('book_info_retail_price_label', 'Cover prijs:', array('class' => 'col-md-3')); }}
            <div class="col-md-3">
                {{ Form::text('gift_book_info_retail_price', $gift_book_info_retail_price, array('id'=>'gift_book_info_retail_price','class' => 'form-control input-sm', 'placeholder' => 'prijs', 'type' => 'number')); }}
            </div>
        </div>

        <div class="form-group">
            <!-- RECEIPT DATE -->
            {{ Form::label('giftInfoReceiptDate', 'Ontvangstdatum:', array('class' => 'col-md-3')); }}
            <div class="col-md-3">
                {{ Form::text('gift_info_receipt_date', $gift_info_receipt_date, array('id'=>'gift_info_receipt_date', 'class' => 'input-sm datepicker', 'placeholder' => 'ontvangstdatum')); }}
            </div>
        </div>

        <!-- FROM -->
        <div class="form-group">
            {{ Form::label('buy_info_from_label', 'Gekregen van:', array('class' => 'col-md-3')); }}
            <div class="col-md-5">
                {{ Form::text('gift_info_from', $gift_info_from, array('id'=>'gift_info_from','class' => 'form-control input-sm', 'placeholder' => 'gekregen van')); }}
            </div>
        </div>

        <!-- OCCASION -->
        <div class="form-group">
            {{ Form::label('gift_info_occasion_label', 'Gelegenheid:', array('class' => 'col-md-3')); }}
            <div class="col-md-5">
                {{ Form::text('gift_info_occasion', $gift_info_occasion, array('id'=>'gift_info_occasion','class' => 'form-control input-sm', 'placeholder' => 'gelegenheid')); }}
            </div>
        </div>

        <!-- REASON -->
        <div class="form-group">
            {{ Form::label('gift_info_reason_label', 'Reden:', array('class' => 'col-md-3')); }}
            <div class="col-md-5">
                {{ Form::text('gift_info_reason', $gift_info_reason, array('id'=>'gift_info_reason','class' => 'form-control input-sm', 'placeholder' => 'Reden')); }}
            </div>
        </div>

    </div>
</fieldset>