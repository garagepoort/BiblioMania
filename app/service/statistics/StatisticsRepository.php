<?php

class StatisticsRepository {

    public function getAmountBooksReadInMonth($month, $year)
    {
        $userId = Auth::user()->id;
        return count(DB::select("select reading_date.date from book inner join personal_book_info on personal_book_info.book_id = book.id
                    where month(reading_date.date) = $month AND YEAR(reading_date.date) = $year and user_id = $userId"));
    }

    public function getAmountBooksRetrievedInMonth($month, $year)
    {
        $userId = Auth::user()->id;
        return count(DB::select("select book.id, buy_date as someDate from personal_book_info
                                    inner join buy_info on buy_info.personal_book_info_id = personal_book_info.id
                                    inner join book on personal_book_info.book_id = book.id
                                    where buy_date is not null
                                    and month(buy_date) = $month
                                    AND YEAR(buy_date) = $year and user_id = $userId
                                UNION
                                select book.id, receipt_date as someDate from personal_book_info
                                    inner join gift_info on gift_info.personal_book_info_id = personal_book_info.id
                                    inner join book on personal_book_info.book_id = book.id
                                    where receipt_date is not null
                                    and month(receipt_date) = $month
                                    AND YEAR(receipt_date) = $year and user_id = $userId"
        ));
    }
}