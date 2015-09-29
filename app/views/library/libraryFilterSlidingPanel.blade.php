<div id="libraryFilterSlidingPanel" class="sliding-panel libraryFilterSlidingPanel">
    <div id="libraryFilterSlidingPanelTitle" class="slidingPanelTitle material-card-title">Filter</div>
    <div class="material-card-content">
        <table id="book-filters-table" class="book-filters-table">
            <tr>
                <td>Gelezen:</td>
                <td>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary filterRadioButton readFilterRadioButton">
                            <input type="radio" name="readFilter" value="YES"/> Ja
                        </label>
                        <lfabel class="btn btn-primary filterRadioButton readFilterRadioButton">
                            <input type="radio" name="readFilter" value="NO"/> Nee
                        </lfabel>
                    </div>
                </td>
            </tr>
            <tr>
                <td>In collectie</td>
                <td>
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-primary filterRadioButton ownedFilterRadioButton">
                            <input type="radio" name="ownedFilter" value="YES"/> Ja
                        </label>
                        <label class="btn btn-primary filterRadioButton ownedFilterRadioButton">
                            <input type="radio" name="ownedFilter" value="NO"/> Nee
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <button class="btn btn-success" id="deselect">Reset</button>
                </td>
            </tr>
        </table>
    </div>
    <div id="libraryFilterBookMark" class="bookMark libraryFilterBookmark">
        {{ HTML::image('images/filter_icon.png', 'filter',array('class'=>'info-icon')) }}
    </div>
</div>

<script type="text/javascript">
    $(function () {
        var slidingPanel = new BorderSlidingPanel($('#libraryFilterSlidingPanel'), "left", 10);
        $('#libraryFilterSlidingPanel').on('mouseover', function () {
            slidingPanel.open(function () {
            });
        });
        $('#libraryFilterSlidingPanel').on('mouseout', function () {
            slidingPanel.close(function () {
            });
        });
    });
</script>