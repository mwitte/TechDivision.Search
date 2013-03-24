<?php
namespace Com\TechDivision\Search\Provider\Solr;

use TYPO3\Flow\Annotations as Flow;
/**
 * This is my great class.
 *
 * @Flow\Scope("singleton")
 */
class ResponseBuilder
{
	public function createProviderSearchResponse(\SolrQueryResponse $rawResponse){
		// no singletons because of UnitTesting
		$documentFactory = new \Com\TechDivision\Search\Document\SolrDocumentFactory();
		$fieldFactory = new \Com\TechDivision\Search\Field\SolrFieldFactory();
		$response = $rawResponse->getResponse();
		if($response){
			//var_dump($response);
			//$documentFactory->createFromResponse($response, $fieldFactory);
			return $documentFactory->createFromResponse($response, $fieldFactory);
		}
		return array();
	}
}
