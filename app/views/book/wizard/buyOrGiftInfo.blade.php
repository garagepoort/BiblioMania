@extends('main')
@section("title")
    {{ $title }}
@endsection
@section("title-buttons")
    @include("book/wizard/bookDeleteButton", array("bookId"=>$book_id))
@endsection
@section("content")
    @include('WIZARDSERVICE::wizardsteps', array('progress' => $book_wizard_step))
    <div class="create-book-div">
        {{ Form::open(array('id'=>'createOrEditBookForm', 'url' => $currentStep->url . $book_id, 'class' => 'form-horizontal createBookForm', 'autocomplete' => 'off', 'files' => 'true')); }}
        @include('error', array("id"=>"error-div"))

        <fieldset>
            @if ($errors->has())
                @foreach ($errors->all() as $error)
                    <div id="bookInfoMessage" class="alert-danger alert">
                        <strong>{{ $error }}</strong>
                    </div>
                @endforeach
            @endif

            <div class="form-container">

                <div class="buyOrGiftPanel">
                    <div class="btn-group" data-toggle="buttons">
                        <label class="btn btn-default @if($buyOrGift == 'BUY') active @endif">
                            <input id="buyRadioButton" type="radio" name="buyOrGift" value="BUY" @if($buyOrGift == 'BUY') checked @endif/> Gekocht
                        </label>
                        <label class="btn btn-default @if($buyOrGift == 'GIFT') active @endif">
                            <input id="giftRadioButton" type="radio" name="buyOrGift" value="GIFT" @if($buyOrGift == 'GIFT') checked @endif/> Gekregen
                        </label>
                    </div>
                </div>
                <div id="buyInfoPanel" @if($buyOrGift == 'GIFT') hidden @endif>
                    @include('book/wizard/buyInfo')
                </div>
                <div id="giftInfoPanel" @if($buyOrGift == 'BUY') hidden @endif>
                    @include('book/wizard/giftInfo')
                </div>

                @include('WIZARDSERVICE::wizardbuttons', array("onSubmit"=>"validateForm();"))
            </div>

        </fieldset>
        {{ Form::close(); }}
    </div>

    <script type="text/javascript">
        var country_json = {{ $countries_json }};
        var shops_json = {{ $shops_json }};
        var gifters_json = {{ $gifters_json }};
        var country_names = [];
        var shop_names = [];
        var gifter_names = [];
        $.each(country_json, function (index, obj) {
            country_names[country_names.length] = obj.name;
        });
        $.each(shops_json, function (index, obj) {
            shop_names[shop_names.length] = obj;
        });
        $.each(gifters_json, function (index, obj) {
            gifter_names[gifter_names.length] = obj;
        });
    </script>
    {{ HTML::script('assets/js/book/wizard/createBook.js'); }}
    {{ HTML::script('assets/js/book/wizard/buyOrGiftInfo.js'); }}
    {{ HTML::script('assets/js/book/DeleteBookDialog.js'); }}
    {{ HTML::script('assets/js/book/BookService.js'); }}
@endsection
@stop