<?php

namespace Com\TechDivision\Search\Field;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "Com.TechDivision.Search"       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class SolrFieldFactory
{
	/**
	 * Creates an array of Fields by given array of Documents
	 *
	 * @param array $documentArray
	 * @return array contains
	 */
	public function createFieldsWith($documentArray){
		$fields = array();
		// create one field for each field in the response
		foreach($documentArray as $fieldName => $fieldValue){
			$fields[] = new Field($fieldName, $fieldValue);
		}
		return $fields;
	}
}
