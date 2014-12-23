<?php

class BookImportController extends BaseController {

	private $logger;

	public function importBooks(){
		ini_set('max_execution_time', 300);
		$this->logger = new Katzgrau\KLogger\Logger(app_path().'/storage/logs');

		$directory = dirname(__FILE__);
		$handle = fopen($directory . "/../Elisabkn.txt", "r");
		if ($handle) {
		    while (($line = fgets($handle)) !== false) {
		        $values = explode("|", $line);
		        $authors = $this->importAuthors($values);
		        $publisher = $this->importPublisher($values);
		        $book = $this->importBook($values, $publisher);
		        foreach ($authors as $author) {
            		$book->authors()->sync([$author->id], false);
		        }
		    }
		} else {
		    // error opening the file.
		} 
		$this->matchOeuvres();
		fclose($handle);
		ini_set('max_execution_time', 30);
	}

	private function importAuthors($values){
		//first author
		$authorService = App::make('AuthorService');
		$authors = [];
		$path = explode('\\', $values[18]);
		$authorImage = Auth::user()->username . '/' . end($path);
		$author = $authorService->saveOrUpdate($values[2], $values[1], $values[0], $authorImage);
		array_push($authors, $author);
		$this->importOeuvre($values, $author);

		if(!empty($values[3]) || !empty($values[5]) ){
			$author = $authorService->saveOrUpdate($values[5], $values[4], $values[3]);
			array_push($authors, $author);
		}

		if(!empty($values[6]) || !empty($values[8]) ){
			$authorService->saveOrUpdate($values[8], $values[7], $values[6]);
			$author = array_push($authors, $author);
		}
		
		return $authors;
	}

	private function importPublisher($values){
		$publisherService = App::make('PublisherService');
		$name = $values[12];
		$countryName = $values[41];
		$country = App::make('CountryService')->findOrSave($countryName);

		return $publisherService->saveOrUpdate($name, $country);
	}

	private function importOeuvre($values, $author){
		$oeuvre = explode('\n', $values[46]);
		foreach ($oeuvre as $title) {
			if($title != ''){	
				
				$title = str_replace('*', '', $title);
				$title = trim($title);
				$year = $this->get_string_between($title, '(', ')');
				
				$foundBookFromAuthor = BookFromAuthor::where('title', '=', $title)->where('author_id', '=', $author->id)->first();
				if(is_null($foundBookFromAuthor)){
					$bookFromAuthor = new BookFromAuthor(array(
						'title' => $title,
						'publication_year' => $year,
						'author_id' => $author->id
					));
					$bookFromAuthor->save();
				}
			}
		}
	}

	private function importBook($values, $publisher){
		$path = explode('\\', $values[19]);
		$coverImage = Auth::user()->username . '/' . end($path);
		$book = new Book(array(
                'title' => $values[9],
                'subtitle' => $values[48],
                'type_of_cover' => $values[13],
                'ISBN' => $values[11],
                'publisher_id' => $publisher->id,
                'number_of_pages' => $values[57],
                'print' => $values[27],
                'retail_price' => $values[58],
                'genre_id' => 1,
                'coverImage' => $coverImage,
                'user_id' => Auth::user()->id,
        ));
        if (!empty($values[11])) {
        	$book->publication_date = DateTime::createFromFormat('Y-m-d', $values[11].'-01-01');
        }
        $book->save();
        return $book;
	}

	private function matchOeuvres(){
		$oeuvres = BookFromAuthor::all();
		foreach ($oeuvres as $oeuvre) {
			$title = strtolower($oeuvre->title);
			$author = Author::find($oeuvre->author_id);
			$this->logger->info('author id: ' . $author->id);
			foreach ($author->books as $book) {
				$this->logger->info('try match: ' . $title . ' -- ' . strtolower($book->title));
				$pos = strpos($title, strtolower($book->title));
				if ($pos !== false) {
					$book->book_from_author_id = $oeuvre->id;
					$book->save();
				}
			}
		}
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