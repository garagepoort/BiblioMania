<?php

use Bendani\PhpCommon\Utils\Model\StringUtils;

class BookImportController extends BaseController {

	private $logger;

	/** @var  BookCreationService */
	private $bookCreationService;
	/** @var  ImportFileMapper */
	private $importFileMapper;
	/** @var  LanguageService */
	private $languageService;

	function __construct()
	{
		$this->importFileMapper = App::make('ImportFileMapper');
		$this->bookCreationService = App::make('BookCreationService');
		$this->languageService = App::make('LanguageService');
	}

	public function importBooks(){
		ini_set('max_execution_time', 300);
		ini_set('memory_limit', '1024M');
		$this->logger = new Katzgrau\KLogger\Logger(app_path().'/storage/logs');

		$directory = dirname(__FILE__);
		$fileName = $directory . "/../Elisabkn.txt";

		$bookCreationParameters = $this->importFileMapper->mapFileToParameters($fileName);
		foreach($bookCreationParameters as $creationParameter){
			$this->bookCreationService->createBook($creationParameter);
		}
		OeuvreMatcher::matchOeuvres();
		ini_set('max_execution_time', 30);
		ini_set('memory_limit', '128M');
	}

	public function importLanguageFirstPrintInfo(){
		ini_set('max_execution_time', 300);
		ini_set('memory_limit', '1024M');

		$directory = dirname(__FILE__);
		$fileName = $directory . "/../Elisabkn.txt";

		$bookCreationParameters = $this->importFileMapper->mapFileToParameters($fileName);
		/** @var BookCreationParameters $creationParameter */
		foreach($bookCreationParameters as $creationParameter){
			/** @var BookInfoParameters $bookInfoParameters */
			$bookInfoParameters = $creationParameter->getBookInfoParameters();
			/** @var FirstPrintInfoParameters $firstPrintInfoParameters */
			$firstPrintInfoParameters = $creationParameter->getFirstPrintInfoParameters();

			$book = Book::with('first_print_info')->where("title", "=", $bookInfoParameters->getTitle())->first();
			if($book != null){
				$first_print_info = $book->first_print_info;
				if($first_print_info != null){
					$languageName = $firstPrintInfoParameters->getLanguage();
					if(!StringUtils::isEmpty($languageName)){
						$language = $this->languageService->findOrSave($languageName);
						$first_print_info->language()->associate($language);
						$first_print_info->save();
					}
				}
				if(!StringUtils::isEmpty($bookInfoParameters->getLanguage())){
					$language = $this->languageService->findOrSave($bookInfoParameters->getLanguage());
					$book->language()->associate($language);
					$book->save();
				}
			}
		}

		ini_set('max_execution_time', 30);
		ini_set('memory_limit', '128M');
	}
}