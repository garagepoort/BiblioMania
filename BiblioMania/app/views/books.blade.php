@extends('main')


@section('title')
    Mijn collectie
@stop

@section('content')
<script type="text/javascript">
    var book_id = "{{ $book_id }}";
</script>
{{ HTML::script('assets/js/book/books.js'); }}

<div class="books-container">
    <div class="contentPanel">

        <table width='100%' class='title-table'>
            <tr>
                <td>Sorteer op: {{ Form::select('order', $order_by_options, null, array('id' => 'orderby-select-box', 'class'=> 'form-control')); }}</td>
                <td style="text-align:right;">
                    <button class='btn btn-primary' id='filterButton'>Filter</button>
                    <button href="createBook" class='clickableRow btn btn-primary'>Nieuw boek</button>
                </td>
            </tr>
        </table>


        <div id="book-collection-filter-panel" class="book-collection-filter-panel" hidden>
            @include('book/bookFilters')
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
        <table class="table books-table" id="books-container-table">
            <tbody class="infinite-container">
            </tbody>
        </table>
        <div id="books-loading-waypoint" style="text-align:center;">
            {{ HTML::image('images/ajax-loader.gif', 'loader', array('id'=>'loader-icon')) }}
        </div>
    </div>

	@include('book/bookSlidingPanel')
</div>
@stop
