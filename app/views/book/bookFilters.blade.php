<legend>Filter</legend>
<table id="book-filters-table" class="book-filters-table">
    <tr>
        <td>Gelezen:</td>
        <td>
            <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary filterRadioButton readFilterRadioButton">
                        <input type="radio" name="readFilter" value="YES"/> Ja
                </label>
                <label class="btn btn-primary filterRadioButton readFilterRadioButton">
                    <input type="radio" name="readFilter" value="NO"/> Nee
                </label>
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