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
use \Com\TechDivision\Search\Document\DocumentInterface;

/**
 * @Flow\Scope("singleton")
 */
class Provider implements \Com\TechDivision\Search\Provider\ProviderInterface
{
	/**
	 * @var \SolrClient
	 */
	protected $client;

	/**
	 * @var array
	 */
	protected $settings;

	/**
	 * @var \Com\TechDivision\Search\Provider\Solr\QueryBuilder
	 * @FLOW\Inject
	 */
	protected $queryBuilder;

	/**
	 * @var \Com\TechDivision\Search\Provider\Solr\ResponseBuilder
	 * @FLOW\Inject
	 */
	protected $responseBuilder;

	/**
	 * @var \Com\TechDivision\Search\Provider\Solr\InputBuilder
	 * @FLOW\Inject
	 */
	protected $inputBuilder;

	/**
	 * Gets called after instantiation and dependency injection
	 *
	 * @return void
	 *
	 * no testing needed \SolrClient should be covered
	 * @codeCoverageIgnore
	 */
	public function initializeObject() {
		// Setup the solr client if didn't set by constructor
		if(!$this->client){
			// create the client instance
			$this->client = new \SolrClient($this->getClientOptions());
			if($this->settings['Solr']['Debug']){
				try{
					$ping = $this->client->ping();
				}catch (\Exception $e){
					$message = "Could not connect to solr server with settings: \n";
					foreach($this->getClientOptions() as $key => $value){
						$message .= $key . ": ". $value . " \n";
					}
					throw new \Exception($message);
				}
			}
		}
	}
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
	 * @return array <\Com\TechDivision\Search\Document\DocumentInterface>
	 */
	public function searchByString($searchString, array $fields, $rows = 50, $offset = 0)
	{
		try{
			$query = $this->queryBuilder->buildQuery($searchString, $fields, $rows, $offset);
			// get the response
			$queryResponse = $this->client->query(
				$query
			);
			return $this->responseBuilder->createProviderSearchResponse($queryResponse);
		}catch (\Exception $e){
			if($this->settings['Solr']['Debug']){
				throw $e;
			}
		}
		return array();
	}

	/**
	 * @param \Com\TechDivision\Search\Document\DocumentInterface $document
	 * @return bool
	 */
	public function addDocument(DocumentInterface $document)
	{
		$inputDocument = $this->inputBuilder->createSolrInputDocument($document);
		if($inputDocument){
			try{
				$response = $this->client->addDocument($inputDocument, FALSE, 0);
				$this->client->commit(
					$this->settings['Solr']['Commit']['maxSegments'],
					$this->settings['Solr']['Commit']['waitFlush'],
					$this->settings['Solr']['Commit']['waitSearcher']);
				return $response->success();
			}catch (\Exception $e){
				if($this->settings['Solr']['Debug']){
					throw $e;
				}
			}
		}
		return false;
	}

	/**
	 * @param array $documents
	 * @return int
	 */
	public function addDocuments(array $documents)
	{
		$inputDocuments = $this->inputBuilder->createSolrInputDocuments($documents);
		if($inputDocuments){
			try{
				$response = $this->client->addDocuments($inputDocuments, FALSE, 0);
				$this->client->commit(
					$this->settings['Solr']['Commit']['maxSegments'],
					$this->settings['Solr']['Commit']['waitFlush'],
					$this->settings['Solr']['Commit']['waitSearcher']);
				return $response->success();
			}catch (\Exception $e){
				if($this->settings['Solr']['Debug']){
					throw $e;
				}
			}
		}
		return false;
	}


	/**
	 * @param string $identifier
	 * @return bool
	 */
	public function removeDocumentByIdentifier($identifier)
	{
		try{
			$response = $this->client->deleteById($identifier);
			$this->client->commit(
				$this->settings['Solr']['Commit']['maxSegments'],
				$this->settings['Solr']['Commit']['waitFlush'],
				$this->settings['Solr']['Commit']['waitSearcher']);
			return $response->success();
		}catch (\Exception $e){
			if($this->settings['Solr']['Debug']){
				throw $e;
			}
		}
		return false;
	}

	/**
	 * @return bool
	 */
	public function providerNeedsInputDocuments()
	{
		return TRUE;
	}

	/**
	 * @return mixed
	 *
	 * no testing needed, flow functionality
	 * @codeCoverageIgnore
	 */
	protected function getClientOptions(){
		return $this->settings['Solr']['ServerData'];
	}
}
