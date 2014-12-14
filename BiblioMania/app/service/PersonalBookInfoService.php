<?php
class PersonalBookInfoService {

	public function save($bookId, $owned, $review, $rating){
		$personalInfoBook = new PersonalBookInfo();

        $personalInfoBook->book_id = $bookId;
        $personalInfoBook->owned = $owned;
        $personalInfoBook->review = $review;
        $personalInfoBook->rating = $rating;

        $personalInfoBook->save();
        return $personalInfoBook;
	}
}