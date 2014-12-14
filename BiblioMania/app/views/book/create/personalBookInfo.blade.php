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

        <!-- RATING -->
      	<div class="row" id="post-review-box">
                <div class="col-md-12">
                    <textarea class="form-control animated" cols="50" id="new-review" name="personal_info_review" placeholder="Enter your review here..." rows="5"></textarea>
          	         <input name="personal_info_rating" id="star-rating" class="rating" min=1 max=10 step=2 data-size="xs">   
                </div>
            </div>

    </fieldset>
</div>

<script type="text/javascript">
 	$(document).ready(function() {
    	$("#star-rating").rating();
	});
</script>