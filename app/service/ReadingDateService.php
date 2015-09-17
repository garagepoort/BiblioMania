<?php

class ReadingDateService
{

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