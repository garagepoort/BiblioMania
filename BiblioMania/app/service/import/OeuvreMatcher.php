<?php

class OeuvreMatcher
{
    public static function matchOeuvres()
    {
        $authors = Author::all();
        foreach ($authors as $author) {
            OeuvreMatcher::matchOeuvresFromAuthor($author);
        }
    }

    public static function matchOeuvresFromAuthor($author)
    {
        $books = $author->books;
        $booksFromAuthor = $author->oeuvre;

        foreach ($books as $book) {
            $foundBooksFromAuthor = array();
            foreach ($booksFromAuthor as $bookFromAuthor) {
                $title = strtolower($bookFromAuthor->title);

                $posTitle = strpos($title, strtolower($book->title));
                $posOriginalTitle = false;
                if ($book->first_print_info->title != null && !empty($book->first_print_info->title)) {
                    $posOriginalTitle = strpos($title, strtolower($book->first_print_info->title));
                }

                if ($posTitle !== false || $posOriginalTitle !== false) {
                    array_push($foundBooksFromAuthor, $bookFromAuthor);
                }
            }

            if (count($foundBooksFromAuthor) == 1) {
                $book->book_from_author_id = $foundBooksFromAuthor[0]->id;
                $book->save();
            } else if (count($foundBooksFromAuthor) > 1) {
                foreach ($foundBooksFromAuthor as $foundBookFromAuthor) {
                    $year = $foundBookFromAuthor->publication_year;
                    if ($book->first_print_info->publication_date->year == $year) {
                        $book->book_from_author_id = $foundBookFromAuthor->id;
                        $book->save();
                    }
                }
            }
        }
    }
}