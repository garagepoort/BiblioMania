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
                {{ Form::checkbox('personal_info_owned', 'personal_info_owned', 'true' ,array('id'=>'personal-info-owned-checkbox')); }}
            </div>
        </div>
        <div class="form-group" id="reason-not-owned-panel" hidden>
            {{ Form::label('personal_info_ownedLabel', 'Reden niet in collectie:', array('class' => 'col-md-3')); }}
            <div class="col-md-2">
                {{ Form::label('personal_info_reason_not_owned_borrowed', 'Geleend') }}
                {{ Form::radio('personal_info_reason_not_owned', 'BORROWED', true, array('id'=>'personal_info_reason_not_owned_borrowed')) }}
                
                {{ Form::label('personal_info_reason_not_owned_sold', 'Verkocht') }}
                {{ Form::radio('personal_info_reason_not_owned', 'SOLD', false, array('id'=>'personal_info_reason_not_owned_sold')) }}
                
                {{ Form::label('personal_info_reason_not_owned_lost', 'verloren') }}
                {{ Form::radio('personal_info_reason_not_owned', 'LOST', false, array('id'=>'personal_info_reason_not_owned_lost')) }}
            </div>
        </div>
        <!-- READING DATES -->
        <div class="form-group">
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
            <div class="col-md-2" style="padding-top: 4px">

                <span class="reading-date-plus">
                    <!-- {{ HTML::image('images/plus.svg', 'notfound', array('width' => '48px', 'height' => '48px')) }} -->
                    <span class="reading-date-min fa fa-plus fa-lg"></span>
                </span>
                <span class="reading-date-min fa fa-minus fa-lg" style="margin-left: 4px"></span>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('rating_label', 'Rating:', array('class' => 'col-md-3')); }}
            <div id="star" class="col-md-6">
            </div>
            <input id="star-rating-input" name="personal_info_rating" hidden value="">   
        </div>
    
    </fieldset>
</div>


