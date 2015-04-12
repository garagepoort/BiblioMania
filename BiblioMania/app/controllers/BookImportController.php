<?php

class BookImportController extends BaseController {

	private $logger;
	private $bookTitle;
	private $bookSubTitle;
	private $bookISBN;
	private $bookSummary;
	private $bookTypeOfCover;
	private $bookRetailPrice;
	private $personalInfoOwned;
	private $personalInfoRead;

	private $authorName;
	private $authorFirstName;
	private $authorInfix;

	private $firstPrintTitle;
	private $firstPrintLanguage;
	private $firstPrintISBN;
	private $firstPrintPublicationDate;
	private $firstPrintPublisherName;
	private $firstPrintPublisherCountry;

	private $giftFrom;
	private $price_payed;
	private $shop;
	private $buy_date;

	public function importBooks(){

		ini_set('max_execution_time', 300);
		ini_set('memory_limit', '1024M');
		$this->logger = new Katzgrau\KLogger\Logger(app_path().'/storage/logs');

		$directory = dirname(__FILE__);
		$handle = fopen($directory . "/../Elisabkn.txt", "r");
		if ($handle) {
		    while (($line = fgets($handle)) !== false) {
		        $values = explode("|", $line);
		        $this->setValues($values);

		        $authors = $this->importAuthors($values);
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
		ini_set('max_execution_time', 30);
		ini_set('memory_limit', '16M');
	}

	private function importBuyOrGiftInfo($personalBookInfo){
		if(empty($this->giftFrom)){
			return BuyInfoImporter::importBuyInfo($personalBookInfo->id, $this->buy_date, $this->price_payed, $this->shop);
		}else{
			return GiftInfoImporter::importGiftInfo($personalBookInfo->id, $this->giftFrom, $this->buy_date);
		}
	}

	private function importFirstPrintInfo($values){
		return FirstPrintInfoImporter::importFirstPrintInfo(
				$this->firstPrintTitle,
				'',
				$this->firstPrintISBN,
				$this->firstPrintPublisherCountry,
				$this->firstPrintLanguage,
				$this->firstPrintPublisherName,
				$values[53]);
	}

	private function importAuthors($values){

		$firstAuthorParameters = new AuthorInfoParameters($values[2], $values[0], $values[2], new Date(), new Date(), null, $values[18], $values[46]);
		$secondAuthorParameters = new AuthorInfoParameters($values[5], $values[3], $values[4], new Date(), new Date(), null, null, null);
		$thirdAuthorParameters = new AuthorInfoParameters($values[8], $values[6], $values[7], new Date(), new Date(), null, null, null);
		$fourthAuthorParameters = new AuthorInfoParameters($values[2], $values[0], $values[2], new Date(), new Date(), null, null, null);

		return AuthorImporter::importAuthors($values[2], $values[0], $values[1],
										$values[5], $values[3], $values[4],
										$values[8], $values[6], $values[7],
										$values[18], $values[46]);
	}

	private function importPublisher($values){
		$publisherService = App::make('PublisherService');
		$name = $values[12];
		$countryName = $values[41];
		$country = App::make('CountryService')->findOrSave($countryName);

		return $publisherService->saveOrUpdate($name, $country);
	}

	private function importPersonalBookInfo($values, $book_id){
		$personalBookInfo = new PersonalBookInfo(array(
			'book_id' => $book_id,
			'rating' => $values[44]
		));

		$personalBookInfo->set_owned($this->personalInfoOwned);
		$personalBookInfo->set_read($this->personalInfoRead);
		$personalBookInfo->save();
		if($values[42] != ''){
			$reading_date = DateTime::createFromFormat('d-m-y', $values[42]);
			$reading_date = App::make('ReadingDateService')->saveOrFind($reading_date);
			$personalBookInfo->reading_dates()->attach($reading_date->id);
		}

		return $personalBookInfo;
	}

	private function importBook($values, $publisher, $firstPrintInfo){
		$path = explode('\\', $values[19]);
		$coverImage = 'bookImages/' . Auth::user()->username . '/' . end($path);
		$country = App::make('CountryService')->findOrSave($values[41]);
		$language = App::make('LanguageService')->findOrSave($values[61]);
		$book = new Book(array(
                'title' => $this->bookTitle,
                'subtitle' => $this->bookSubtitle,
                'summary' => $this->bookSummary,
                'type_of_cover' => $values[13],
                'ISBN' => $this->bookISBN,
                'publisher_id' => $publisher->id,
                'publisher_country_id' => $country->id,
                'number_of_pages' => $values[57],
                'print' => $values[27],
                'retail_price' => $this->bookRetailPrice,
                'genre_id' => 1,
                'coverImage' => $coverImage,
                'first_print_info_id' => $firstPrintInfo->id,
                'language_id' => $language->id,
                'user_id' => Auth::user()->id
        ));
    	$date = DateImporter::getPublicationDate($values[59]);
    	if(!is_null($date)){
    		$book->publication_date_id = $date->id;	
    	}
        $book->save();
        return $book;
	}

	private function get_string_between($string, $start, $end){
		$pattern = '/(18|19|20)[0-9][0-9]/';
	    $found = preg_match($pattern, $string, $results);
	    if($found){
	    	$result = str_replace('(', '', $results[0]);
	    	$result = str_replace(')', '', $result);
	    	return $result;
	    }
	    return '';
	}

	private function setValues($values){
		$this->bookTitle = $values[9];
		$this->bookSubtitle = $values[48];
		$this->bookISBN = $values[10];
		$this->bookSummary = $values[62];

		if(count(explode(" ", $values[47])) > 1){
			$this->bookRetailPrice = explode(" ", $values[47])[1];
		}else{
			$this->bookRetailPrice = $values[47];
		}
		
		$inCollection = $values[64];
		if($inCollection === 'In verzameling'){
			$this->personalInfoOwned = true;
		}else{
			$this->personalInfoOwned = false;
		}

		$read = $values[66];
		if($read === 'ja'){
			$this->personalInfoRead = true;
		}else{
			$this->personalInfoRead = false;
		}

		$this->firstPrintTitle = $values[55];
		if(empty($this->firstPrintTitle)){
			$this->firstPrintTitle = $this->bookTitle;
		}
		$this->firstPrintLanguage = $values[54];
		$this->firstPrintPublicationDate = $values[53];
		$this->firstPrintPublisherName = $values[56];
		$this->firstPrintPublisherCountry = $values[50];

		$this->giftFrom = $values[33];
		$this->price_payed = $values[16];
		$this->shop = $values[65];
		if($values[15] !== ''){
			$this->buy_date = DateTime::createFromFormat('d-m-y', $values[15]);
		}
	}

	function startsWith($haystack, $needle)
	{
	     $length = strlen($needle);
	     return (substr($haystack, 0, $length) === $needle);
	}

	function endsWith($haystack, $needle)
	{
	    $length = strlen($needle);
	    if ($length == 0) {
	        return true;
	    }

	    return (substr($haystack, -$length) === $needle);
	}

}