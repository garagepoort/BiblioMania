<?php

class ImportFileMapper
{
    const DELIMITER = "\";\"";
    /** @var  FileToBookParametersMapper */
    private $fileToBookParametersMapper;
    /** @var  FileToAuthorParametersMapper */
    private $fileToAuthorParametersMapper;
    /** @var  FileToFirstPrintParametersMapper */
    private $fileToFirstPrintParametersMapper;
    /** @var  FileToBuyInfoParametersMapper */
    private $fileToBuyInfoParametersMapper;
    /** @var  FileToGiftInfoParametersMapper */
    private $fileToGiftInfoParametersMapper;
    /** @var  FileToExtraBookInfoParametersMapper */
    private $fileToExtraBookInfoParametersMapper;
    /** @var  FileToPersonalBookInfoParametersMapper */
    private $fileToPersonalBookInfoParametersMapper;
    /** @var  FileToCoverInfoParametersMapper */
    private $fileToCoverInfoParametersMapper;

    function __construct()
    {
        $this->fileToBookParametersMapper = App::make('FileToBookParametersMapper');
        $this->fileToAuthorParametersMapper = App::make('FileToAuthorParametersMapper');
        $this->fileToFirstPrintParametersMapper = App::make('FileToFirstPrintParametersMapper');
        $this->fileToBuyInfoParametersMapper = App::make('FileToBuyInfoParametersMapper');
        $this->fileToGiftInfoParametersMapper = App::make('FileToGiftInfoParametersMapper');
        $this->fileToExtraBookInfoParametersMapper = App::make('FileToExtraBookInfoParametersMapper');
        $this->fileToPersonalBookInfoParametersMapper = App::make('FileToPersonalBookInfoParametersMapper');
        $this->fileToCoverInfoParametersMapper = App::make('FileToCoverInfoParametersMapper');
    }


    public function mapFileToParameters($file)
    {
        $bookCreationParameters = array();

        $handle = fopen($file, "r");
        $firstLine = true;
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $values = explode(self::DELIMITER, $line);
                for ($i = 0; $i < count($values); $i++) {
                    $values[$i] = trim($values[$i], '"');
                }

                if ($firstLine) {
                    LineMapping::initializeMapping($values);
                    $firstLine = false;
                } else {
                    $buyInfoParameters = null;
                    $giftInfoParameters = null;

                    if (empty($values[LineMapping::$GiftInfoFrom])) {
                        $buyInfoParameters = $this->fileToBuyInfoParametersMapper->map($values);
                    } else {
                        $giftInfoParameters = $this->fileToGiftInfoParametersMapper->map($values);
                    }

                    $bookParameters = $this->fileToBookParametersMapper->map($values);
                    $authorParameters = $this->fileToAuthorParametersMapper->mapToParameters($values);
                    $firstPrintParameters = $this->fileToFirstPrintParametersMapper->map($values, $values[LineMapping::$BookTitle]);
                    $extraInfoParameters = $this->fileToExtraBookInfoParametersMapper->map($values);
                    $personalBookInfoParameters = $this->fileToPersonalBookInfoParametersMapper->map($values);
                    $coverInfoParameters = $this->fileToCoverInfoParametersMapper->map($values);

                    $bookCreationParameter = new BookCreationParameters($bookParameters,
                        $extraInfoParameters,
                        $authorParameters[0],
                        $buyInfoParameters,
                        $giftInfoParameters,
                        $coverInfoParameters,
                        $firstPrintParameters,
                        $personalBookInfoParameters);

                    array_push($bookCreationParameters, $bookCreationParameter);
                }
            }
        } else {
            // error opening the file.
        }
        fclose($handle);
        return $bookCreationParameters;
    }

}