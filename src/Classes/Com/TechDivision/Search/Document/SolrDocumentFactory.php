<?php

namespace Com\TechDivision\Search\Document;

use \Com\TechDivision\Search\Field\SolrFieldFactory;

class SolrDocumentFactory
{
	/**
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
