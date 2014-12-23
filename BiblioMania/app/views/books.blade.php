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
                    	<img bookId="{{ $books[(6*$i)+$j]->id }}" class="bookCoverLink" src="{{ $books[(6*$i)+$j]->coverImage }}">
                	</td>
				@endfor
			</tr>
		@endfor
		{{ $books->links() }}
	    </tbody>
	</table>

	@include('book/bookSlidingPanel')
</div>
@stop