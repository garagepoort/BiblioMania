<?php
use Bendani\PhpCommon\Utils\Model\StringUtils;

/**
 * Created by PhpStorm.
 * User: david
 * Date: 22/06/15
 * Time: 21:09
 */
class FileToGenreMapper
{

    /** @var  GenreService */
    private $genreService;

    function __construct()
    {
        $this->genreService = App::make('GenreService');
    }


    public function mapToGenre($line_values)
    {
        $genreLine = $line_values[LineMapping::$BookGenre];

        if (!StringUtils::isEmpty($genreLine)) {
            $genreLine = StringUtils::toLowerCase($genreLine);

            $historicRomanMapping = array('geschiedenis; roman', "roman; woii", "roman; woi");
            $historyMapping = array("Geschiedenis en politiek", "geschiedenis");
            $thrillerMapping = array("thriller - detective");
            $YAMapping = array("young adult");
            $YAModernClassicMapping = array("modern classic; young adult");
            $modernClassicMapping = array("modern classic; roman; woii", "modern classic; novelle", "modern classic; roman");
            $satireMapping = array("roman; satire");
            $graphicNovelMapping = array("Graphic novel", "graphic novel; woii");
            $childrenMapping = array("kinder en jeugd", "kinder en jeugd; roman", "kinder en jeugd; roman; woii");
            $mensEnMaatschappijMapping = array("mens en maatschappij; roman", "communicatiewetenschappen","development studies","economie en bedrijf algemeen","management business en recht en maatschappij","management, business en recht","politicologie","psychologie","psycologie","recht","sociaal beleid","sociologie");

            if (in_array($genreLine, $historicRomanMapping)) {
                return 20;
            }
            if (in_array($genreLine, $historyMapping)) {
                return 8;
            }
            if (in_array($genreLine, $modernClassicMapping)) {
                return 22;
            }
            if (in_array($genreLine, $graphicNovelMapping)) {
                return 19;
            }
            if (in_array($genreLine, $childrenMapping)) {
                return 3;
            }
            if (in_array($genreLine, $mensEnMaatschappijMapping)) {
                return 9;
            }
            if (in_array($genreLine, $satireMapping)) {
                return 14;
            }
            if (in_array($genreLine, $thrillerMapping)) {
                return 18;
            }
            if (in_array($genreLine, $YAMapping)) {
                return 2;
            }
            if (in_array($genreLine, $YAModernClassicMapping)) {
                return 7;
            }

            $genre = $this->genreService->getGenreByName($genreLine);
            if($genre != null){
                return $genre->id;
            }else{
                $logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');
                $logger->info("Genre not found: $genreLine");
                return 1;
            }
        }
        return 1;
    }

}