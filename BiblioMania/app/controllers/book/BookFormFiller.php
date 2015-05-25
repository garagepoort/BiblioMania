<?php

class BookFormFiller
{

    public static function createArrayForCreate()
    {
        $result = array();
        $result['book_id'] = '';
        $result['book_title'] = 'Nieuw boek';
        $result['book_subtitle'] = '';
        $result['book_isbn'] = '';
        $result['book_number_of_pages'] = '';
        $result['book_cover_image'] = '';
        $result['book_print'] = '';
        $result['book_print'] = '';
        $result['translator'] = '';
        $result['author_name_book_info'] = '';
        $result['author_name'] = '';
        $result['author_infix'] = '';
        $result['author_firstname'] = '';
        $result['author_image'] = '';
        $result['book_publisher'] = '';
        $result['book_country'] = '';
        $result['book_serie'] = '';
        $result['book_publisher_serie'] = '';
        $result['book_languageId'] = '';
        $result['book_genre_input'] = '';
        $result['book_publication_date_day'] = '';
        $result['book_publication_date_month'] = '';
        $result['book_publication_date_year'] = '';
        $result['author_date_of_birth_day'] = '';
        $result['author_date_of_birth_month'] = '';
        $result['author_date_of_birth_year'] = '';
        $result['author_date_of_death_day'] = '';
        $result['author_date_of_death_month'] = '';
        $result['author_date_of_death_year'] = '';
        $result['first_print_title'] = '';
        $result['first_print_subtitle'] = '';
        $result['first_print_isbn'] = '';
        $result['first_print_country'] = '';
        $result['first_print_publisher'] = '';
        $result['first_print_publication_date_day'] = '';
        $result['first_print_publication_date_month'] = '';
        $result['first_print_publication_date_year'] = '';
        $result['personal_info_owned'] = 'true';
        $result['personal_info_reading_date_input'] = '';
        $result['personal_info_rating'] = '';
        $result['gift_info_receipt_date'] = '';
        $result['gift_book_info_retail_price'] = '';
        $result['gift_info_from'] = '';
        $result['gift_info_occasion'] = '';
        $result['buy_info_buy_date'] = '';
        $result['buy_info_price_payed'] = '';
        $result['buy_book_info_retail_price'] = '';
        $result['buy_info_recommended_by'] = '';
        $result['buy_info_shop'] = '';
        $result['buy_info_city'] = '';
        $result['buy_info_country'] = '';
        $result['book_type_of_cover'] = '';
        $result['giftInfoSet'] = false;
        $result['buyInfoSet'] = true;
        $result['book_from_author_title'] = '';
        return $result;
    }

