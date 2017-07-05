<?php

class RandomFact
{

	private $key;
	private $variables;

	/**
	 * RandomFact constructor.
	 * @param $key
	 * @param $variables
	 */
	public function __construct($key, $variables)
	{
		$this->key = $key;
		$this->variables = $variables;
	}

	/**
	 * @return mixed
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @param mixed $key
	 */
	public function setKey($key)
	{
		$this->key = $key;
	}

	/**
	 * @return mixed
	 */
	public function getVariables()
	{
		return $this->variables;
	}

	/**
	 * @param mixed $variables
	 */
	public function setVariables($variables)
	{
		$this->variables = $variables;
	}
}