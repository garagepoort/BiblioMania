<?php

use Bendani\PhpCommon\Utils\Ensure;
use Bendani\PhpCommon\Utils\Exception\ServiceException;
use Bendani\PhpCommon\Utils\StringUtils;

class AuthorService
{
    /** @var  ImageService */
    private $imageService;
    /** @var  AuthorRepository */
    private $authorRepository;
    /** @var  DateService */
    private $dateService;

    function __construct()
    {
        $this->dateService = App::make('DateService');
        $this->authorRepository = App::make('AuthorRepository');
        $this->imageService = App::make('ImageService');
    }

    public function find($id){
        return $this->authorRepository->find($id, array('oeuvre'));
    }

    public function create(CreateAuthorRequest $createAuthorRequest){
        $author_model = new Author();
        if(!is_null($createAuthorRequest->getName())){
            $author = $this->authorRepository->getAuthorByFullName($createAuthorRequest->getName()->getLastname(), $createAuthorRequest->getName()->getFirstname(), $createAuthorRequest->getName()->getInfix());
            if(!is_null($author)){
                throw new ServiceException('error.author.can.not.be.created.author.already.exists.with.same.name');
            }
        }
        return $this->saveAuthor($author_model, $createAuthorRequest);
    }

    public function update(UpdateAuthorRequest $updateAuthorRequest){
        $author_model = $this->authorRepository->find($updateAuthorRequest->getId());
        Ensure::objectNotNull("author", $author_model);

        return $this->saveAuthor($author_model, $updateAuthorRequest);
    }

    private function saveAuthor($author, BaseAuthorRequest $baseAuthorRequest){
        return DB::transaction(function() use ($author, $baseAuthorRequest){
            Ensure::objectNotNull('author create request name', $baseAuthorRequest->getName());

            $author->name = $baseAuthorRequest->getName()->getLastname();
            $author->firstname = $baseAuthorRequest->getName()->getFirstname();
            $author->infix = $baseAuthorRequest->getName()->getInfix();

            if($baseAuthorRequest->getDateOfBirth() != null){
                $newDate = $this->dateService->create($baseAuthorRequest->getDateOfBirth());
                $this->authorRepository->updateAuthorDateOfBirth($author, $newDate->id);
            }

            if($baseAuthorRequest->getDateOfDeath() != null){
                $newDate = $this->dateService->create($baseAuthorRequest->getDateOfDeath());
                $this->authorRepository->updateAuthorDateOfDeath($author, $newDate->id);
            }

            if(!StringUtils::isEmpty($baseAuthorRequest->getImageUrl())){
                $author->image = $this->imageService->saveAuthorImageFromUrl($baseAuthorRequest->getImageUrl(), $author);
            }

            $this->authorRepository->save($author);
            return $author;
        });
    }

    public function syncAuthors($preferredAuthor, $secondaryAuthors, $book)
    {
        $authors = array($preferredAuthor->id => array('preferred' => true));
        foreach ($secondaryAuthors as $secAuthor) {
            $authors[$secAuthor->id] = array('preferred' => false);
        }
        $book->authors()->sync($authors);
    }

    public function getAllAuthors()
    {
        return $this->authorRepository->all();
    }
}