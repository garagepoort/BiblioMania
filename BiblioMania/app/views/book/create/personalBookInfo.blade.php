 {{ HTML::script('assets/js/createBook/personalBookInfo.js'); }}

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
                {{ Form::checkbox('personal_info_owned', $personal_info_owned, $personal_info_owned ,array('id'=>'personal-info-owned-checkbox')); }}
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
                <input id="personal_info_reading_date_input" name="personal_info_reading_dates" hidden value={{ $personal_info_reading_date_input }}>
                <table id="reading-dates-table">
                </table>
            </div>
            <div class="col-md-2" style="padding-top: 4px">

                <span class="reading-date-plus fa fa-plus fa-lg"></span>
                <span class="reading-date-min fa fa-minus fa-lg" style="margin-left: 4px"></span>
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('rating_label', 'Rating:', array('class' => 'col-md-3')); }}
            <div id="star" class="col-md-6">
            </div>
            <input id="star-rating-input" name="personal_info_rating" hidden value={{ $personal_info_rating }}>
        </div>
    
    </fieldset>
</div>


