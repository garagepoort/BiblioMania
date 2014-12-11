<div class="tab-container ">
    <fieldset>

    <legend>Persoonlijke info</legend>

        @if(Session::has('message'))
        <div id="firstPrintInfoMessage" class="alert-danger alert">
            <strong>{{ Session::get('message') }}</strong>
        </div>
        @endif

    </fieldset>
</div>