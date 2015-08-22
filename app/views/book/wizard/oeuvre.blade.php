@extends('main')
@section("title")
    {{ $title }}
@endsection
@section("content")
    <div class="wizard-steps">
        @include('book/wizard/wizardsteps', array('wizardSteps' => $wizardSteps, 'currentStep' => $currentStep->stepNumber, 'progress' => $book_wizard_step))
    </div>
    <div class="create-book-div">
        {{ Form::open(array('id'=>'createOrEditBookForm', 'url' => $currentStep->url . $book_id, 'class' => 'form-horizontal createBookForm', 'autocomplete' => 'off', 'files' => 'true')); }}
        <input id="redirectInput" hidden name="redirect" value="NEXT">
        <div id="error-div" class="material-card error-message" hidden>
            <div id="error-message" class="material-card-content error-message"></div>
        </div>

        <fieldset>
            @if ($errors->has())
                @foreach ($errors->all() as $error)
                    <div id="bookInfoMessage" class="alert-danger alert">
                        <strong>{{ $error }}</strong>
                    </div>
                @endforeach
            @endif

            <div class="form-container">
                <div id='oeuvre-textarea-panel'>
                    <textarea placeholder="<jaar> - <titel>" id='oeuvre-textarea' name="oeuvre" cols="80"
                              rows="5"></textarea>
                    <button class='btn btn-default' id='oeuvreButton' onclick="addOeuvreItems(); return false;">Pas oeuvre aan</button>
                </div>

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
                @include('book/wizard/submitButtons')
            </div>

        </fieldset>
        {{ Form::close(); }}
    </div>
    <script type="text/javascript">
        var author_id = "{{ $author_id }}"
    </script>
    {{ HTML::script('assets/js/book/wizard/createBook.js'); }}
    {{ HTML::script('assets/js/book/wizard/oeuvre.js'); }}
@endsection
@stop