@extends('main')

@section('content')
<script type="text/javascript">
    var data = {{ $books_json }};
    var books = data.data;
    var baseUrl = "{{ URL::to('/') }}";
</script>
{{ HTML::script('assets/js/book/books.js'); }}

<div class="books-container">
	<table width='100%' class='title-table'>
        <tr>
            <td>
                <h1>Mijn collectie</h1>
            </td>
            <td>
            </td>
            <td style="text-align:right;">
                <button class='btn btn-default' id='filterButton'>Filter</button>
                <button href="createBook" class='clickableRow btn btn-default'>Nieuw boek</button>
            </td>
        </tr>
    </table>


    <div id="book-collection-filter-panel" class="book-collection-filter-panel" hidden>
        <legend>Filter</legend>
        <div class="form-group">
            <!-- FILTERS -->
                {{ Form::label('filterLabel', 'Filter op:', array('class' => 'col-md-3')); }}
                <div class="col-md-5">
                    <select id="filterSelect" name="filter_value" class="input-sm">
                        @foreach($bookFilters as $bookFilter)
                        <option value="{{ $bookFilter->columnName }}">{{ $bookFilter->viewName }}</option>
                        @endforeach
                    </select>
                </div>
        </div>
    </div>

    <div class="book-collection-info-panel">
        <legend>Informatie collectie</legend>
        <div class="control-group">
            {{ Form::label('amountOfBooksLabel', 'Aantal boeken:' , array('class' => 'control-label col-md-5')); }}
            {{ Form::label('amountOfBooks', $total_amount_of_books , array('class' => 'control-label col-md-3')); }}
        </div>
        <div class="control-group">
            {{ Form::label('valueLabel', 'Aantal boeken in bezit:' , array('class' => 'control-label col-md-5')); }}
            {{ Form::label('value', $total_amount_of_books_owned, array('class' => 'control-label col-md-3')); }}
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
                        {{ HTML::image($books[(6*$i)+$j]->coverImage, 'notfound', array(
                        'bookId' => $books[(6*$i)+$j]->id, 
                        'class' => 'bookCoverLink', 
                        'onError'=>"this.onError=null;this.src='" . URL::to('/') . "/images/questionCover.png';")) }}
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