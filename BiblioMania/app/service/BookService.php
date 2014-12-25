<?php

class BookService {

	public function getValueOfLibrary(){
		return  DB::table('book')->where('user_id', '=', Auth::user()->id)->sum('retail_price');
	}

	public function getTotalAmountOfBooksInLibrary(){
		return  DB::table('book')->where('user_id', '=', Auth::user()->id)->count();
	}

	public function getTotalAmountOfBooksOwned(){
		return  Book::join('personal_book_info', 'book_id', '=', 'book.id')
					->where('user_id', '=', Auth::user()->id)
					->where('personal_book_info.owned', '=', 1)
					->count();
	}
}