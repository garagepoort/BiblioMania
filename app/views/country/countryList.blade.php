@extends('main')

@section('title')
    Landen
@stop
@section('content')
    <div class="list-container">
        @include('mergePanel', array('panelId' => 'countryMergePanel', 'title' => 'Samenvoegen'))
        <div class="editListPanel">
            <table id="countryEditList" class="table">
                <thead>
                <tr>
                    <th>Land</th>
                    <th>Boeken</th>
                    <th>Auteurs</th>
                    <th>Samenvoegen</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach ($countries as $country)
                    <tr country-id="{{ $country->id }}" country-name="{{ $country->name }}">
                        <td>
                            <a class="nameCountry" data-name="name" href="#" data-type="text" data-pk={{ $country->id }} data-url={{ URL::to('editCountry') }} data-title="Vul naam in">{{ $country->name }}</a>
                        </td>
                        <td style="text-align: center">
                            {{ count($country->books) }}
                        </td>
                        <td style="text-align: center">
                            {{ count($country->authors) }}
                        </td>
                        <td style="text-align: center">
                            {{ Form::checkbox('merge-checkbox', false, false, array('class'=>'merge-country-checkbox')); }}
                        </td>
                        <td style="text-align: center">
                            <span aria-hidden="true" style="margin-left:10px" class="fa fa-times-circle countrylist-cross" width="10px"/>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ HTML::script('assets/js/country/countryList.js'); }}
    {{ HTML::script('assets/js/country/CountryService.js'); }}
@stop