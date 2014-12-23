<div id="slide" class="book-detail-div">
		<div id="book-detail-close-div">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true" style="margin-left: -7px"></span>
		</div>
		<div class="book-detail-container">
			<h1 id="book-detail-title">title</h1>
			<h4 id="book-detail-subtitle">subtit</h4>
			<img id="book-detail-coverimage" src="" width="120px" height="160px"/>
			<div class="book-details-info-container">
				<div class="control-group">
					{{ Form::label('authorLabel', 'Auteur:' , array('class' => 'control-label col-md-4')); }}
					{{ Form::label('auteur', "auteur" , array('id'=>'book-detail-author' ,'class' => 'control-label col-md-7')); }}
				</div>
				<div class="control-group">
					{{ Form::label('isbnLabel', 'ISBN:' , array('class' => 'control-label col-md-4')); }}
					{{ Form::label('isbn', "ISBN" , array('id'=>'book-detail-isbn' ,'class' => 'control-label col-md-7')); }}
				</div>
				<div class="control-group">
					{{ Form::label('publisherLabel', 'Publisher:' , array('class' => 'control-label col-md-4')); }}
					{{ Form::label('publisher', "Publisher" , array('id'=>'book-detail-publisher' ,'class' => 'control-label col-md-7')); }}
				</div>
			</div>
		</div>
	</div>