<?php

class StatisticsController extends BaseController
{

    /** @var  StatisticsService */
    private $statisticsService;
    /** @var  BookService */
    private $bookService;

    function __construct()
    {
        $this->statisticsService = App::make('StatisticsService');
        $this->bookService = App::make('BookService');
    }


    public function goToStatistics()
    {
        $years = array(
            "2008" => 2008,
            "2009" => 2009,
            "2010" => 2010,
            "2011" => 2011,
            "2012" => 2012,
            "2013" => 2013,
            "2014" => 2014,
            "2015" => 2015,
            "2016" => 2016
        );
        return View::make('statistics/statistics')->with(array(
            'title' => 'Statistieken',
            'years' => $years
        ));
    }

    public function getBooksReadPerMonth($year)
    {
        $data = array(
            "cols" => array(
                array("id" => "", "label" => "Maand", "pattern" => "", "type" => "string"),
                array("id" => "", "label" => "Boeken gelezen", "pattern" => "", "type" => "number")
            ),
            "rows" => array(
                $this->createRowValue("januari", $this->statisticsService->getAmountBooksReadInMonth(1, $year)),
                $this->createRowValue("februari", $this->statisticsService->getAmountBooksReadInMonth(2, $year)),
                $this->createRowValue("maart", $this->statisticsService->getAmountBooksReadInMonth(3, $year)),
                $this->createRowValue("april", $this->statisticsService->getAmountBooksReadInMonth(4, $year)),
                $this->createRowValue("mei", $this->statisticsService->getAmountBooksReadInMonth(5, $year)),
                $this->createRowValue("juni", $this->statisticsService->getAmountBooksReadInMonth(6, $year)),
                $this->createRowValue("juli", $this->statisticsService->getAmountBooksReadInMonth(7, $year)),
                $this->createRowValue("augustus", $this->statisticsService->getAmountBooksReadInMonth(8, $year)),
                $this->createRowValue("september", $this->statisticsService->getAmountBooksReadInMonth(9, $year)),
                $this->createRowValue("oktober", $this->statisticsService->getAmountBooksReadInMonth(10, $year)),
                $this->createRowValue("november", $this->statisticsService->getAmountBooksReadInMonth(11, $year)),
                $this->createRowValue("december", $this->statisticsService->getAmountBooksReadInMonth(12, $year)),
            )
        );
        return json_encode($data);
    }

    private function createRowValue($title, $value)
    {
        return array("c" => array(
            array("v" => $title),
            array("v" => $value))
        );
    }

    private function createPublicationDateReadingDateRowValue($readDate, $publicationDate, $info)
    {
        return array("c" => array(
            array("v" => $readDate),
            array("v" => $publicationDate),
            array("v" => $info)
        ));
    }

    public function getBooksRetrievedPerMonth($year)
    {
        $data = array(
            "cols" => array(
                array("id" => "", "label" => "Maand", "pattern" => "", "type" => "string"),
                array("id" => "", "label" => "Boeken verkregen", "pattern" => "", "type" => "number")
            ),
            "rows" => array(
                $this->createRowValue("januari", $this->statisticsService->getAmountBooksRetrievedInMonth(1, $year)),
                $this->createRowValue("februari", $this->statisticsService->getAmountBooksRetrievedInMonth(2, $year)),
                $this->createRowValue("maart", $this->statisticsService->getAmountBooksRetrievedInMonth(3, $year)),
                $this->createRowValue("april", $this->statisticsService->getAmountBooksRetrievedInMonth(4, $year)),
                $this->createRowValue("mei", $this->statisticsService->getAmountBooksRetrievedInMonth(5, $year)),
                $this->createRowValue("juni", $this->statisticsService->getAmountBooksRetrievedInMonth(6, $year)),
                $this->createRowValue("juli", $this->statisticsService->getAmountBooksRetrievedInMonth(7, $year)),
                $this->createRowValue("augustus", $this->statisticsService->getAmountBooksRetrievedInMonth(8, $year)),
                $this->createRowValue("september", $this->statisticsService->getAmountBooksRetrievedInMonth(9, $year)),
                $this->createRowValue("oktober", $this->statisticsService->getAmountBooksRetrievedInMonth(10, $year)),
                $this->createRowValue("november", $this->statisticsService->getAmountBooksRetrievedInMonth(11, $year)),
                $this->createRowValue("december", $this->statisticsService->getAmountBooksRetrievedInMonth(12, $year)),
            )
        );
        return json_encode($data);
    }

    public function getBooksAndPublicationDate(){
//        pubYearTable.addColumn('date', 'read in');
//        pubYearTable.addColumn('date', 'published in');
//        pubYearTable.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});
        $rows = array();
        /** @var Book $book */
        foreach($this->bookService->getBooksWithPersonalBookInfo() as $book){
            if($book->first_print_info->publication_date != null){
                $publicationYear = StringUtils::isEmpty($book->first_print_info->publication_date->year) ? "1900" : $book->first_print_info->publication_date->year;
                $publicationMonth = StringUtils::isEmpty($book->first_print_info->publication_date->month) ? "1" : $book->first_print_info->publication_date->month;
                $publicationDay = StringUtils::isEmpty($book->first_print_info->publication_date->day) ? "1" : $book->first_print_info->publication_date->day;
                $publicationDate = "Date($publicationYear , $publicationMonth , $publicationDay)";
            }else{
                $publicationDate = "Date(1,1,1900)";
            }

            foreach($book->personal_book_info->reading_dates as $readingDate){
                $dateTime = DateTime::createFromFormat("Y-m-d", $readingDate->date);
                $timestamp = $dateTime->getTimestamp();
                $readYear = StringUtils::isEmpty(date('Y', $timestamp)) ? "1900" : date('Y', $timestamp);
                $readMonth = StringUtils::isEmpty(date('m', $timestamp)) ? "1" : date('m', $timestamp);
                $readDay = StringUtils::isEmpty(date('d', $timestamp)) ? "1" : date('d', $timestamp);
                $readDate = "Date($readYear ,$readMonth, $readDay)";
                array_push($rows, $this->createPublicationDateReadingDateRowValue($readDate, $publicationDate, $this->createHtmlToolTip($book->title, $publicationYear, $dateTime)));
            }

        }

        $data = array(
            "cols" => array(
                array("id" => "", "label" => "read in", "type" => "date"),
                array("id" => "", "label" => "published in", "type" => "date"),
                array("id" => "", "role" => "tooltip", "type" => "string", "p" => array("role" => "tooltip", "html"=>"true"))
            ),
            "rows" => $rows
        );
        return json_encode($data);
    }

    private function createHtmlToolTip($title, $publicationYear, $readingDate){
        $dateString = $readingDate->format('d/m/Y');
        return "<div><h5>$title</h5><p>Leesdatum: $dateString</p><p>Publicatie jaar: $publicationYear</p></div>";
    }
}