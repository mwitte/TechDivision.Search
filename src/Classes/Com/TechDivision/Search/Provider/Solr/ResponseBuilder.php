<?php
namespace Com\TechDivision\Search\Provider\Solr;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "Com.TechDivision.Search"       *
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
class ResponseBuilder
{
	/**
	 * Creates an array of documents by the given \SolrQueryResponse
	 *
	 * @param \SolrQueryResponse $rawResponse
	 * @return array
	 */
	public function createProviderSearchResponse(\SolrQueryResponse $rawResponse){
		// no singletons because of UnitTesting
		$documentFactory = new \Com\TechDivision\Search\Document\SolrDocumentFactory();
		$fieldFactory = new \Com\TechDivision\Search\Field\SolrFieldFactory();
		$response = $rawResponse->getResponse();
		if($response){
			return $documentFactory->createFromResponse($response, $fieldFactory);
		}
		return array();
	}
}
