<?php

class StatisticsService
{

    /** @var  BookService */
    private $bookService;
    /** @var  StatisticsRepository */
    private $statisticsRepository;

    function __construct()
    {
        $this->statisticsRepository = App::make('StatisticsRepository');
        $this->bookService = App::make('BookService');
    }

    public function getAmountBooksReadInMonth($month, $year)
    {
        return $this->statisticsRepository->getAmountBooksReadInMonth($month, $year);
    }

    public function getAmountBooksRetrievedInMonth($month, $year)
    {
        return $this->statisticsRepository->getAmountBooksRetrievedInMonth($month, $year);
    }

    public function getBooksPerGenre()
    {
        $genres = Genre::all();
        $result = array();
        foreach ($genres as $genre) {
            $result[$genre->name] = Book::where('genre_id', '=', $genre->id)
                ->where('wizard_step', '=', 'COMPLETE')
                ->count();
        }
        return $result;
    }

    public function getBooksAddedPerYear()
    {
        $result = array();

        $books = $this->bookService->getCompletedBooksWithPersonalBookInfo();

        /** @var Book $book */
        foreach ($books as $book) {
            $year = 'unknown';
            if ($book->personal_book_info->buy_info != null) {
                $buyDate = $book->personal_book_info->buy_info->buy_date;
                if ($buyDate != null) {
                    $year = DateFormatter::getYearFromSqlDate($buyDate);
                }
            } else if ($book->personal_book_info->gift_info != null) {
                $receiptDate = $book->personal_book_info->gift_info->receipt_date;
                if ($receiptDate != null) {
                    $year = DateFormatter::getYearFromSqlDate($receiptDate);
                }
            }
            if(!isset($result[$year])){
                $result[$year] = 0;
            }
            $result[$year] = $result[$year] + 1;
        }
        return $result;
    }
}