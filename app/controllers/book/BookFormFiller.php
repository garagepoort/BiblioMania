<?php

class BookFormFiller
{

    public static function fillBasicInfo($bookId)
    {
        $book = App::make('BookService')->find($bookId);
        $book->load('tags');

        $result['book_id'] = $bookId;
        $result['book_title'] = $book->title;
        $result['book_subtitle'] = $book->subtitle;
        $result['book_isbn'] = $book->ISBN;
        $result['book_wizard_step'] = $book->wizard_step;

        $output = array_map(function ($object) {
            return $object['name'];
        }, $book->tags->toArray());
        $result['book_tags'] = implode(BookInfoParameterMapper::TAG_DELIMITER, $output);

        $result['book_genre_input'] = "";
        if ($book->genre != null) {
            $result['book_genre_input'] = $book->genre->id;
        }
        $result['book_publisher'] = "";
        if ($book->publisher != null) {
            $result['book_publisher'] = $book->publisher->name;
        }
        $result['book_country'] = "";
        if ($book->country != null) {
            $result['book_country'] = $book->country->name;
        }

        $result['book_language'] = '';
        if ($book->language != null) {
            $result['book_language'] = $book->language->language;
        }


        $result['book_publication_date_day'] = "";
        $result['book_publication_date_month'] = "";
        $result['book_publication_date_year'] = "";
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

        return $result;
    }

    public static function fillForBookExtras($bookId)
    {
        $book = Book::with(array('personal_book_info', 'book_from_author', 'publisher_serie', 'tags'))->find($bookId);
        $result['book_id'] = $bookId;
        $result['book_number_of_pages'] = $book->number_of_pages;
        $result['book_title'] = $book->title;
        $result['book_print'] = $book->print;
        $result['book_old_tags'] = $book->old_tags;
        $result['translator'] = $book->translator;
        $result['book_summary'] = $book->summary;
        $result['book_state'] = $book->state;
        $result['book_wizard_step'] = $book->wizard_step;
        $result['book_serie'] = "";
        $result['book_publisher_serie'] = "";
        $result['book_info_retail_price'] = StringUtils::replace($book->retail_price, ".", ",");
        $result['book_info_retail_price_currency'] = $book->currency;
        if ($book->serie != null) {
            $result['book_serie'] = $book->serie->name;
        }

        if ($book->publisher_serie != null) {
            $result['book_publisher_serie'] = $book->publisher_serie->name;
        }

        return $result;
    }

    public static function fillForAuthor($id)
    {
        $book = Book::with(array('personal_book_info', 'book_from_author', 'publisher_serie', 'tags'))->find($id);
        $result = BookFormFiller::createArrayForCreate();
        $result['book_id'] = $id;
        $result['book_wizard_step'] = $book->wizard_step;
        $result['book_title'] = $book->title;
        $preferredAuthor = $book->preferredAuthor();

        if ($preferredAuthor != null) {
            $result['author_name'] = $preferredAuthor->name;
            $result['author_infix'] = $preferredAuthor->infix;
            $result['author_firstname'] = $preferredAuthor->firstname;
            if (StringUtils::isEmpty($preferredAuthor->image)) {
                $result['author_image'] = Config::get("properties.questionImage");
            } else {
                $result['author_image'] = Config::get("properties.authorImagesLocation") . "/" . $preferredAuthor->image;
            }

            if (empty($preferredAuthor->infix)) {
                $result['author_name_book_info'] = $preferredAuthor->name . ', ' . $preferredAuthor->firstname;
            } else {
                $result['author_name_book_info'] = $preferredAuthor->name . ', ' . $preferredAuthor->infix . ', ' . $preferredAuthor->firstname;
            }

            if ($preferredAuthor->date_of_birth != null) {
                $result['author_date_of_birth_day'] = $preferredAuthor->date_of_birth->day == 0 ? "" : $preferredAuthor->date_of_birth->day;
                $result['author_date_of_birth_month'] = $preferredAuthor->date_of_birth->month == 0 ? "" : $preferredAuthor->date_of_birth->month;
                $result['author_date_of_birth_year'] = $preferredAuthor->date_of_birth->year == 0 ? "" : $preferredAuthor->date_of_birth->year;;
            }

            if ($preferredAuthor->date_of_death != null) {
                $result['author_date_of_death_day'] = $preferredAuthor->date_of_death->day == 0 ? "" : $preferredAuthor->date_of_death->day;
                $result['author_date_of_death_month'] = $preferredAuthor->date_of_death->month == 0 ? "" : $preferredAuthor->date_of_death->month;
                $result['author_date_of_death_year'] = $preferredAuthor->date_of_death->year == 0 ? "" : $preferredAuthor->date_of_death->year;
            }

        }

        /** @var AuthorService $authorService */
        $authorService = App::make('AuthorService');
        $output = array();
        foreach ($book->authors as $secAuthor) {
            array_push($output, $authorService->authorToString($secAuthor));
        }
        $output = array_slice($output, 1);
        $result['secondary_authors'] = implode(BookInfoParameterMapper::TAG_DELIMITER, $output);

        if ($book->book_from_author != null) {
            $result['book_from_author_title'] = $book->book_from_author->title;
        }

        return $result;
    }


