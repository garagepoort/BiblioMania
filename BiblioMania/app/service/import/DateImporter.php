<?php

class DateImporter {

	public static function getPublicationDate($dateValues){
		 if (!empty($dateValues)) {
        	$dateValues = explode("-", $dateValues);
        	$day =null;
        	$month = null;
        	$year = null;
        	if(count($dateValues) == 1){
        		$year = DateImporter::getYearFromDateValue($dateValues[0]);
        	}else if (count($dateValues) == 2) {
        		$month= DateImporter::getMonthFromDateValue($dateValues[0]);
        		$year= DateImporter::getYearFromDateValue($dateValues[1]);
        	}else{
        		$day= $dateValues[0];
        		$month= DateImporter::getMonthFromDateValue($dateValues[1]);
        		$year= DateImporter::getYearFromDateValue($dateValues[2]);
        	}
        	$date = App::make('DateService')->createDate($day, $month, $year);
        	return $date;
        }
        return null;
	}


	private static function getYearFromDateValue($value){
		if(strlen($value) == 4){
			return $value;
		}else if($value > 14){
			return "19".$value;
		}else{
			return "20".$value;
		}
	}

	private static function getMonthFromDateValue($value){
		if(strcasecmp($value, "Sep")){
			return "9";
		}
		if(strcasecmp($value, "Apr")){
			return "4";
		}
		return $value;
	}


}