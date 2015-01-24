@extends('main')

@section('title')
    uitgevers
@stop
@section('content')
    <script type="text/javascript">
        var baseUrl = "{{ URL::to('/') }}";
    </script>
    {{ HTML::script('assets/js/publisher/publishersList.js'); }}

    <div class="list-container">
        <table id="publisherEditList" class="table publisherEditListTable">
            <thead>
            <tr>
                <th>Naam</th>
                <th style="text-align: center">Aantal boeken</th>
                <th style="text-align: center">Verwijderen</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($publishers as $publisher)
                <tr>
                    <td>
                        <a class="namePublisher" data-name="name" href="#" data-type="text" data-pk={{ $publisher->id }} data-url={{ URL::to('editPublisher') }} data-title="Vul naam in">{{ $publisher->name }}</a>
                    </td>
                    <td style="text-align: center">
                        {{ count($publisher->books) + count($publisher->first_print_infos) }}
                    </td>
                    <td style="text-align: center">
                        <span aria-hidden="true" style="margin-left:10px" class="fa fa-times-circle publisherlist-cross" width="10px"/>
                    </td>
                </tr>
            @endforeach
            {{ $publishers->links() }}
            </tbody>
        </table>
    </div>
@stop