    public static function fillForPersonalInfo($id)
    {
        $book = Book::with(array('personal_book_info', 'book_from_author', 'publisher_serie', 'tags'))->find($id);
        $result['book_id'] = $id;
        $result['personal_info_owned'] = 'true';
        $result['personal_info_reading_date_input'] = '';
        $result['personal_info_rating'] = '';
        $result['personal_info_review'] = '';
        $result['book_wizard_step'] = $book->wizard_step;
        $result['book_title'] = $book->title;

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
            $result['personal_info_review'] = $book->personal_book_info->review;
        }

        return $result;
    }

    public static function fillForFirstPrint($bookId)
    {
        $book = Book::with(array('personal_book_info', 'book_from_author', 'publisher_serie', 'tags'))->find($bookId);
        $result['book_wizard_step'] = $book->wizard_step;
        $result['book_title'] = $book->title;
        $result['book_id'] = $bookId;
        $result['first_print_title'] = "";
        $result['first_print_subtitle'] = "";
        $result['first_print_isbn'] = "";
        $result['first_print_language'] = "";
        $result['first_print_country'] = "";
        $result['first_print_publisher'] = "";
        $result['first_print_publication_date_day'] = "";
        $result['first_print_publication_date_month'] = "";
        $result['first_print_publication_date_year'] = "";

        if ($book->first_print_info != null) {
            $result['first_print_title'] = $book->first_print_info->title;
            $result['first_print_subtitle'] = $book->first_print_info->subtitle;
            $result['first_print_isbn'] = $book->first_print_info->ISBN;
            if ($book->first_print_info->language != null) {
                $result['first_print_language'] = $book->first_print_info->language;
            }

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
        }

        return $result;
    }

    public static function fillForBuyInfo($bookId)
    {
        $book = Book::with(array('personal_book_info', 'book_from_author', 'publisher_serie', 'tags'))->find($bookId);
        $result['book_wizard_step'] = $book->wizard_step;
        $result['book_title'] = $book->title;
        $result['book_id'] = $bookId;
        $result['gift_info_receipt_date'] = '';
        $result['gift_info_from'] = '';
        $result['gift_info_occasion'] = '';
        $result['gift_info_reason'] = '';
        $result['buy_info_buy_date'] = '';
        $result['buy_info_price_payed'] = '';
        $result['buy_info_price_payed_currency'] = '';
        $result['buy_info_reason'] = '';
        $result['buy_info_shop'] = '';
        $result['buy_info_city'] = '';
        $result['buy_info_country'] = '';
        $result['giftInfoSet'] = false;
        $result['buyInfoSet'] = true;
        $result['buyOrGift'] = 'BUY';

        if ($book->personal_book_info->buy_info != null) {
            $result['buyOrGift'] = 'BUY';

            $buy_date = strtotime($book->personal_book_info->buy_info->buy_date);
            if (!StringUtils::isEmpty($buy_date)) {
                $result['buy_info_buy_date'] = DateFormatter::toDateWithSlashes($buy_date);
            }
            $result['buy_info_price_payed'] = StringUtils::replace($book->personal_book_info->buy_info->price_payed, ".", ",");
            $result['buy_info_reason'] = $book->personal_book_info->buy_info->reason;
            $result['buy_info_shop'] = $book->personal_book_info->buy_info->shop;

            $result['buy_info_price_payed_currency'] = $book->personal_book_info->buy_info->currency;
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
            $result['buyOrGift'] = 'GIFT';

            $receipt_date = strtotime($book->personal_book_info->gift_info->receipt_date);
            if (!StringUtils::isEmpty($receipt_date)) {
                $result['gift_info_receipt_date'] = DateFormatter::toDateWithSlashes($receipt_date);
            }
            $result['gift_info_from'] = $book->personal_book_info->gift_info->from;
            $result['gift_info_occasion'] = $book->personal_book_info->gift_info->occasion;
            $result['gift_info_reason'] = $book->personal_book_info->gift_info->reason;
            $result['giftInfoSet'] = true;
            $result['buyInfoSet'] = false;
        }
        return $result;
    }


    public static function fillForCover($bookId)
    {
        /** @var BookService $bookService */
        $bookService = App::make('BookService');

        $book = $bookService->find($bookId);

        $result['book_wizard_step'] = $book->wizard_step;
        $result['book_id'] = $bookId;
        $result['book_title'] = $book->title;
        $result['book_isbn'] = $book->ISBN;

        if($book->preferredAuthor() != null){
            $result['author_name'] = $book->preferredAuthor()->name . " " . $book->preferredAuthor()->firstname;
        }

        if (StringUtils::isEmpty($book->coverImage)) {
            $result['book_cover_image'] = Config::get("properties.questionImage");
        } else {
            $result['book_cover_image'] = Config::get("properties.bookImagesLocation") . "/" . Auth::user()->username . "/" . $book->coverImage;
        }
        $result['book_type_of_cover'] = $book->type_of_cover;

        return $result;
    }


    public static function createEditBookArray($bookId)
    {
        $book = Book::with(array('personal_book_info', 'book_from_author', 'publisher_serie', 'tags'))->find($bookId);

        $preferredAuthor = $book->authors[0];
        foreach ($book->authors as $author) {
            if ($author->pivot->preferred == true) {
                $preferredAuthor = $author;
            }
        }

        $result = BookFormFiller::createArrayForCreate();
        $result['book_id'] = $bookId;
        $result['book_title'] = $book->title;
        $result['book_subtitle'] = $book->subtitle;
        $result['book_isbn'] = $book->ISBN;
        $result['book_number_of_pages'] = $book->number_of_pages;
        $result['book_print'] = $book->print;
        $result['book_cover_image'] = $book->coverImage;

        if (StringUtils::isEmpty($book->coverImage)) {
            $result['book_cover_image'] = Config::get("properties.questionImage");
        } else {
            $result['book_cover_image'] = Config::get("properties.bookImagesLocation") . "/" . Auth::user()->username . "/" . $book->coverImage;
        }

        $result['book_type_of_cover'] = $book->type_of_cover;
        $result['book_state'] = $book->state;
        $output = array_map(function ($object) {
            return $object['name'];
        }, $book->tags->toArray());
        $result['book_tags'] = implode(BookInfoParameterMapper::TAG_DELIMITER, $output);
        $result['book_old_tags'] = $book->old_tags;
        $result['translator'] = $book->translator;
        $result['book_summary'] = $book->summary;

        $result['first_print_title'] = $book->first_print_info->title;
        $result['first_print_subtitle'] = $book->first_print_info->subtitle;
        $result['first_print_isbn'] = $book->first_print_info->ISBN;
        if ($book->first_print_info->language != null) {
            $result['first_print_language'] = $book->first_print_info->language;
        }

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
            $result['personal_info_review'] = $book->personal_book_info->review;
        }

        $result['author_name'] = $preferredAuthor->name;
        $result['author_infix'] = $preferredAuthor->infix;
        $result['author_firstname'] = $preferredAuthor->firstname;

        if (StringUtils::isEmpty($preferredAuthor->image)) {
            $result['author_image'] = Config::get("properties.questionImage");
        } else {
            $result['author_image'] = Config::get("properties.authorImagesLocation") . "/" . $preferredAuthor->image;
        }

        if (empty($preferredAuthor->infix)) {
            $result['author_name_book_info'] = $preferredAuthor->name . ', ' . $preferredAuthor->firstname;
        } else {
            $result['author_name_book_info'] = $preferredAuthor->name . ', ' . $preferredAuthor->infix . ', ' . $preferredAuthor->firstname;
        }

        /** @var AuthorService $authorService */
        $authorService = App::make('AuthorService');
        $output = array();
        foreach ($book->authors as $secAuthor) {
            array_push($output, $authorService->authorToString($secAuthor));
        }
        $output = array_slice($output, 1);
        $result['secondary_authors'] = implode(BookInfoParameterMapper::TAG_DELIMITER, $output);

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
            $result['book_language'] = $book->language->language;
        } else {
            $result['book_language'] = '';
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

        if ($preferredAuthor->date_of_birth != null) {
            $result['author_date_of_birth_day'] = $preferredAuthor->date_of_birth->day == 0 ? "" : $preferredAuthor->date_of_birth->day;
            $result['author_date_of_birth_month'] = $preferredAuthor->date_of_birth->month == 0 ? "" : $preferredAuthor->date_of_birth->month;
            $result['author_date_of_birth_year'] = $preferredAuthor->date_of_birth->year == 0 ? "" : $preferredAuthor->date_of_birth->year;;
        }

        if ($preferredAuthor->date_of_death != null) {
            $result['author_date_of_death_day'] = $preferredAuthor->date_of_death->day == 0 ? "" : $preferredAuthor->date_of_death->day;
            $result['author_date_of_death_month'] = $preferredAuthor->date_of_death->month == 0 ? "" : $preferredAuthor->date_of_death->month;
            $result['author_date_of_death_year'] = $preferredAuthor->date_of_death->year == 0 ? "" : $preferredAuthor->date_of_death->year;
        }

        if ($book->personal_book_info->buy_info != null) {
            $result['buyOrGift'] = 'BUY';

            $buy_date = strtotime($book->personal_book_info->buy_info->buy_date);
            if (!StringUtils::isEmpty($buy_date)) {
                $result['buy_info_buy_date'] = DateFormatter::toDateWithSlashes($buy_date);
            }
            $result['buy_info_price_payed'] = StringUtils::replace($book->personal_book_info->buy_info->price_payed, ".", ",");
            $result['buy_book_info_retail_price'] = StringUtils::replace($book->retail_price, ".", ",");
            $result['buy_book_info_retail_price_currency'] = $book->currency;
            $result['buy_info_reason'] = $book->personal_book_info->buy_info->reason;
            $result['buy_info_shop'] = $book->personal_book_info->buy_info->shop;

            $result['buy_info_price_payed_currency'] = $book->personal_book_info->buy_info->currency;
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
            $result['buyOrGift'] = 'GIFT';

            $receipt_date = strtotime($book->personal_book_info->gift_info->receipt_date);
            if (!StringUtils::isEmpty($receipt_date)) {
                $result['gift_info_receipt_date'] = DateFormatter::toDateWithSlashes($receipt_date);
            }
            $result['gift_book_info_retail_price'] = StringUtils::replace($book->retail_price, ".", ",");
            $result['gift_book_info_retail_price_currency'] = $book->currency;
            $result['gift_info_from'] = $book->personal_book_info->gift_info->from;
            $result['gift_info_occasion'] = $book->personal_book_info->gift_info->occasion;
            $result['gift_info_reason'] = $book->personal_book_info->gift_info->reason;
            $result['giftInfoSet'] = true;
            $result['buyInfoSet'] = false;
        }

        if ($book->book_from_author != null) {
            $result['book_from_author_title'] = $book->book_from_author->title;
        }

        return $result;
    }

    public static function createArrayForCreate()
    {
        $result = array();
        $result['book_id'] = '';
        $result['book_wizard_step'] = '';
        $result['book_title'] = 'Nieuw boek';
        $result['book_subtitle'] = '';
        $result['book_isbn'] = '';
        $result['book_number_of_pages'] = '';
        $result['book_cover_image'] = '';
        $result['book_print'] = '';
        $result['book_print'] = '';
        $result['book_tags'] = '';
        $result['translator'] = '';
        $result['book_summary'] = '';
        $result['author_name_book_info'] = '';
        $result['author_name'] = '';
        $result['author_infix'] = '';
        $result['author_firstname'] = '';
        $result['author_image'] = '';
        $result['book_publisher'] = '';
        $result['book_country'] = '';
        $result['book_serie'] = '';
        $result['book_publisher_serie'] = '';
        $result['book_language'] = '';
        $result['book_old_tags'] = '';
        $result['book_genre_input'] = '';
        $result['book_publication_date_day'] = '';
        $result['book_publication_date_month'] = '';
        $result['book_publication_date_year'] = '';
        $result['secondary_authors'] = '';
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
        $result['first_print_language'] = '';
        $result['personal_info_owned'] = 'true';
        $result['personal_info_reading_date_input'] = '';
        $result['personal_info_rating'] = '';
        $result['personal_info_review'] = '';
        $result['gift_info_receipt_date'] = '';
        $result['gift_book_info_retail_price'] = '';
        $result['gift_book_info_retail_price_currency'] = '';
        $result['gift_info_from'] = '';
        $result['gift_info_occasion'] = '';
        $result['gift_info_reason'] = '';
        $result['buy_info_buy_date'] = '';
        $result['buy_info_price_payed'] = '';
        $result['buy_book_info_retail_price'] = '';
        $result['buy_book_info_retail_price_currency'] = '';
        $result['buy_info_price_payed_currency'] = '';
        $result['buy_info_reason'] = '';
        $result['buy_info_shop'] = '';
        $result['buy_info_city'] = '';
        $result['buy_info_country'] = '';
        $result['book_type_of_cover'] = '';
        $result['book_state'] = '';
        $result['giftInfoSet'] = false;
        $result['buyInfoSet'] = true;
        $result['book_from_author_title'] = '';
        $result['buyOrGift'] = 'BUY';
        return $result;
    }
}