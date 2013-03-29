<?php

namespace Com\TechDivision\Search\Document;
/**
 * Created by JetBrains PhpStorm.
 * User: wittem
 * Date: 23.03.13
 * Time: 15:00
 * To change this template use File | Settings | File Templates.
 */
class Document implements DocumentInterface
{

	/**
	 * @var array
	 */
	protected $fields = array();

	/**
	 * @var float
	 */
	protected $boost = null;

	/**
	 * @param \Com\TechDivision\Search\Field\FieldInterface $field
	 */
	public function addField(\Com\TechDivision\Search\Field\FieldInterface $field)
	{
		$this->fields[] = $field;
	}

	/**
	 * @param array $fields
	 */
	public function setFields(array $fields)
	{
		$this->fields = $fields;
	}

	/**
	 * @param string $fieldName
	 * @return \Com\TechDivision\Search\Field\FieldInterface|null
	 */
	public function getField($fieldName){
		/** @var $field \Com\TechDivision\Search\Field\FieldInterface */
		foreach($this->fields as $field){
			if($field->getName() == $fieldName){
				return $field;
			}
		}
		return null;
	}

	/**
	 * @return array Com\TechDivision\Search\Field\FieldInterface
	 */
	public function getFields()
	{
		return $this->fields;
	}

	/**
	 * @param \Com\TechDivision\Search\Field\FieldInterface $field
	 * @return bool
	 */
	public function removeField(\Com\TechDivision\Search\Field\FieldInterface $field)
	{
		// find key of element
		$key = array_search($field, $this->fields, true);
		if(is_int($key)){
			// remove element
			unset($this->fields[$key]);
			// normalize array keys
			$this->fields = array_values($this->fields);
			return true;
		}
		return false;
	}

	/**
	 * @return int
	 */
	public function getFieldCount()
	{
		return count($this->fields);
	}

	/**
	 * @param float $value
	 */
	public function setBoost($value)
	{
		$this->boost = $value;
	}

	/**
	 * @return float
	 */
	public function getBoost()
	{
		return $this->boost;
	}
}
