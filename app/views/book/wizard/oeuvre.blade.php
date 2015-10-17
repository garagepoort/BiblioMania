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
                <div style="margin-bottom: 20px;">
                    <button class='btn btn-primary' onclick="toggleAddOevreItems(); hideEditOevreItems(); return false;">Voeg oeuvre items toe</button>
                    <button class='btn btn-primary' onclick="toggleEditOevreItems(); hideAddOevreItems(); return false;">Pas bestaande items aan</button>
                </div>

                @include('author.addOeuvreItems', array("author_id"=>$author_id))
                @include('author.editOeuvreItems', array("author_id"=>$author_id, "oeuvre_json"=>$oeuvre_json))

                <table id="author-oeuvre-table" class="table">
                    <thead>
                    <tr>
                        <th>Titel</th>
                        <th>Publicatiejaar</th>
                        <th>Verwijderen</th>
                        <th>Linked</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($oeuvre as $bookFromAuthor)
                        <tr>
                            <td>
                                <a
                                        class="author-oeuvre-title"
                                        data-name="name" href="#"
                                        data-type="text"
                                        data-pk="{{ $bookFromAuthor->id }}"
                                        data-url="{{ URL::to('updateBookFromAuthorTitle') }}"
                                        data-title="Vul naam in">{{ $bookFromAuthor->title }}</a>
                            </td>
                            <td>
                                <a class="author-oeuvre-title"
                                   data-name="year" href="#"
                                   data-type="text"
                                   data-pk="{{ $bookFromAuthor->id }}"
                                   data-url="{{ URL::to('updateBookFromAuthorPublicationYear') }}"
                                   data-title="Vul jaar in">{{ $bookFromAuthor->publication_year }}</a>
                            </td>
                            <td oeuvre-id="{{ $bookFromAuthor->id }}" style="text-align: center">
                                @if(count($bookFromAuthor->books)==0)
                                    <span aria-hidden="true" style="margin-left:10px"
                                          class="fa fa-times-circle oeuvre-author-cross" width="10px"/>
                                @endif
                            </td>
                            <td oeuvre-id="{{ $bookFromAuthor->id }}" book-id="{{ $book_id }}">
                                @if($bookFromAuthor->id == $linked_book_id)
                                    <label class="label label-success">LINKED</label>
                                @elseif(count($bookFromAuthor->books)==0)
                                    <label class="linkLabel label label-danger">UNLINKED</label>
                                @else
                                    <label class="linkLabel label label-warning">LINKED TO OTHER BOOK</label>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @include('WIZARDSERVICE::wizardbuttons', array("onSubmit"=>"validateForm();"))
            </div>

        </fieldset>
        {{ Form::close(); }}
    </div>
    <script type="text/javascript">
    </script>
    {{ HTML::script('assets/js/book/wizard/createBook.js'); }}
    {{ HTML::script('assets/js/book/wizard/oeuvre.js'); }}
    {{ HTML::script('assets/js/author/BookFromAuthorService.js'); }}
    {{ HTML::script('assets/js/book/DeleteBookDialog.js'); }}
    {{ HTML::script('assets/js/book/BookService.js'); }}
@endsection
@stop