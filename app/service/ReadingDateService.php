<?php

class ReadingDateService
{

    public function create(DateRequest $date)
    {
        $dateString = $date->getDay() . "-" . + $date->getMonth() . "-" . $date->getYear();
        $datetime = DateTime::createFromFormat('d-m-Y', $dateString);

        $readingDate = ReadingDate::where('date', '=', $datetime)
            ->first();

        if (is_null($readingDate)) {
            $readingDate = new ReadingDate();
            $readingDate->date = $datetime;
            $readingDate->save();
        }
        return $readingDate;
    }

    public function find($id){
        return ReadingDate::where('id', '=', $id)->first();
    }

    public function saveOrFind(DateTime $date)
    {
        $readingDate = ReadingDate::where('date', '=', $date)
            ->first();

        if (is_null($readingDate)) {
            $readingDate = new ReadingDate();
            $readingDate->date = $date;
            $readingDate->save();
        }
        return $readingDate;
    }

    public function save(ReadingDate $date){
        $date->save();
    }

}