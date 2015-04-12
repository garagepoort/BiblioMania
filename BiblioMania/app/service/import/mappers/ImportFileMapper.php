<?php

class ImportFileMapper {
    /** @var  FileToAuthorParametersMapper */
    private $fileToAuthorParametersMapper;

    function __construct()
    {
        $this->fileToAuthorParametersMapper = App::make('FileToAuthorParametersMapper');
    }


    public function mapFileToParameters($file){
        $bookCreationParameters = array();

        $directory = dirname(__FILE__);
        $handle = fopen($directory . "/../../Elisabkn.txt", "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $values = explode("|", $line);

                $authorParameters = $this->fileToAuthorParametersMapper->mapToParameters($values);

                $publisher = $this->importPublisher($values);
                $firstPrintInfo = $this->importFirstPrintInfo($values);
                $book = $this->importBook($values, $publisher, $firstPrintInfo);
                $personalBookInfo = $this->importPersonalBookInfo($values, $book->id);
                $this->importBuyOrGiftInfo($personalBookInfo);
                $count =1;
                foreach ($authors as $author) {
                    if($count == 1){
                        $book->authors()->attach($author->id, array('preferred' => true));
                    }else{
                        $book->authors()->attach($author->id, array('preferred' => false));
                    }
                    $count++;
                }
            }
        } else {
            // error opening the file.
        }
        OeuvreMatcher::matchOeuvres();
        fclose($handle);
    }

}