<?php

class DateImporter
{
    /** @var DateService */
    private $dateService;

    function __construct()
    {
        $this->dateService = App::make('DateService');
    }


    public function importDate($dateValues)
    {
        if (!empty($dateValues) && $dateValues != "3000") {
            $dateValues = trim($dateValues);
            $dateValues = StringUtils::replace($dateValues, "/", "-");
            $dateValues = StringUtils::replace($dateValues, " ", "-");
            $dateValues = explode("-", $dateValues);
            $day = null;
            $month = null;
            $year = null;
            if (count($dateValues) == 1) {
                $year = DateImporter::getYearFromDateValue($dateValues[0]);
            } else if (count($dateValues) == 2) {
                $month = DateImporter::getMonthFromDateValue($dateValues[0]);
                $year = DateImporter::getYearFromDateValue($dateValues[1]);
            } else {
                $day = $dateValues[0];
                $month = DateImporter::getMonthFromDateValue($dateValues[1]);
                $year = DateImporter::getYearFromDateValue($dateValues[2]);
            }
            $date = new Date(array('day' => $day, 'month' => $month, 'year' => $year));
            return $date;
        }
        return null;
    }

    public function importDateToDateTime($dateValues)
    {
        if (!empty($dateValues) && $dateValues != "3000") {
            $dateValues = trim($dateValues);
            $dateValues = StringUtils::replace($dateValues, "/", "-");
            $dateValues = StringUtils::replace($dateValues, " ", "-");
            $dateArray = explode("-", $dateValues);;
            if(StringUtils::contains($dateValues, '-')){
                $dateArray = explode("-", $dateValues);
            }
            else if(StringUtils::contains($dateValues, ' ')){
                $dateArray = explode(' ', $dateValues);
            }

            $day = 1;
            $month = 1;
            $year = null;
            if (count($dateArray) == 1) {
                $year = DateImporter::getYearFromDateValue($dateArray[0]);
            } else if (count($dateArray) == 2) {
                $month = DateImporter::getMonthFromDateValue($dateArray[0]);
                $year = DateImporter::getYearFromDateValue($dateArray[1]);
            } else {
                $day = $dateArray[0];
                $month = DateImporter::getMonthFromDateValue($dateArray[1]);
                $year = DateImporter::getYearFromDateValue($dateArray[2]);
            }
            $dateString = $day . '-' . $month . '-' . $year;
            return DateTime::createFromFormat("d-m-Y", $dateString);
        }
        return null;
    }


    private static function getYearFromDateValue($value)
    {
        if (strlen($value) == 4) {
            return $value;
        } else if ($value > 14) {
            return "19" . $value;
        } else {
            return "20" . $value;
        }
    }

    private static function getMonthFromDateValue($value)
    {
        if (StringUtils::contains($value, "Jan")) {
            return "1";
        }
        if (StringUtils::contains($value, "Feb")) {
            return "2";
        }
        if (StringUtils::contains($value, "Mar")) {
            return "3";
        }
        if (StringUtils::contains($value, "Apr")) {
            return "4";
        }
        if (StringUtils::contains($value, "Mai")) {
            return "5";
        }
        if (StringUtils::contains($value, "Jun")) {
            return "6";
        }
        if (StringUtils::contains($value, "Jul") ) {
            return "7";
        }
        if (StringUtils::contains($value, "Aug")) {
            return "8";
        }
        if (StringUtils::contains($value, "Sep")) {
            return "9";
        }
        if (StringUtils::contains($value, "Oct") || StringUtils::contains($value, "okt")) {
            return "10";
        }
        if (StringUtils::contains($value, "Nov")) {
            return "11";
        }
        if (StringUtils::contains($value, "Dec")) {
            return "12";
        }
        return $value;
    }


}