<?php
class BookImporter {

	public static function importBook($imagePath, $type_of_cover, $number_of_pages, $print, $publisher, $firstPrintInfo){
		$path = explode('\\', $imagePath);
		$coverImage = 'bookImages/' . Auth::user()->username . '/' . end($path);
		$book = new Book(array(
                'title' => $this->bookTitle,
                'subtitle' => $this->bookSubtitle,
                'summary' => $this->bookSummary,
                'type_of_cover' => $type_of_cover,
                'ISBN' => $this->bookISBN,
                'publisher_id' => $publisher->id,
                'number_of_pages' => $number_of_pages,
                'print' => $print,
                'retail_price' => $this->bookRetailPrice,
                'genre_id' => 1,
                'coverImage' => $coverImage,
                'first_print_info_id' => $firstPrintInfo->id,
                'user_id' => Auth::user()->id
        ));
    	$date = $this->getPublicationDate($values[59]);
    	if(!is_null($date)){
    		$book->publication_date_id = $date->id;	
    	}
        $book->save();
        return $book;
	}
}