<?php

class RandomFactsController
{

	/** @var RandomFactsService $randomFactsService */
	private $randomFactsService;

	/**
	 * RandomFactsController constructor.
	 */
	public function __construct()
	{
		$this->randomFactsService = App::make('RandomFactsService');
	}

	public function getRandomFacts(){
		$randomFacts = $this->randomFactsService->getRandomFacts(Auth::user()->id);
		return array_map(function($fact){
			$randomFactToJsonAdapter = new RandomFactToJsonAdapter($fact);
			return $randomFactToJsonAdapter->mapToJson();
		}, $randomFacts);
	}
}