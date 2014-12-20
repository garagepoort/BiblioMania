<fieldset>

<legend>Koop info</legend>

<div class="form-container">
   
            <div class="form-group">
                <!-- BUY DATE -->
                {{ Form::label('buyInfoBuyDate', 'Publicatie:', array('class' => 'col-md-2')); }}
                <div class="col-md-3">
                    {{ Form::text('buy_buy_date', '', array('class' => 'input-sm datepicker', 'placeholder' => 'select date', 'required' => 'true')); }}
                </div>
            </div>


        <!-- COVER PRICE -->
        <div class="form-group">
            {{ Form::label('$personal_info_retail_price_label', 'Cover prijs:', array('class' => 'col-md-2')); }}
            <div class="col-md-3">
                {{ Form::text('personal_info_retail_price', '', array('id'=>'personal_info_retail_price','class' => 'form-control input-md', 'placeholder' => 'prijs', 'type' => 'number')); }}
            </div>
        </div>

        </div>
</fieldset>