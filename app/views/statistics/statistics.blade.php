@extends('main')
@section('title')
    <span id="statistics-title">{{ $title }}</span>
@stop
@section('content')
    <div class="statistics-container">
        <div role="tabpanel">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#overview" aria-controls="overview"
                                                          role="tab" data-toggle="tab">Overview</a></li>
                <li role="presentation"><a href="#overview" aria-controls="overview"
                                                          role="tab" data-toggle="tab">Overview</a></li>
            </ul>

            <!-- Tab panes -->
            <div id="error-div" class="material-card error-message" hidden>
                <div id="error-message" class="material-card-content error-message"></div>
            </div>
            <div>
                <div role="tabpanel" class="tab-pane active" id="overview">
                    @include('statistics/statisticsOverview')
                </div>
            </div>
        </div>
    </div>

@stop
