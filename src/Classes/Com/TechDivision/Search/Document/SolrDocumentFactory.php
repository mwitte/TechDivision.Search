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

use \Com\TechDivision\Search\Field\SolrFieldFactory;

class SolrDocumentFactory
{
	/**
	 * Creates an array of Documents by an response which implements ArrayAccess
	 *
	 * @param \ArrayAccess $response
	 * @param \Com\TechDivision\Search\Field\SolrFieldFactory $solrFieldFactory
	 */
	public function createFromResponse($response, \Com\TechDivision\Search\Field\SolrFieldFactory $solrFieldFactory){
		$documents = array();

		// only if the keys are set
		if(array_key_exists('response', $response) && array_key_exists('docs', $response['response'])){
			// create one document for each responded
			foreach($response['response']['docs'] as $responseDocument){
				$solrDocument = new Document();
				// create and set the fields to the document
				$solrDocument->setFields($solrFieldFactory->createFieldsWith($responseDocument));
				$documents[] = $solrDocument;
			}
		}
		return $documents;
	}
}
