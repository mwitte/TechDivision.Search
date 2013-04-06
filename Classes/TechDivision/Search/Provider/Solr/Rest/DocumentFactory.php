<?php

namespace TechDivision\Search\Provider\Solr\Rest;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class DocumentFactory
{
	/**
	 * Creates an array of Documents by an response which implements ArrayAccess
	 *
	 * @param array $rawDocs
	 */
	public function createFromResponse(array $rawDocs){
		$documents = array();
		foreach($rawDocs as $rawDoc){
			$document = new \TechDivision\Search\Document\Document();
			foreach($rawDoc as $fieldName => $fieldValue){
				$field = new \TechDivision\Search\Field\Field($fieldName, $fieldValue);
				$document->addField($field);
			}
			if($document->getFieldCount() > 0){
				$documents[] = $document;
			}
		}
		return $documents;
	}
}
