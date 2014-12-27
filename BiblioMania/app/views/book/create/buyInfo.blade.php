<fieldset>

<legend>Koop info</legend>

    <div class="form-container">
       
            <div class="form-group">
                <!-- BUY DATE -->
                {{ Form::label('buyInfoBuyDate', 'Aankoopdatum:', array('class' => 'col-md-3')); }}
                <div class="col-md-3">
                    {{ Form::text('buy_info_buy_date', '', array('id'=>'buy_info_buy_date', 'class' => 'input-sm datepicker', 'placeholder' => 'aankoopdatum')); }}
                </div>
            </div>

            <!-- BUY PRICE -->
            <div class="form-group">
                {{ Form::label('buy_info_price_payed_label', 'Aankoop prijs:', array('class' => 'col-md-3')); }}
                <div class="col-md-3">
                    {{ Form::text('buy_info_price_payed', '', array('id'=>'buy_info_price_payed','class' => 'form-control input-sm', 'placeholder' => 'prijs', 'type' => 'number')); }}
                </div>
            </div>

            <!-- COVER PRICE -->
            <div class="form-group">
                {{ Form::label('book_info_retail_price_label', 'Cover prijs:', array('class' => 'col-md-3')); }}
                <div class="col-md-3">
                    {{ Form::text('buy_book_info_retail_price', '', array('id'=>'buy_book_info_retail_price','class' => 'form-control input-sm', 'placeholder' => 'prijs', 'type' => 'number')); }}
                </div>
            </div>

            <!-- RECOMMENDED BY -->
            <div class="form-group">
                {{ Form::label('buy_info_recommended_by_label', 'Aanbevolen door:', array('class' => 'col-md-3')); }}
                <div class="col-md-5">
                    {{ Form::text('buy_info_recommended_by', '', array('id'=>'buy_info_recommended_by','class' => 'form-control input-sm', 'placeholder' => 'aanbevolen door')); }}
                </div>
            </div>

              <!-- SHOP -->
            <div class="form-group">
                {{ Form::label('buy_info_shop_label', 'Winkel:', array('class' => 'col-md-3')); }}
                <div class="col-md-5">
                    {{ Form::text('buy_info_shop', '', array('id'=>'buy_info_shop','class' => 'form-control input-sm', 'placeholder' => 'winkel')); }}
                </div>
            </div>  
            <!-- SHOP CITY-->
            <div class="form-group">
                {{ Form::label('buy_info_shop_label', 'Stad winkel:', array('class' => 'col-md-3')); }}
                <div class="col-md-5">
                    {{ Form::text('buy_info_city', '', array('id'=>'buy_info_city','class' => 'form-control input-sm', 'placeholder' => 'stad winkel')); }}
                </div>
            </div>

             <!-- COUNTRY -->
            <div class="form-group">
                 {{ Form::label('buy_info_country_label', 'Land:', array('class' => 'col-md-3')); }}
                    <div class="col-md-5">
                        {{ Form::text('buy_info_country', '', array('id'=>'buy_info_country','class' => 'form-control typeahead', 'placeholder' => 'land', 'required' => 'true', 'type' => 'text')); }}
                    </div>
            </div>

    </div>
</fieldset>