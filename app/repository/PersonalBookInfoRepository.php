<?php

class PersonalBookInfoRepository implements Repository{

    public function find($id, $with = array())
    {
        return PersonalBookInfo::with($with)->where('id', '=', $id)->first();
    }

    public function findByBook($book_id){
        return PersonalBookInfo::where('book_id', '=', $book_id)
            ->where('user_id', '=', Auth::user()->id)
            ->first();
    }

    public function all()
    {
        PersonalBookInfo::all();
    }

    public function save($entity)
    {
       $entity->save();
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function deleteById($id)
    {
        // TODO: Implement deleteById() method.
    }
}