@extends('main')

@section('navbarRight')
    <table class="search-box-table">
        <tr>
            <td>
                <div class="input-group-btn search-panel-type">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span id="search_concept">Alles</span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#book.title">Titel</a></li>
                        <li><a href="#author.name">Auteur naam</a></li>
                        <li><a href="#author.firstname">Auteur voornaam</a></li>
                        <li><a href="#serie.name">Boek serie</a></li>
                        <li><a href="#publisher_serie.name">Uitgever serie</a></li>
                        <li class="divider"></li>
                        <li><a href="#all">Alles</a></li>
                    </ul>
                    <input type="hidden" name="search_param_type" value="all" id="search_param_type">
                </div>
            </td>
            <td>
                <div class="input-group-btn search-panel-operator">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <span id="search_concept">bevat</span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#contains">bevat</a></li>
                        <li><a href="#equals">is</a></li>
                        <li><a href="#begins_with">begint met</a></li>
                        <li><a href="#ends_with">eindigt met</a></li>
                    </ul>
                </div>
                <input type="hidden" name="search_param" value="contains" id="search_param_operator">
            </td>
            <td>
                <input id="searchBooksInput" type="text" class="form-control" placeholder="Search" name="criteria">
            </td>
            <td>
                <button id="searchBooksButton" class="btn btn-primary searchButton"><span class="glyphicon glyphicon-search"></span></button>
            </td>
        </tr>
    </table>
@stop

@section('title')
    Mijn collectie
@stop

@section('content')
<script type="text/javascript">
    var book_id = "{{ $book_id }}";
</script>
{{ HTML::script('assets/js/book/books.js'); }}
{{ HTML::script('assets/js/filter_dropdown.js') }}
{{ HTML::script('assets/js/books/search_books.js') }}

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
            <p id="no-results-message" hidden>No results found.</p>
        </div>
    </div>

	@include('book/bookSlidingPanel')
</div>
@stop
