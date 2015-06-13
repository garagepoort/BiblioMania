<div id="slide" class="book-detail-div">
    <div id="book-detail-close-div" class="book-detail-close">
        <span id="close-book-detail-icon" class="glyphicon glyphicon-arrow-right" aria-hidden="true" style="float: left;"></span>

        <h1 class="book-sliding-panel-title" id="book-detail-title">title</h1>
        <h4 class="book-sliding-panel-title" id="book-detail-subtitle">subtitle</h4>
    </div>

    <div class="book-detail-container" id="book-detail-container">

        <div class="book-detail-main-info">
            <img id="book-detail-coverimage" src="" width="142px"/>

            <div class="material-card book-details-info-container">
                <div class="material-card-title">Info boek</div>
                <div class="material-card-content">
                    <table width="100%">
                        <tr>
                            <td>
                                <div id="star-detail"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div id="star-detail" class="col-md-6"></div>
                                <table width="100%">
                                    <tr>
                                        <td><label>Auteur:</label></td>
                                        <td><label id='book-detail-author'></label></td>
                                    </tr>
                                    <tr>
                                        <td><label>ISBN:</label></td>
                                        <td><label id='book-detail-isbn'></label></td>
                                    </tr>
                                    <tr>
                                        <td><label>Uitgever</label></td>
                                        <td><label id='book-detail-publisher'></label></td>
                                    </tr>
                                    <tr>
                                        <td><label>Land</label></td>
                                        <td><label id='book-detail-country'></label></td>
                                    </tr>
                                    <tr>
                                        <td><label>Publicatiedatum:</label></td>
                                        <td><label id='book-detail-publication-date'></label></td>
                                    </tr>
                                    <tr>
                                        <td><label>Genre:</label></td>
                                        <td><label id='book-detail-genre'></label></td>
                                    </tr>
                                    <tr>
                                        <td><label>Boekenreeks:</label></td>
                                        <td><label id='book-detail-serie'></label></td>
                                    </tr>
                                    <tr>
                                        <td><label>Uitgeverreeks:</label></td>
                                        <td><label id='book-detail-publisher-serie'></label></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>

        <div class="card-row" style="margin-top: 250px; clear: both">
            <div class="book-detail-summary material-card">
                <div class="material-card-title">Samenvatting</div>
                <div class="material-card-content">
                    <p id="book-detail-summary"></p>
                </div>
            </div>
        </div>

        <div class="card-row">
            <div class="book-detail-small-info-panel material-card card-column-left">
                <div class="material-card-title">Details</div>
                <div class="material-card-content">
                    <table width="100%">
                        <tr>
                            <td><label>Cover prijs:</label></td>
                            <td><label id='book-detail-retail-price'></label></td>
                        </tr>
                        <tr>
                            <td><label>Pagina's:</label></td>
                            <td><label id='book-detail-number-of-pages'></label></td>
                        </tr>
                        <tr>
                            <td><label>Druk:</label></td>
                            <td><label id='book-detail-print'></label></td>
                        </tr>
                        <tr>
                            <td><label>Vertaler:</label></td>
                            <td><label id='book-translator'></label></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="book-detail-small-info-panel material-card card-column-right">
                <div class="material-card-title">Persoonlijk</div>
                <div class="material-card-content">
                    <table width="100%">
                        <tr>
                            <td><label>In collectie:</label></td>
                            <td><input disabled type="checkbox" id='book-detail-owned'></td>
                        </tr>
                        <tr>
                            <td><label>Gelezen:</label></td>
                            <td><input disabled type="checkbox" id='book-detail-read'/></td>
                        </tr>
                        <tr class="buy-info-tr">
                            <td><label>Aanschafdatum:</label></td>
                            <td><label id='book-detail-buy-info-date'></label></td>
                        </tr>
                        <tr class="buy-info-tr">
                            <td><label>Aankoopprijs:</label></td>
                            <td><label id='book-detail-buy-info-price-payed'></label></td>
                        </tr>
                        <tr class="buy-info-tr">
                            <td><label>Winkel:</label></td>
                            <td><label id='book-detail-buy-info-shop'></label></td>
                        </tr>
                        <tr class="buy-info-tr">
                            <td><label>Stad winkel:</label></td>
                            <td><label id='book-detail-buy-info-city'></label></td>
                        </tr>
                        <tr class="buy-info-tr">
                            <td><label>Reden:</label></td>
                            <td><label id='book-detail-buy-info-reason'></label></td>
                        </tr>
                        <tr class="buy-info-tr">
                            <td><label>Land gekocht:</label></td>
                            <td><label id='book-detail-buy-info-country'></label></td>
                        </tr>
                        <tr class="gift-info-tr">
                            <td><label>Ontvangstdatum:</label></td>
                            <td><label id='book-detail-gift-info-date'></label></td>
                        </tr>
                        <tr class="gift-info-tr">
                            <td><label>Gekregen van:</label></td>
                            <td><label id='book-detail-gift-info-from'></label></td>
                        </tr>
                        <tr class="gift-info-tr">
                            <td><label>Gelegenheid:</label></td>
                            <td><label id='book-detail-gift-info-occasion'></label></td>
                        </tr>
                        <tr class="gift-info-tr">
                            <td><label>Reden:</label></td>
                            <td><label id='book-detail-gift-info-reason'></label></td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>

        <div class="card-row">

            <div class="book-detail-small-info-panel material-card">
                <div class="material-card-title">Eerste druk</div>
                <div class="material-card-content">
                    <table width="100%">
                        <tr>
                            <td><label>Titel:</label></td>
                            <td><label id='book-detail-first-print-title'></label></td>
                        </tr>
                        <tr>
                            <td><label>Ondertitel:</label></td>
                            <td><label id='book-detail-first-print-subtitle'></label></td>
                        </tr>
                        <tr>
                            <td><label>ISBN:</label></td>
                            <td><label id='book-detail-first-print-isbn'></label></td>
                        </tr>
                        <tr>
                            <td><label>Land:</label></td>
                            <td><label id='book-detail-first-print-country'></label></td>
                        </tr>
                        <tr>
                            <td><label>Taal:</label></td>
                            <td><label id='book-detail-first-print-language'></label></td>
                        </tr>
                        <tr>
                            <td><label>Uitgever:</label></td>
                            <td><label id='book-detail-first-print-publisher'></label></td>
                        </tr>
                        <tr>
                            <td><label>Publicatie datum:</label></td>
                            <td><label id='book-detail-first-print-publication-date'></label></td>
                        </tr>
                    </table>
                </div>
            </div>
    </div>
</div>
</div>