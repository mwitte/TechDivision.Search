<?php
namespace Com\TechDivision\Search\Provider\Solr;

use TYPO3\Flow\Annotations as Flow;
use \Com\TechDivision\Search\Document\DocumentInterface;

/**
 * This is my great class.
 *
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
	 * no testing needed \SolrClient should covered
	 * @codeCoverageIgnore
	 */
	public function initializeObject() {
		// Setup the solr client if didn't set by constructor
		if(!$this->client){
			// create the client instance
			$this->client = new \SolrClient($this->getClientOptions());
			try{
				$ping = $this->client->ping();
			}catch (\Exception $e){
				$message = "Could not connect to solr server with settings: \n";
				foreach($this->getClientOptions() as $key => $value){
					$message .= $key . ": ". $value . " \n";
				}
				// TODO probably own exceptions?
				throw new \Exception($message);
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
	 * @return array
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
			// TODO do something, own Exceptions?
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
				// TODO configurable?
				$this->client->commit(1, true, true);
				return $response->success();
				// TODO Workaround for codeCoverage?
			}catch (\Exception $e){
				// TODO throw Exception?
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
				// TODO configurable?
				$this->client->commit(1, true, true);
				return $response->success();
				// TODO Workaround for codeCoverage?
			}catch (\Exception $e){
				// TODO throw Exception?
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
			// TODO configurable?
			$this->client->commit(1, true, true);
			return $response->success();
			// TODO Workaround for codeCoverage?
		}catch (\Exception $e){
			// TODO throw Exception?
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
		/**
		 * TODO this configuration should come from setServerSettings() or something
		 */
		return $this->settings['Solr']['ServerData'];
	}
}
