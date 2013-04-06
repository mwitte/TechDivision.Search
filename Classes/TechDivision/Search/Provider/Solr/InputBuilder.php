<?php
namespace TechDivision\Search\Provider\Solr;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class InputBuilder
{
	/**
	 * Creates a SolrInputDocument from a valid Document
	 *
	 * @param \TechDivision\Search\Document\Document $document
	 * @return \SolrInputDocument|null
	 */
	public function createSolrInputDocument(\TechDivision\Search\Document\Document $document){
		// creates a new document
		$solrInputDoc = new \SolrInputDocument();
		$solrInputDoc->setBoost($document->getBoost());
		/** @var $field \TechDivision\Search\Field\FieldInterface */
		foreach($document->getFields() as $field){
			$solrInputDoc->addField($field->getName(), $field->getValue(), $field->getBoost());
		}
		if($solrInputDoc->getFieldCount() > 0){
			return $solrInputDoc;
		}
		return null;
	}

	/**
	 * Creates a SolrInputDocument for every given valid Document
	 *
	 * @param array <\TechDivision\Search\Document\Document> $documents
	 * @return array <\SolrInputDocument>
	 */
	public function createSolrInputDocuments(array $documents){
		$solrInputDocuments = array();
		/** @var $document \TechDivision\Search\Document\Document */
		foreach($documents as $document){
			$inputDoc = $this->createSolrInputDocument($document);
			if($inputDoc){
				$solrInputDocuments[] = $inputDoc;
			}
		}
		return $solrInputDocuments;
	}
}
