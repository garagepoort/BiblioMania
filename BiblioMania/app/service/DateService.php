<?php

class DateService {
	
	public function createDate($day, $month, $year) {
		$date = new Date(array('day' => $day, 'month' => $month, 'year' => $year));
		$date->save();
		return $date;
	}

	public function createDateFromDateTime($dateTime) {
		$date = new Date(array(
			'day' => $dateTime->format('d'), 
			'month' => $dateTime->format('m'), 
			'year' => $dateTime->format('Y')
		));
		$date->save();
		return $date;
	}
	
}