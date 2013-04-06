<?php

namespace TechDivision\Search\Document;
/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

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
	 * @param \TechDivision\Search\Field\FieldInterface $field
	 */
	public function addField(\TechDivision\Search\Field\FieldInterface $field)
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
	 * @return \TechDivision\Search\Field\FieldInterface|null
	 */
	public function getField($fieldName){
		/** @var $field \TechDivision\Search\Field\FieldInterface */
		foreach($this->fields as $field){
			if($field->getName() == $fieldName){
				return $field;
			}
		}
		return null;
	}

	/**
	 * @return array TechDivision\Search\Field\FieldInterface
	 */
	public function getFields()
	{
		return $this->fields;
	}

	/**
	 * @param \TechDivision\Search\Field\FieldInterface $field
	 * @return bool
	 */
	public function removeField(\TechDivision\Search\Field\FieldInterface $field)
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
