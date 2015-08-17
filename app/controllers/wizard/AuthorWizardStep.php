<?php

class AuthorWizardStep extends WizardStep
{
    private $bookFolder = "book/wizard/";

    /** @var  BookService */
    private $bookService;
    /** @var  AuthorInfoParameterMapper */
    private $authorInfoParameterMapper;
    /** @var  BookCreationService */
    private $bookCreationService;

    public function __construct()
    {
        $this->bookService = App::make('BookService');
        $this->authorInfoParameterMapper = App::make('AuthorInfoParameterMapper');
        $this->bookCreationService = App::make('BookCreationService');
    }

    public function executeStep($id = null)
    {
        $preferredAuthorParams = $this->authorInfoParameterMapper->create();
        $secondaryAuthorParameters = $this->authorInfoParameterMapper->createSecondaryAuthors();
        return $this->bookCreationService->saveAuthorsToBook($id, $preferredAuthorParams, $secondaryAuthorParameters);
    }

    public function goToStep($id = null)
    {
        $withArray = BookFormFiller::fillForAuthor($id);
        $withArray['title'] = 'Auteur';
        $withArray['wizardSteps'] = $this->bookService->getWizardSteps($id);
        $withArray['authors_json'] = json_encode(Author::all(['id', 'name', 'firstname', 'infix']));
        return View::make($this->bookFolder . 'author')->with($withArray);
    }
}