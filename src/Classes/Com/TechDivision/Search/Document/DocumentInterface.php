<?php

namespace Com\TechDivision\Search\Document;
/*                                                                        *
 * This belongs to the TYPO3 Flow package "Com.TechDivision.Search"       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */
interface DocumentInterface
{
	/**
	 * @param \Com\TechDivision\Search\Field\FieldInterface $field
	 */
	public function addField(\Com\TechDivision\Search\Field\FieldInterface $field);

	/**
	 * @param array $fields
	 */
	public function setFields(array $fields);

	/**
	 * @param string $fieldName
	 * @return \Com\TechDivision\Search\Field\FieldInterface|null
	 */
	public function getField($fieldName);

	/**
	 * @return array with \Com\TechDivision\Search\Field\FieldInterface
	 */
	public function getFields();

	/**
	 * @param \Com\TechDivision\Search\Field\FieldInterface $field
	 * @return bool
	 */
	public function removeField(\Com\TechDivision\Search\Field\FieldInterface $field);

	/**
	 * @return int
	 */
	public function getFieldCount();

	/**
	 * @param float $value
	 */
	public function setBoost($value);

	/**
	 * @return float
	 */
	public function getBoost();
}
