<?php

namespace Com\TechDivision\Search\Field;
/**
 * Created by JetBrains PhpStorm.
 * User: wittem
 * Date: 23.03.13
 * Time: 13:31
 * To change this template use File | Settings | File Templates.
 */
class Field implements FieldInterface
{
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $value;

	/**
	 * @var float
	 */
	protected $boost;

	public function __construct($name, $value, $boost = null){
		$this->setName($name);
		$this->setValue($value);
		$this->setBoost($boost);
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param string $value
	 */
	public function setValue($value)
	{
		$this->value = $value;
	}

	/**
	 * @return float
	 */
	public function getBoost()
	{
		return $this->boost;
	}

	/**
	 * @param float $boost
	 */
	public function setBoost($boost)
	{
		$this->boost = $boost;
	}
}
