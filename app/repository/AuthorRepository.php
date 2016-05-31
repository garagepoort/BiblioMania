<?php

use Bendani\PhpCommon\Utils\Ensure;

class AuthorRepository implements Repository{

    public function find($id, $with = array())
    {
        return Author::with($with)->find($id);
    }

    public function all()
    {
        return Author::all();
    }

    public function save($entity)
    {
        $entity->save();
    }

    public function delete($entity)
    {
        $entity->delete();
    }

    public function deleteById($id)
    {
        return Author::find($id)->delete();
    }

    public function getAuthorByFullName($name, $firstName, $infix){
        return Author::where('name', '=', $name)
            ->where('firstname', '=', $firstName)
            ->where('infix', '=', $infix)
            ->first();
    }

    public function updateAuthorDateOfDeath(Author $author, $date_id){
        Ensure::objectNotNull('Author', $author);

        $date_of_death = $author->date_of_death();
        if($date_of_death != null){
            $date_of_death->dissociate();
            $author->save();
            $date_of_death->delete();
        }

        $author->date_of_death_id = $date_id;
        $author->save();
    }

    public function updateAuthorDateOfBirth(Author $author, $date_id){
        Ensure::objectNotNull('Author', $author);

        $date_of_birth = $author->date_of_birth();
        if($date_of_birth != null){
            $date_of_birth->dissociate();
            $author->save();
            $date_of_birth->delete();
        }

        $author->date_of_birth_id = $date_id;
        $author->save();
    }

    public function findByBook($book, $authorId){
        return $book->authors->find($authorId);
    }
}