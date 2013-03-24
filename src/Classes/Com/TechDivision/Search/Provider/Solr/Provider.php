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
	protected $solrClient;

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
	 * Inject the settings
	 *
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
		// setup the solr client after the settings got injected
		$this->setUpClient();
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
			$queryResponse = $this->solrClient->query(
				$query
			);
			return $this->responseBuilder->createProviderSearchResponse($queryResponse);
		}catch (\Exception $e){
			// TODO do something, own Exceptions?
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
				$response = $this->solrClient->addDocument($inputDocument, FALSE, 0);
				// TODO configurable?
				$this->solrClient->commit(1, true, true);
				return $response->success();
				// TODO Workaround for codeCoverage?
				// @codeCoverageIgnoreStart
			}catch (\Exception $e){
				// TODO throw Exception?
			}
		}
		return false;
		// @codeCoverageIgnoreEnd
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
				$response = $this->solrClient->addDocuments($inputDocuments, FALSE, 0);
				// TODO configurable?
				$this->solrClient->commit(1, true, true);
				return $response->success();
				// TODO Workaround for codeCoverage?
				// @codeCoverageIgnoreStart
			}catch (\Exception $e){
				// TODO throw Exception?
			}
		}
		return false;
		// @codeCoverageIgnoreEnd
	}

	/**
	 * @param \Com\TechDivision\Search\Document\DocumentInterface $document
	 * @return bool
	 */
	public function updateDocument(DocumentInterface $document)
	{
		// TODO: Implement updateDocument() method.
		return $this->addDocument($document);
	}


	/**
	 * @param string $identifier
	 * @return bool
	 */
	public function removeDocumentByIdentifier($identifier)
	{
		try{
			$response = $this->solrClient->deleteById($identifier);
			// TODO configurable?
			$this->solrClient->commit(1, true, true);
			return $response->success();
			// TODO Workaround for codeCoverage?
			// @codeCoverageIgnoreStart
		}catch (\Exception $e){
			// TODO throw Exception?
		}
		return false;
		// @codeCoverageIgnoreEnd
	}

	/**
	 * @return bool
	 */
	public function providerNeedsInputDocuments()
	{
		return TRUE;
	}

	protected function setUpClient(){
		if(!$this->solrClient){
			// create the client instance
			$this->solrClient = new \SolrClient($this->getClientOptions());
			try{
				$ping = $this->solrClient->ping();
			}catch (\Exception $e){
				// TODO Workaround for codeCoverage?
				// @codeCoverageIgnoreStart
				$message = "Could not connect to solr server with settings: \n";
				foreach($this->getClientOptions() as $key => $value){
					$message .= $key . ": ". $value . " \n";
				}
				// TODO probably own exceptions?
				throw new \Exception($message);
				// @codeCoverageIgnoreEnd
			}
		}
	}
	/**
	 * @return mixed
	 */
	protected function getClientOptions(){
		/**
		 * TODO this configuration should come from setServerSettings() or something
		 */
		return $this->settings['Solr']['ServerData'];
	}

	/**
	 * @param int $maxSegments
	 * @param bool $waitFlush
	 * @param bool $waitSearcher
	 */
	public function commit($maxSegments = 1, $waitFlush = true, $waitSearcher = true)
	{
		$response = $this->solrClient->commit($maxSegments, $waitFlush, $waitSearcher);
		return $response->success();
	}
}
