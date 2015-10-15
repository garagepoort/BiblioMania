@extends('main')

@section('title')
    uitgevers
@stop
@section('content')
    {{ HTML::script('assets/js/publisher/publishersList.js'); }}
    {{ HTML::script('assets/js/publisher/PublisherService.js'); }}

    <div class="list-container">
        <div id="publisher-list-merge-container" class="container list-merge-container" hidden>
            <h5>Uitgevers om samen te voegen:</h5>
            {{ Form::select('', array(), '', array('class' => 'input-sm form-control selectMergePublisher', 'id' => 'selectMergePublisher')); }}
            <ul id="publisher-merge-list">
            </ul>
            <button id="mergePublishersButton" class="btn btn-primary">Samenvoegen</button>
        </div>
        <div class="editListPanel">
            <table id="publisherEditList" class="table">
                <thead>
                <tr>
                    <th>Naam</th>
                    <th>Boeken</th>
                    <th>Eerste druks</th>
                    <th>Samenvoegen</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($publishers as $publisher)
                    <tr publisher-id="{{ $publisher->id }}">
                        <td>
                            <a class="namePublisher" data-name="name" href="#" data-type="text" data-pk={{ $publisher->id }} data-url={{ URL::to('editPublisher') }} data-title="Vul naam in">{{ $publisher->name }}</a>
                        </td>
                        <td style="text-align: center">
                            {{ count($publisher->books) }}
                        </td>
                        <td style="text-align: center">
                            {{ count($publisher->first_print_infos) }}
                        </td>
                        <td style="text-align: center">
                            {{ Form::checkbox('merge-checkbox', false, false, array('class'=>'merge-publisher-checkbox', 'publisher-id'=>$publisher->id)); }}
                        </td>
                        <td style="text-align: center">
                            <span aria-hidden="true" style="margin-left:10px" class="fa fa-times-circle publisherlist-cross" width="10px"/>
                        </td>
                        <td style="text-align: center">
                            <span aria-hidden="true" style="margin-left:10px" class="fa fa-arrow-right publisherlist-goto" width="10px"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop