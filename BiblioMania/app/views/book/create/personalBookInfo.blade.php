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
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-default active">
                    <input id="personal_info_reason_not_owned_borrowed" type="radio" name="personal_info_reason_not_owned" value="BORROWED" checked/> Geleend
                </label>
                <label class="btn btn-default">
                    <input id="personal_info_reason_not_owned_sold" type="radio" name="personal_info_reason_not_owned" value="SOLD"/> Verkocht
                </label>
                <label class="btn btn-default">
                    <input id="personal_info_reason_not_owned_lost" type="radio" name="personal_info_reason_not_owned" value="LOST"/> Verloren
                </label>
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

                <span id="reading-date-plus" class="reading-date-plus fa fa-plus fa-lg"></span>
                <span id="reading-date-min" class="reading-date-min fa fa-minus fa-lg" style="margin-left: 4px"></span>
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


