@extends('main')

@section('content')
<script type="text/javascript">
    var data = {{ $books_json }};
    var books = data.data;
    var baseUrl = "{{ URL::to('/') }}";
</script>
{{ HTML::script('assets/js/book/books.js'); }}
<div class="books-container">
	<table width='100%'>
        <tr>
            <td>
                <h1>Mijn collectie</h1>
            </td>
            <td>
                <button href="createBook" class='clickableRow btn btn-default' style="float: right">Nieuw boek</button>
            </td>
        </tr>
    </table>
    <div class="book-collection-info-panel">
        <legend>Informatie collectie</legend>
        <div class="control-group">
            {{ Form::label('amountOfBooksLabel', 'Aantal boeken:' , array('class' => 'control-label col-md-5')); }}
            {{ Form::label('amountOfBooks', $total_amount_of_books , array('class' => 'control-label col-md-3')); }}
        </div>
        <div class="control-group">
            {{ Form::label('valueLabel', 'Waarde bibliotheek:' , array('class' => 'control-label col-md-5')); }}
            {{ Form::label('value', $total_value_library  . ' euro', array('class' => 'control-label col-md-3')); }}
        </div>
    </div>
	<table class="table books-table">
	    <tbody >

    	 @for ($i = 0; $i <= count($books)/6; $i++)
        	<tr>
        		{{-- */
        			$columns = 6;
        			 if($i*6+6 > count($books)){
        				$columns =  fmod(count($books), 6);
        			}
        		/* --}}
        		@for ($j = 0; $j < $columns; $j++)
			    	<td>
                        {{ HTML::image($books[(6*$i)+$j]->coverImage, 'notfound', array('bookId' => $books[(6*$i)+$j]->id, 'class' => 'bookCoverLink')) }}
                	</td>
				@endfor
			</tr>
		@endfor
		{{ $books->appends(Request::except('page'))->links() }}
	    </tbody>
	</table>

	@include('book/bookSlidingPanel')
</div>
@stop