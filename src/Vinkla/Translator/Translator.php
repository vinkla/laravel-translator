<?php namespace Vinkla\Translator;

abstract class Translator {

	/**
	 * @var mixed
	 */
	protected $entity;

	/**
	 * @param $entity
	 */
	function __construct($entity)
	{
		$this->entity = $entity;
	}

	/**
	 * Allow for property-style retrieval.
	 *
	 * @param $property
	 * @return mixed
	 */
	public function __get($property)
	{
		return $this->entity->{$property};
	}
}