    public static function createEditBookArray($bookId)
    {
        $book = Book::with(array('personal_book_info', 'book_from_author', 'publisher_serie'))->find($bookId);
        $author = Author::with(array('date_of_birth', 'date_of_death'))->find($book->authors->first()->id);

        $result = BookFormFiller::createArrayForCreate();
        $result['book_id'] = $bookId;
        $result['book_title'] = $book->title;
        $result['book_subtitle'] = $book->subtitle;
        $result['book_isbn'] = $book->ISBN;
        $result['book_number_of_pages'] = $book->number_of_pages;
        $result['book_print'] = $book->print;
        $result['book_cover_image'] = $book->coverImage;
        $result['book_type_of_cover'] = $book->type_of_cover;
        $result['translator'] = $book->translator;

        $result['first_print_title'] = $book->first_print_info->title;
        $result['first_print_subtitle'] = $book->first_print_info->subtitle;
        $result['first_print_isbn'] = $book->first_print_info->ISBN;

        if ($book->first_print_info->country != null) {
            $result['first_print_country'] = $book->first_print_info->country->name;
        }

        if ($book->first_print_info->publisher != null) {
            $result['first_print_publisher'] = $book->first_print_info->publisher->name;
        }

        if ($book->first_print_info->publication_date != null) {
            $result['first_print_publication_date_day'] = $book->first_print_info->publication_date->day;
            $result['first_print_publication_date_month'] = $book->first_print_info->publication_date->month;
            $result['first_print_publication_date_year'] = $book->first_print_info->publication_date->year;
        }

        if ($book->personal_book_info != null) {
            $result['personal_info_owned'] = $book->personal_book_info->get_owned();
            $resultDates = '';
            if (count($book->personal_book_info->reading_dates) > 0) {
                foreach ($book->personal_book_info->reading_dates as $reading_date) {
                    $time = strtotime($reading_date->date);
                    $myFormatForView = date("d/m/Y", $time);
                    $resultDates = $resultDates . $myFormatForView . ',';
                }
            }
            $resultDates = rtrim($resultDates, ",");
            $result['personal_info_reading_date_input'] = $resultDates;
            $result['personal_info_rating'] = $book->personal_book_info->rating;
        }

        $result['author_name'] = $book->authors[0]->name;
        $result['author_infix'] = $book->authors[0]->infix;
        $result['author_firstname'] = $book->authors[0]->firstname;
        $result['author_image'] = $book->authors[0]->image;

        if (empty($book->authors[0]->infix)) {
            $result['author_name_book_info'] = $book->authors[0]->name . ', ' . $book->authors[0]->firstname;
        } else {
            $result['author_name_book_info'] = $book->authors[0]->name . ', ' . $book->authors[0]->infix . ', ' . $book->authors[0]->firstname;
        }

        if ($book->publisher != null) {
            $result['book_publisher'] = $book->publisher->name;
        }

        if ($book->country != null) {
            $result['book_country'] = $book->country->name;
        }

        if ($book->serie != null) {
            $result['book_serie'] = $book->serie->name;
        }

        if ($book->publisher_serie != null) {
            $result['book_publisher_serie'] = $book->publisher_serie->name;
        }

        if ($book->language != null) {
            $result['book_languageId'] = $book->language->id;
        } else {
            $result['book_languageId'] = '';
        }

        if ($book->genre != null) {
            $result['book_genre_input'] = $book->genre->id;
        }

        if ($book->publication_date != null) {
            if ($book->publication_date->day != 0) {
                $result['book_publication_date_day'] = $book->publication_date->day;
            }
            if ($book->publication_date->month != 0) {
                $result['book_publication_date_month'] = $book->publication_date->month;
            }
            if ($book->publication_date->year != 0) {
                $result['book_publication_date_year'] = $book->publication_date->year;
            }
        }

        if ($author->date_of_birth != null) {
            $result['author_date_of_birth_day'] = $author->date_of_birth->day;
            $result['author_date_of_birth_month'] = $author->date_of_birth->month;
            $result['author_date_of_birth_year'] = $author->date_of_birth->year;
        }

        if ($author->date_of_death != null) {
            $result['author_date_of_death_day'] = $author->date_of_death->day;
            $result['author_date_of_death_month'] = $author->date_of_death->month;
            $result['author_date_of_death_year'] = $author->date_of_death->year;
        }

        if ($book->personal_book_info->buy_info != null) {
            $time = strtotime($book->personal_book_info->buy_info->buy_date);
            $myFormatForView = date("d/m/Y", $time);
            $result['buy_info_buy_date'] = $myFormatForView;
            $result['buy_info_price_payed'] = $book->personal_book_info->buy_info->price_payed;
            $result['buy_book_info_retail_price'] = $book->retail_price;
            $result['buy_info_recommended_by'] = $book->personal_book_info->buy_info->recommended_by;
            $result['buy_info_shop'] = $book->personal_book_info->buy_info->shop;
            if ($book->personal_book_info->buy_info->city != null) {
                $result['buy_info_city'] = $book->personal_book_info->buy_info->city->name;
            }
            if ($book->personal_book_info->buy_info->country != null) {
                $result['buy_info_country'] = $book->personal_book_info->buy_info->country->name;
            }
            $result['buyInfoSet'] = true;
            $result['giftInfoSet'] = false;
        }

        if ($book->personal_book_info->gift_info != null) {
            $time = strtotime($book->personal_book_info->gift_info->receipt_date);
            $myFormatForView = date("d/m/Y", $time);
            $result['gift_info_receipt_date'] = $myFormatForView;
            $result['gift_book_info_retail_price'] = $book->retail_price;
            $result['gift_info_from'] = $book->personal_book_info->gift_info->from;
            $result['gift_info_occasion'] = $book->personal_book_info->gift_info->occasion;
            $result['giftInfoSet'] = true;
            $result['buyInfoSet'] = false;
        }

        if ($book->book_from_author != null) {
            $result['book_from_author_title'] = $book->book_from_author->title;
        }

        return $result;
    }
}