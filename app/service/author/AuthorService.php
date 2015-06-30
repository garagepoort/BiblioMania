<?php

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

    public function saveOrGetSecondaryAuthor(AuthorInfoParameters $authorInfoParameters){
        $author_model = $this->authorRepository->getAuthorByFullName($authorInfoParameters->getName(),
            $authorInfoParameters->getFirstname(),
            $authorInfoParameters->getInfix());
        if (is_null($author_model)) {
            $author_model = new Author();
            $author_model->name = $authorInfoParameters->getName();
            $author_model->firstname = $authorInfoParameters->getFirstname();
        }
        $this->authorRepository->save($author_model);
        return $author_model;
    }

    /**
     * @param AuthorInfoParameters $authorInfoParameters
     * @return Author
     */
    public function createOrUpdate(AuthorInfoParameters $authorInfoParameters)
    {
        $author_model = $this->authorRepository->getAuthorByFullName($authorInfoParameters->getName(),
            $authorInfoParameters->getFirstname(),
            $authorInfoParameters->getInfix());

        if (is_null($author_model)) {
            $author_model = new Author();
            $author_model->name = $authorInfoParameters->getName();
            $author_model->firstname = $authorInfoParameters->getFirstname();
            $author_model->infix = $authorInfoParameters->getInfix();
            $authorInfoParameters->getDateOfBirth()->save();
            $authorInfoParameters->getDateOfDeath()->save();
            $author_model->date_of_birth_id = $authorInfoParameters->getDateOfBirth()->id;
            $author_model->date_of_death_id = $authorInfoParameters->getDateOfDeath()->id;
        }else{
            $this->dateService->copyDateValues($author_model->date_of_birth, $authorInfoParameters->getDateOfBirth());
            $this->dateService->copyDateValues($author_model->date_of_death, $authorInfoParameters->getDateOfDeath());
        }

        $this->saveImage($authorInfoParameters, $author_model);

        $this->authorRepository->save($author_model);
        return $author_model;
    }

    public function updateAuthor($author_id, $name, $infix, $firstName, $authorImage, $date_of_birth_id, $date_of_death_id){
        $author = $this->authorRepository->find($author_id);
        $author->name = $name;
        $author->infix = $infix;
        $author->firstname = $firstName;
        $author->date_of_birth_id = $date_of_birth_id;
        $author->date_of_death_id = $date_of_death_id;
        $this->saveImage($authorImage, $author);
        $this->authorRepository->save($author);
    }

    public function deleteDateOfBirth($author)
    {
        if ($author->date_of_birth != null) {
            $date_of_birth = $author->date_of_birth;
            $author->date_of_birth_id = null;
            $author->save();
            $date_of_birth->delete();
        }
    }

    public function deleteDateOfDeath($author)
    {
        if ($author->date_of_death != null) {
            $date_of_death = $author->date_of_death;
            $author->date_of_death_id = null;
            $author->save();
            $date_of_death->delete();
        }
    }

    public function getFilteredAuthors($query, $operator, $type, $orderBy)
    {
        $with = array('date_of_birth', 'date_of_death');

        $authors = Author::with($with);

        $operatorString = "=";
        $queryString = $query;
        if (!StringUtils::isEmpty($queryString)) {
            if ($operator == FilterOperator::BEGINS_WITH || $operator == FilterOperator::CONTAINS || $operator == FilterOperator::ENDS_WITH) {
                $operatorString = "LIKE";
                if ($operator == FilterOperator::BEGINS_WITH) {
                    $queryString = $queryString . '%';
                }
                if ($operator == FilterOperator::ENDS_WITH) {
                    $queryString = '%' . $queryString;
                }
                if ($operator == FilterOperator::CONTAINS) {
                    $queryString = '%' . $queryString . '%';
                }
            }

            if ($type != AuthorFilterType::ALL) {
                $authors = $authors->where($type, $operatorString, $queryString);
            } else {
                $authors = $authors->where(function ($query) use ($operatorString, $queryString) {
                    $query->where(AuthorFilterType::AUTHOR_NAME, $operatorString, $queryString)
                        ->orWhere(AuthorFilterType::AUTHOR_FIRSTNAME, $operatorString, $queryString);
                });
            }
        }

        if ($orderBy == 'name') {
            $authors = $authors->orderBy('name');
        }
        if ($orderBy == 'firstname') {
            $authors = $authors->orderBy('firstname');
        }

        return $authors->paginate(60);
    }


    public function saveImage(AuthorInfoParameters $authorInfoParameters, $author_model)
    {
        if($authorInfoParameters->getImage() != null){
            if($author_model->image != 'images/questionCover.png'){
                $this->imageService->removeImage($author_model->image);
            }

            if($authorInfoParameters->getImageSaveType() == ImageSaveType::UPLOAD){
                $author_model->image = $this->imageService->saveUploadImageForAuthor($authorInfoParameters->getImage(),$author_model->name);
            }
            else if($authorInfoParameters->getImageSaveType() == ImageSaveType::URL)
            {
                $author_model->image = $this->imageService->saveAuthorImageFromUrl($authorInfoParameters->getImage(), $author_model->name);
            }
            else if($authorInfoParameters->getImageSaveType() == ImageSaveType::PATH)
            {
                $author_model->image = $authorInfoParameters->getImage();
            }
            $author_model->useSpriteImage = false;
        }
    }

    public function authorToString(Author $author){
        $firstname = $author->firstname;
        $infix = $author->infix;
        $name = $author->name;
        if(!StringUtils::isEmpty($name) && !StringUtils::isEmpty($infix) && !StringUtils::isEmpty($firstname)){
            return $name . ", " . $infix . ", " . $firstname;
        }else if (!StringUtils::isEmpty($name) && !StringUtils::isEmpty($firstname)){
            return $name . ", " . $firstname;
        }
        return $name;
    }
}