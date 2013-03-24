<?php
namespace Com\TechDivision\Search\Provider\Solr;

class InputBuilder
{
	/**
	 * @param \Com\TechDivision\Search\Document\Document $document
	 * @return \SolrInputDocument|null
	 */
	public function createSolrInputDocument(\Com\TechDivision\Search\Document\Document $document){
		// creates a new document
		$solrInputDoc = new \SolrInputDocument();
		$solrInputDoc->setBoost($document->getBoost());
		/** @var $field \Com\TechDivision\Search\Field\FieldInterface */
		foreach($document->getFields() as $field){
			$solrInputDoc->addField($field->getName(), $field->getValue(), $field->getBoost());
		}
		if($solrInputDoc->getFieldCount() > 0){
			return $solrInputDoc;
		}
		return null;
	}

	public function createSolrInputDocuments(array $documents){
		$solrInputDocuments = array();
		/** @var $document \Com\TechDivision\Search\Document\Document */
		foreach($documents as $document){
			$inputDoc = $this->createSolrInputDocument($document);
			if($inputDoc){
				$solrInputDocuments[] = $inputDoc;
			}
		}
		return $solrInputDocuments;
	}
}
