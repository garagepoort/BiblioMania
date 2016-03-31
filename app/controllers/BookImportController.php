<?php

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
}