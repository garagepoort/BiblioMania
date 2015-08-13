<fieldset>

<legend>Koop info</legend>

    <div class="form-container">
       
            <div class="form-group">
                <!-- BUY DATE -->
                {{ Form::label('buyInfoBuyDate', 'Aankoopdatum:', array('class' => 'col-md-3')); }}
                <div class="col-md-3">
                    {{ Form::text('buy_info_buy_date', $buy_info_buy_date, array('id'=>'buy_info_buy_date', 'class' => 'input-sm datepicker', 'placeholder' => 'aankoopdatum')); }}
                </div>
            </div>

            <!-- BUY PRICE -->
            <div class="form-group">
                <!-- CURRENCY -->
                {{ Form::label('buy_info_price_payed_label', 'Aankoop prijs:', array('class' => 'col-md-3')); }}
                <div class="col-md-2">
                    {{ Form::select('buy_info_price_payed_currency', $currencies, $buy_info_price_payed_currency, array('class' => 'input-sm form-control')); }}
                </div>
                <div class="col-md-3">
                    {{ Form::text('buy_info_price_payed', $buy_info_price_payed, array('id'=>'buy_info_price_payed','class' => 'form-control input-sm', 'placeholder' => 'prijs', 'type' => 'number')); }}
                </div>
            </div>

            <!-- REASON -->
            <div class="form-group">
                {{ Form::label('buy_info_reason_label', 'Reden:', array('class' => 'col-md-3')); }}
                <div class="col-md-5">
                    {{ Form::text('buy_info_reason', $buy_info_reason, array('id'=>'buy_info_reason','class' => 'form-control input-sm', 'placeholder' => 'Reden')); }}
                </div>
            </div>

              <!-- SHOP -->
            <div class="form-group">
                {{ Form::label('buy_info_shop_label', 'Winkel:', array('class' => 'col-md-3')); }}
                <div class="col-md-5">
                    {{ Form::text('buy_info_shop', $buy_info_shop, array('id'=>'buy_info_shop','class' => 'form-control input-sm', 'placeholder' => 'winkel')); }}
                </div>
            </div>  
            <!-- SHOP CITY-->
            <div class="form-group">
                {{ Form::label('buy_info_shop_label', 'Stad winkel:', array('class' => 'col-md-3')); }}
                <div class="col-md-5">
                    {{ Form::text('buy_info_city', $buy_info_city, array('id'=>'buy_info_city','class' => 'form-control input-sm', 'placeholder' => 'stad winkel')); }}
                </div>
            </div>

             <!-- COUNTRY -->
            <div class="form-group">
                 {{ Form::label('buy_info_country_label', 'Land:', array('class' => 'col-md-3')); }}
                    <div class="col-md-5">
                        {{ Form::text('buy_info_country', $buy_info_country, array('id'=>'buy_info_country','class' => 'form-control typeahead', 'placeholder' => 'land', 'type' => 'text')); }}
                    </div>
            </div>

    </div>
</fieldset>