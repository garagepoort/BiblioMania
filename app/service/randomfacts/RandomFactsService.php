<?php

class RandomFactsService
{

	/** @var BookRepository $bookRepository */
	private $bookRepository;

	public function __construct()
	{
		$this->bookRepository = App::make('BookRepository');
	}

	public function getRandomFacts($userId){
		$facts = array();
		array_push($facts, $this->getBookReadYearFact('book.read.one.year', '-1', $userId));
		array_push($facts, $this->getBookReadYearFact('book.read.five.year', '-5', $userId));
		array_push($facts, $this->getBookReadYearFact('book.read.ten.year', '-10', $userId));
		array_push($facts, $this->getBookReceivedYearFact('book.received.one.year', '-1', $userId));
		array_push($facts, $this->getBookReceivedYearFact('book.received.five.year', '-5', $userId));
		array_push($facts, $this->getBookReceivedYearFact('book.received.ten.year', '-10', $userId));
		array_push($facts, $this->getBooksReadInMonth($userId));
		array_push($facts, $this->getBooksReleased('book.released.one.year', '-1'));
		array_push($facts, $this->getBooksReleased('book.released.five.year', '-5'));
		array_push($facts, $this->getBooksReleased('book.released.ten.year', '-10'));
		array_push($facts, $this->getBooksSuggestion($userId, 'book.suggestion', '-5'));
		array_push($facts, $this->birthDayAuthorFact());
		$facts = array_values(array_filter($facts));
		if(count($facts) > 3){
			return array_rand($facts, 3);
		}
		return $facts;
	}

	private function birthDayAuthorFact(){
		$now = new DateTime('now');
		$author = Author::select('author.*')
			->join('date', 'date_of_birth_id', '=', 'date.id')
			->where('date.month', '=', $now->format('n'))
			->where('date.day', '=', $now->format('j'))
			->inRandomOrder()
			->first();
		if($author != null){
			$authorName = $author->firstname . ' ' . $author->name;
			return new RandomFact("author.birthday", ['author' => $authorName]);
		}
		return null;
	}

	private function getBooksReadInMonth($userId){
		$previousDate = new DateTime('first day of previous month');
		$previousYear = $previousDate->format('Y');
		$previousMonth = $previousDate->format('n');
		$previousCount = $this->bookRepository->getTotalAmountOfBooksReadInMonth($userId, $previousMonth, $previousYear);

		$now = new DateTime('now');
		$year = $now->format('Y');
		$month = $now->format('n');
		$count = $this->bookRepository->getTotalAmountOfBooksReadInMonth($userId, $month, $year);

		return new RandomFact('books.read.month', ['previousCount' => $previousCount, 'count' => $count, 'month' => $month, 'year' => $year]);
	}

	private function getBookReadYearFact($key, $years, $userId)
	{
		$time = new DateTime('now');
		$newtime = $time->modify($years . ' year')->format('Y-m-d');
		$book = Book::select('book.*')
			->join('personal_book_info', 'book_id', '=', 'book.id')
			->join('reading_date', 'reading_date.personal_book_info_id', '=', 'personal_book_info.id')
			->where('user_id', '=', $userId)
			->where('reading_date.date', '=', $newtime)
			->inRandomOrder()
			->first();

		if($book != null){
			return new RandomFact($key, array("book" => $book->title));
		}

		return null;
	}

	private function getBooksReleased($key, $years)
	{
		$time = new DateTime('now');
		$newtime = $time->modify($years . ' year');
		$book = Book::select('book.*')
			->join('first_print_info', 'first_print_info.id', '=', 'book.first_print_info_id')
			->join('date', 'first_print_info.publication_date_id', '=', 'date.id')
			->where('date.month', '=', $newtime->format('n'))
			->where('date.day', '=', $newtime->format('j'))
			->where('date.year', '=', $newtime->format('Y'))
			->inRandomOrder()
			->first();

		if($book != null){
			return new RandomFact($key, array("book" => $book->title));
		}

		return null;
	}

	private function getBooksSuggestion($userId, $key, $years)
	{
		$time = new DateTime('now');
		$newtime = $time->modify($years . ' year');
		$book = Book::select('book.*')
			->join('personal_book_info', 'book_id', '=', 'book.id')
			->join('gift_info', 'gift_info.personal_book_info_id', '=', 'personal_book_info.id', 'left outer')
			->join('buy_info', 'buy_info.personal_book_info_id', '=', 'personal_book_info.id', 'left outer')
			->join('reading_date', 'reading_date.personal_book_info_id', '=', 'personal_book_info.id', 'left outer')
			->where('user_id', '=', $userId)
			->whereNull('reading_date.id')
			->where(function ($query) use ($newtime) {
				$query->where('gift_info.receipt_date', '<', $newtime)
					->orWhere('buy_info.buy_date', '<', $newtime);
			})
			->inRandomOrder()
			->first();

		if($book != null){
			return new RandomFact($key, array("book" => $book->title));
		}

		return null;
	}

	private function getBookReceivedYearFact($key, $years, $userId)
	{
		$time = new DateTime('now');
		$newtime = $time->modify($years . ' year')->format('Y-m-d');
		$book = Book::select('book.*')
			->join('personal_book_info', 'book_id', '=', 'book.id')
			->join('gift_info', 'gift_info.personal_book_info_id', '=', 'personal_book_info.id', 'left outer')
			->join('buy_info', 'buy_info.personal_book_info_id', '=', 'personal_book_info.id', 'left outer')
			->where('user_id', '=', $userId)
			->where(function ($query) use ($newtime) {
				$query->where('gift_info.receipt_date', '=', $newtime)
					->orWhere('buy_info.buy_date', '=', $newtime);
			})
			->inRandomOrder()
			->first();

		if($book != null){
			return new RandomFact($key, array("book" => $book->title));
		}

		return null;
	}
}