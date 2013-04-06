<?php
namespace TechDivision\Search\Provider\Solr\Rest;

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
use \TechDivision\Search\Document\DocumentInterface;

/**
 * @Flow\Scope("singleton")
 */
class Provider implements \TechDivision\Search\Provider\ProviderInterface
{

	/**
	 * @var \TechDivision\Search\Provider\Solr\Rest\ClientInterface
	 * @Flow\Inject
	 */
	protected $client;

	/**
	 * @var \TechDivision\Search\Provider\Solr\Rest\Builder\UrlBuilder
	 * @Flow\Inject
	 */
	protected $urlBuilder;

	/**
	 * @var \TechDivision\Search\Provider\Solr\Rest\Builder\ResponseBuilder
	 * @Flow\Inject
	 */
	protected $responseBuilder;

	/**
	 * @var \TechDivision\Search\Provider\Solr\Rest\Builder\InputBuilder
	 * @Flow\Inject
	 */
	protected $inputBuilder;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * Inject the settings
	 *
	 * @param array $settings
	 * @return void
	 *
	 * no testing needed, flow functionality
	 * @codeCoverageIgnore
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * @param string $searchString
	 * @param array $fields
	 * @param int $rows
	 * @param int $offset
	 * @return array <\TechDivision\Search\Document\DocumentInterface>
	 */
	public function searchByString($searchString, array $fields, $rows = 50, $offset = 0)
	{
		$response = $this->client->get($this->urlBuilder->buildSearchUrl($searchString, $fields));
		return $this->responseBuilder->createSearchResponse($response);
	}

	/**
	 * @param \TechDivision\Search\Document\DocumentInterface $document
	 * @return bool
	 */
	public function addDocument(DocumentInterface $document)
	{
		$inputChunk = $this->inputBuilder->buildUpdateChunk($document);
		$response = $this->client->post($this->urlBuilder->buildUpdateUrl(), array(json_encode($inputChunk)));
		return $this->responseBuilder->evaluateRawResponse($response);
	}

	/**
	 * @param array $documents
	 * @return int
	 */
	public function addDocuments(array $documents)
	{
		$count = 0;
		foreach($documents as $document){
			if($this->addDocument($document)){
				$count++;
			}
		}
		return $count;
	}


	/**
	 * @param \TechDivision\Search\Field\Field $field
	 * @return bool
	 */
	public function removeDocumentByField(\TechDivision\Search\Field\Field $field)
	{
		$inputChunk = $this->inputBuilder->buildDeleteChunk($field);
		$response = $this->client->post($this->urlBuilder->buildUpdateUrl(), array(json_encode($inputChunk)));
		return $this->responseBuilder->evaluateRawResponse($response);
	}

	/**
	 * @return bool
	 */
	public function providerNeedsInputDocuments()
	{
		return TRUE;
	}
}
