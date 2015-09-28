<div id="libraryInformationSlidingPanel" class="sliding-panel libraryInformationSlidingPanel">
    <div id="libraryInformationSlidingPanelTitle" class="slidingPanelTitle material-card-title">Informatie collectie</div>
    <div class="material-card-content">
        <div class="row">
            {{ Form::label('amountOfBooksLabel', 'Aantal boeken:' , array('class' => 'control-label col-md-9')); }}
            {{ Form::label('amountOfBooks', $total_amount_of_books , array('class' => 'control-label col-md-2')); }}
        </div>
        <div class="row">
            {{ Form::label('valueLabel', 'Aantal boeken in bezit:' , array('class' => 'control-label col-md-9')); }}
            {{ Form::label('value', $total_amount_of_books_owned, array('class' => 'control-label col-md-2')); }}
        </div>
        <div class="row">
            {{ Form::label('valueLabel', 'Waarde bibliotheek:' , array('class' => 'control-label col-md-9')); }}
            {{ Form::label('value', $total_value_library  . ' euro', array('class' => 'control-label col-md-2')); }}
        </div>
    </div>
    <div id="libraryInformationBookMark" class="bookMark libraryInformationBookmark">
        {{ HTML::image('images/info_icon.png', 'information',array('class'=>'info-icon')) }}
    </div>
</div>

<script type="text/javascript">
    $(function () {
        var slidingPanel = new BorderSlidingPanel($('#libraryInformationSlidingPanel'), "left");
        $('#libraryInformationSlidingPanel').on('mouseover', function () {
            slidingPanel.open(function () {

            });
        });
        $('#libraryInformationSlidingPanel').on('mouseout', function () {
            slidingPanel.close(function () {

            });
        });
    });
</script>