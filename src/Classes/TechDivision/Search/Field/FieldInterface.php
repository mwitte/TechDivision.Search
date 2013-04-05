<?php

namespace TechDivision\Search\Field;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

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
