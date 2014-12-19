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

        </div>
</fieldset>