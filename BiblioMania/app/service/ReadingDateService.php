<?php

class ReadingDateService {

    public function saveOrFind($date){ 
    	$readingDate = ReadingDate::where('date', '=', $date)
	            ->first();

        if (is_null($readingDate)) {
        	$readingDate = new ReadingDate();	
	        $readingDate->date = $date;
	        $readingDate->save();
        }
        return $readingDate;
    }

}