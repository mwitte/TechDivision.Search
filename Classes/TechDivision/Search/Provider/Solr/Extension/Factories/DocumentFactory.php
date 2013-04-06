<?php

namespace TechDivision\Search\Provider\Solr\Extension\Factories;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class DocumentFactory
{

	/**
	 * @var \TechDivision\Search\Provider\Solr\Extension\Factories\FieldFactory
	 * @Flow\Inject
	 */
	protected $fieldFactory;

	/**
	 * Creates an array of Documents by an response which implements ArrayAccess
	 *
	 * @param \ArrayAccess $response
	 */
	public function createFromResponse($response){
		$documents = array();

		// only if the keys are set
		if(array_key_exists('response', $response) && array_key_exists('docs', $response['response'])){
			// create one document for each responded
			foreach($response['response']['docs'] as $responseDocument){
				$solrDocument = new \TechDivision\Search\Document\Document();
				// create and set the fields to the document
				$solrDocument->setFields($this->fieldFactory->createFieldsWith($responseDocument));
				$documents[] = $solrDocument;
			}
		}
		return $documents;
	}
}
