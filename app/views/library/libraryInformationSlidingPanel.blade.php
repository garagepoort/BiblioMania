<div id="libraryInformationSlidingPanel" class="sliding-panel libraryInformationSlidingPanel">
    <div id="libraryInformationSlidingPanelTitle" class="slidingPanelTitle material-card-title">Informatie collectie</div>
    <div class="material-card-content">
        <div class="row">
            {{ Form::label('amountOfBooksLabel', 'Aantal boeken:' , array('class' => 'control-label col-md-6')); }}
            {{ Form::label('amountOfBooks', "0" , array('id'=>'amountOfBooksLibrary', 'class' => 'control-label col-md-4')); }}
        </div>
        <div class="row">
            {{ Form::label('valueLabel', 'Aantal boeken in bezit:' , array('class' => 'control-label col-md-6')); }}
            {{ Form::label('value', "0", array('id'=>'amountOfBooksOwnedLibrary', 'class' => 'control-label col-md-4')); }}
        </div>
        <div class="row">
            {{ Form::label('valueLabel', 'Waarde bibliotheek:' , array('class' => 'control-label col-md-6')); }}
            {{ Form::label('value', "0", array('id'=>'valueLibrary', 'class' => 'control-label col-md-4')); }}
        </div>
    </div>
    <div id="libraryInformationBookMark" class="bookMark libraryInformationBookmark">
        <div class="info-icon"></div>
{{--        {{ HTML::image('images/info_icon.png', 'information',array('class'=>'info-icon')) }}--}}
    </div>
</div>

<script type="text/javascript">

    function fillInLibraryInformation(amountOfBooks, amountOfBooksOwned, value){
        $('#amountOfBooksLibrary').text(amountOfBooks);
        $('#amountOfBooksOwnedLibrary').text(amountOfBooksOwned);
        $('#valueLibrary').text("€ " + value);
    }

    $(function () {
        var infoPanelOpen = false;
        var slidingPanel = new BorderSlidingPanel($('#libraryInformationSlidingPanel'), "left", 10);

        $('#libraryInformationSlidingPanel').on('click', function () {
            if (infoPanelOpen) {
                slidingPanel.close(function () {
                    infoPanelOpen = false;
                });
            } else {
                slidingPanel.open(function () {
                    infoPanelOpen = true;
                });
            }
        });
    });
</script>