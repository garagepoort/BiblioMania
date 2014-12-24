<?php

class BookService {

	public function getValueOfLibrary(){
		return  DB::table('book')->where('user_id', '=', Auth::user()->id)->sum('retail_price');
	}

	public function getTotalAmountOfBooksInLibrary(){
		return  DB::table('book')->where('user_id', '=', Auth::user()->id)->count();
	}

	public function getTotalAmountOfBooksOwned(){
		return  DB::table('personal_book_info')->where('user_id', '=', Auth::user()->id)->count();
	}
}