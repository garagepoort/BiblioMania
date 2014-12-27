<div id="slide" class="book-detail-div">
		<div id="book-detail-close-div">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="margin-left: -7px"></span>
		</div>
		<div class="book-detail-container">
			<h1 id="book-detail-title">title</h1>
			<h4 id="book-detail-subtitle">subtitle</h4>
			<div class="book-detail-main-info">
				<img id="book-detail-coverimage" src="" width="142px" height="226px"/>
				<div id="star-detail" class="col-md-6"></div>
				<div class="book-details-info-container">
					<div class="control-group">
						{{ Form::label('authorLabel', 'Auteur:' , array('class' => 'control-label col-md-4')); }}
						{{ Form::label('auteur', "auteur" , array('id'=>'book-detail-author' ,'class' => 'control-label col-md-4')); }}
					</div>
					<div class="control-group">
						{{ Form::label('isbnLabel', 'ISBN:' , array('class' => 'control-label col-md-4')); }}
						{{ Form::label('isbn', "ISBN" , array('id'=>'book-detail-isbn' ,'class' => 'control-label col-md-4')); }}
					</div>
					<div class="control-group">
						{{ Form::label('publisherLabel', 'Publisher:' , array('class' => 'control-label col-md-4')); }}
						{{ Form::label('publisher', "Publisher" , array('id'=>'book-detail-publisher' ,'class' => 'control-label col-md-4')); }}
					</div>
					<div class="control-group">
						{{ Form::label('genreLabel', 'Genre:' , array('class' => 'control-label col-md-4')); }}
						{{ Form::label('genre', "genre" , array('id'=>'book-detail-genre' ,'class' => 'control-label col-md-4')); }}
					</div>
					<div class="control-group">
						{{ Form::label('genreLabel', 'Publicatie datum:' , array('class' => 'control-label col-md-4')); }}
						{{ Form::label('publicatiedatum', "publicatiedatum" , array('id'=>'book-detail-publication-date' ,'class' => 'control-label col-md-4')); }}
					</div>
					<div class="control-group">
						{{ Form::label('number_of_pages_label', "Pagina's:" , array('class' => 'control-label col-md-4')); }}
						{{ Form::label('number_of_pages', "paginas" , array('id'=>'book-detail-number-of-pages' ,'class' => 'control-label col-md-4')); }}
					</div>
					<div class="control-group">
						{{ Form::label('printLabel', 'Druk:' , array('class' => 'control-label col-md-4')); }}
						{{ Form::label('print', "print" , array('id'=>'book-detail-print' ,'class' => 'control-label col-md-4')); }}
					</div>
				</div>
			</div>

			<div class="book-detail-summary">
				<legend>Samenvatting</legend>
				<p id="book-detail-summary"></p>
			</div>
			<table class="book-detail-info-table">
				<tr>
					<td>
						<div class="book-detail-extra-info">
							<legend>Extra info</legend>
							<div class="control-group">
									{{ Form::label('retailPrice', 'Cover prijs:' , array('class' => 'control-label col-md-6')); }}
									{{ Form::label('retailPrice', "retailPrice" , array('id'=>'book-detail-retail-price' ,'class' => 'control-label col-md-6')); }}
							</div>
						</div>
					</td>
					<td>
						<div class="book-detail-first-print-info">
							<legend>Eerste druk</legend>
							<div class="control-group">
									{{ Form::label('firstPrintTitleLabel', 'Title:' , array('class' => 'control-label col-md-6')); }}
									{{ Form::label('firstPrintTitle', "firstPrintTitle" , array('id'=>'book-detail-first-print-title' ,'class' => 'control-label col-md-6')); }}
							</div>
							<div class="control-group">
								{{ Form::label('firstPrintISBNLabel', 'ISBN:' , array('class' => 'control-label col-md-6')); }}
								{{ Form::label('firstPrintISBN', "firstPrintISBN" , array('id'=>'book-detail-first-print-isbn' ,'class' => 'control-label col-md-6')); }}
							</div>
						</div>
					</td>
				</tr>
			</table>

		</div>
</div>