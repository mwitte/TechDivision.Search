<?php

namespace Com\TechDivision\Search\Document;
/**
 * Created by JetBrains PhpStorm.
 * User: wittem
 * Date: 23.03.13
 * Time: 07:52
 * To change this template use File | Settings | File Templates.
 */
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
	 * @return array
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
