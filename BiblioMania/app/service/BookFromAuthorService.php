<?php

class BookFromAuthorService {

	public function save($author_id, $title, $year){
		$bookFromAuthor = new BookFromAuthor(array(
						'title' => $title,
						'publication_year' => $year,
						'author_id' => $author_id
		));
		$bookFromAuthor->save();
		return $bookFromAuthor;
	}
}