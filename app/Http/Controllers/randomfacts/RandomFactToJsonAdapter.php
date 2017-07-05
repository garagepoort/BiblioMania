<?php

class RandomFactToJsonAdapter
{

	private $key;
	private $variables;

	/**
	 * RandomFactToJsonAdapter constructor.
	 */
	public function __construct(RandomFact $randomFact)
	{
		$this->key = $randomFact->getKey();
		$this->variables = $randomFact->getVariables();
	}

	public function mapToJson(){
		return array(
			"key" => $this->key,
			"variables" => $this->variables
		);
	}
}