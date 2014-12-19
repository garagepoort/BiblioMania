@extends('main')

@section('content')
<script type="text/javascript">
    var data = {{ $books_json }};
    var books = data.data;
</script>
{{ HTML::script('assets/js/book/books.js'); }}
<div class="books-container">
	<h1>Mijn collectie</h1>
	<table class="table books-table">
	    <tbody >

    	 @for ($i = 0; $i <= count($books)/5; $i++)
        	<tr>
        		{{-- */
        			$columns = 5;
        			 if($i*5+5 > count($books)){
        				$columns =  fmod(count($books), 5);
        			}
        		/* --}}
        		@for ($j = 0; $j < $columns; $j++)
			    	<td>
                    	<img bookId="{{ $books[(5*$i)+$j]->id }}" class="bookCoverLink" src="{{ $books[(5*$i)+$j]->coverImage }}">
                	</td>
				@endfor
			</tr>
		@endfor
		{{ $books->links() }}
	    </tbody>
	</table>

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
</div>
@stop