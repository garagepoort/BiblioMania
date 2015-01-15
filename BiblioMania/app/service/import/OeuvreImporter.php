<?php

/**
 * Created by PhpStorm.
 * User: david
 * Date: 10/01/15
 * Time: 18:17
 */
class OeuvreImporter
{
    public static function importOeuvre($oeuvre, $authorId)
    {
        $oeuvre = explode('\n', $oeuvre);
        foreach ($oeuvre as $title) {
            if ($title != '') {

                $title = str_replace('*', '', $title);
                $title = trim($title);
                $year = OeuvreImporter::get_string_between($title, '(', ')');

                $foundBookFromAuthor = BookFromAuthor::where('title', '=', $title)->where('author_id', '=', $authorId)->first();
                if (is_null($foundBookFromAuthor)) {
                    $bookFromAuthor = new BookFromAuthor(array(
                        'title' => $title,
                        'publication_year' => $year,
                        'author_id' => $authorId
                    ));
                    $bookFromAuthor->save();
                }
            }
        }
    }

    private static function get_string_between($string, $start, $end)
    {
        $pattern = '/(18|19|20)[0-9][0-9]/';
        $found = preg_match($pattern, $string, $results);
        if ($found) {
            $result = str_replace('(', '', $results[0]);
            $result = str_replace(')', '', $result);
            return $result;
        }
        return '';
    }
}