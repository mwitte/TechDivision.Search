<?php

namespace TechDivision\Search\Provider\Solr\Rest\Builder;

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
class ResponseBuilder
{
	/**
	 * @var \TechDivision\Search\Provider\Solr\Rest\DocumentFactory
	 * @Flow\Inject
	 */
	protected $documentFactory;

	/**
	 * Creates an array of documents by the given raw response
	 *
	 * @param string $rawResponse
	 * @return array
	 */
	public function createSearchResponse($rawResponse){
		$decodedResponse = json_decode($rawResponse);
		if(!$this->evaluateRawResponse($rawResponse)){
			return array();
		}
		if(isset($decodedResponse->response)){
			if(isset($decodedResponse->response->docs)){
				return $this->documentFactory->createFromResponse($decodedResponse->response->docs);
			}
		}
		return array();
	}

	/**
	 * Evaluates the response
	 *
	 * @param string $rawResponse
	 * @return bool
	 */
	public function evaluateRawResponse($rawResponse){
		$decodedResponse = json_decode($rawResponse);
		if($decodedResponse === NULL){
			return false;
		}
		if(!isset($decodedResponse->responseHeader)){
			return false;
		}
		if(!isset($decodedResponse->responseHeader->status)){
			return false;
		}
		if($decodedResponse->responseHeader->status != 0){
			return false;
		}
		return true;
	}
}
