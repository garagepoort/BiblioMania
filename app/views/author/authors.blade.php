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
						<li><a href="#author.name">Auteur naam</a></li>
						<li><a href="#author.firstname">Auteur voornaam</a></li>
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
				<input id="searchAuthorsInput" type="text" class="form-control" placeholder="Search" name="criteria">
			</td>
			<td>
				<button id="searchAuthorsButton" class="btn btn-primary searchButton"><span class="glyphicon glyphicon-search"></span></button>
			</td>
		</tr>
	</table>
@stop

@section('title')
Auteurs
@stop
@section('content')
{{ HTML::script('assets/js/author/authors.js'); }}
{{ HTML::script('assets/js/filter_dropdown.js') }}

<div class="authors-container">
	<table class="table authors-table" id="authors-container-table">
	    <tbody>
	    </tbody>
	</table>
    <div id="authors-loading-waypoint" style="text-align:center;">
        {{ HTML::image('images/ajax-loader.gif', 'loader', array('id'=>'loader-icon')) }}
		<p id="no-results-message" hidden>No results found.</p>
    </div>
</div>
@stop