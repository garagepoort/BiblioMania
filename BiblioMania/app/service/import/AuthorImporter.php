<?php

/**
 * Created by PhpStorm.
 * User: david
 * Date: 10/01/15
 * Time: 18:11
 */
class AuthorImporter
{
    public static function importAuthors($firstAuthorName, $firstAuthorFirstName, $firstAuthorInfix,
                                         $secondAuthorName, $secondAuthorFirstName, $secondAuthorInfix,
                                         $thirdAuthorName, $thirdAuthorFirstName, $thirdAuthorInfix,
                                         $authorImagePath, $oeuvre)
    {
        //first author
        $authorService = App::make('AuthorService');
        $authors = [];
        $path = explode('\\', $authorImagePath);
        $authorImage = 'images/questionCover.png';
        $endPath = end($path);
        if ($endPath) {
            $authorImage = 'bookImages/' . Auth::user()->username . '/' . $endPath;
        }
        $author = $authorService->saveOrUpdate($firstAuthorName, $firstAuthorInfix, $firstAuthorFirstName, $authorImage);
        array_push($authors, $author);
        OeuvreImporter::importOeuvre($oeuvre, $author->id);

        if (!empty($secondAuthorFirstName) || !empty($secondAuthorName)) {
            $author = $authorService->saveOrUpdate($secondAuthorName, $secondAuthorInfix, $secondAuthorFirstName);
            array_push($authors, $author);
        }

        if (!empty($thirdAuthorName) || !empty($thirdAuthorFirstName)) {
            $authorService->saveOrUpdate($thirdAuthorName, $thirdAuthorInfix, $thirdAuthorFirstName);
            array_push($authors, $author);
        }

        return $authors;
    }
}