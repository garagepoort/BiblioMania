<?php

class ReadingDateRepository implements Repository
{

    public function find($id, $with = array())
    {
        return ReadingDate::with($with)
            ->select('reading_date.*')
            ->join('personal_book_info', 'personal_book_info_id', '=', 'personal_book_info.id')
            ->where('reading_date.id', '=', $id)
            ->first();
    }

    public function findByUserAndId($userId, $id, $with = array())
    {
        return ReadingDate::with($with)
            ->select('reading_date.*')
            ->join('personal_book_info', 'personal_book_info_id', '=', 'personal_book_info.id')
            ->where('user_id', '=', $userId)
            ->where('reading_date.id', '=', $id)
            ->first();
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function save($entity)
    {
        // TODO: Implement save() method.
    }

    public function delete($entity)
    {
        // TODO: Implement delete() method.
    }

    public function deleteById($id)
    {
        return ReadingDate::find($id)->delete();
    }
}