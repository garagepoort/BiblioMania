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
        $this->imageService = App::make('ImageService');
        $this->dateService = App::make('DateService');
        $this->authorRepository = App::make('AuthorRepository');
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

    public function saveOrUpdate($name, $infix, $firstName, $authorImage, $date_of_birth_id, $date_of_death_id)
    {
        $author_model = $this->authorRepository->getAuthorByFullName($name, $firstName, $infix);

        if (is_null($author_model)) {
            $author_model = new Author();
            $author_model->name = $name;
            $author_model->firstname = $firstName;
            $author_model->infix = $infix;
        }

        $author_model->date_of_birth_id = $date_of_birth_id;
        $author_model->date_of_death_id = $date_of_death_id;
        $author_model->image = $authorImage;

        $this->authorRepository->save($author_model);
        return $author_model;
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

    public function getFilteredAuthors($name, $firstname, $orderBy)
    {
        $with = array('date_of_birth', 'date_of_death');

        $authors = Author::with($with);

        if ($name != null) {
            $authors = $authors->where('name', 'LIKE', '%' . $name . '%');
        }
        if ($firstname != null) {
            $authors = $authors->where('firstname', 'LIKE', '%' . $firstname . '%');
        }
        if ($orderBy == 'name') {
            $authors = $authors->orderBy('name');
        }
        if ($orderBy == 'firstname') {
            $authors = $authors->orderBy('firstname');
        }

        return $authors->paginate(60);
    }

    /**
     * @param AuthorInfoParameters $authorInfoParameters
     * @param $author_model
     */
    public function saveImage(AuthorInfoParameters $authorInfoParameters, $author_model)
    {
        if ($authorInfoParameters->getImage() != null) {
            if ($authorInfoParameters->getShouldCreateImage()) {
                $author_model->image = $this->imageService->saveImage($authorInfoParameters->getImage(), $authorInfoParameters->getName());
            } else {
                $author_model->image = $authorInfoParameters->getImage();
            }
        } else if (StringUtils::isEmpty($author_model->image)) {
            $author_model->image = 'images/questionCover.png';
        }
    }
}