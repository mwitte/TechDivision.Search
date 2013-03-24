<?php

namespace Com\TechDivision\Search\Field;

interface FieldInterface
{
	/**
	 * @return string
	 */
	public function getName();

	/**
	 * @param string $name
	 */
	public function setName($name);

	/**
	 * @return string
	 */
	public function getValue();

	/**
	 * @param string $value
	 */
	public function setValue($value);

	/**
	 * @return float
	 */
	public function getBoost();

	/**
	 * @param float $boost
	 */
	public function setBoost($boost);
}
