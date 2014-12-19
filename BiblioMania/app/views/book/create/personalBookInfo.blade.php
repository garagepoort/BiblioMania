 {{ HTML::script('assets/js/creatBook/personalBookInfo.js'); }}

<div class="tab-container ">
    <fieldset>

    <legend>Persoonlijke info</legend>

        @if(Session::has('message'))
        <div id="firstPrintInfoMessage" class="alert-danger alert">
            <strong>{{ Session::get('message') }}</strong>
        </div>
        @endif

          <!-- OWNED -->
        <div class="form-group">
            {{ Form::label('personal_info_ownedLabel', 'In collectie:', array('class' => 'col-md-3')); }}
            <div class="col-md-4">
                {{ Form::checkbox('personal_info_owned', 'personal_info_owned'); }}
            </div>
        </div>

        <!-- COVER PRICE -->
        <div class="form-group">
            {{ Form::label('$personal_info_retail_price_label', 'Cover prijs:', array('class' => 'col-md-3')); }}
            <div class="col-md-4">
                {{ Form::text('personal_info_retail_price', '', array('id'=>'personal_info_retail_price','class' => 'form-control', 'placeholder' => 'prijs', 'type' => 'number')); }}
            </div>
        </div>

        <!-- READING DATES -->

         <div class="form-group">
                <!-- PUBLICATION DATE -->
                {{ Form::label('personal_info_reading_dates_label', 'Lees datum / data:', array('class' => 'col-md-3')); }}
                <div class="col-md-3">
                    <input id="personal_info_reading_date_input" name="personal_info_reading_dates" hidden>
                    <table id="reading-dates-table">
                        <tr>
                            <td>
                                <input style="margin-bottom: 10px;" name="reading_date_counter" placeholder="select date" class="input-sm datepicker reading-date">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-2">
                    <span class="reading-date-plus glyphicon glyphicon-plus"></span>
                    <span class="reading-date-min glyphicon glyphicon-minus"></span>
                </div>
            </div>

        <!-- RATING -->
      	<div class="row" id="post-review-box">
                <div class="col-md-12">
                    <textarea class="form-control animated" cols="50" id="new-review" name="personal_info_review" placeholder="Enter your review here..." rows="5"></textarea>
          	         <input name="personal_info_rating" id="star-rating" class="rating" min=1 max=10 step=2 data-size="xs">   
                </div>
            </div>

    </fieldset>
</div>