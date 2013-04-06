<?php

namespace TechDivision\Search\Provider\Solr\Rest\Builder;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"       *
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
class InputBuilder
{
	/**
	 * @param \TechDivision\Search\Document\Document $document
	 * @return array|null
	 */
	protected function buildInputDocument(\TechDivision\Search\Document\Document $document){
		$inputDoc = array();
		/* @var $field \TechDivision\Search\Field\FieldInterface */
		foreach($document->getFields() as $field){
			$inputDoc[$field->getName()] = $field->getValue();
		}
		if(count($inputDoc)){
			return $inputDoc;
		}
		return null;
	}

	/**
	 * @param \TechDivision\Search\Document\Document $document
	 * @return array|null
	 */
	public function buildUpdateChunk(\TechDivision\Search\Document\Document $document){
		$inputDoc = array();
		$inputDocument = $this->buildInputDocument($document);
		if($inputDocument){
			$inputDoc['doc'] = $this->buildInputDocument($document);
			if($document->getBoost()){
				$inputDoc['boost'] = $document->getBoost();
			}
			return array('add' => $inputDoc);
		}
		return null;
	}

	/**
	 * @param \TechDivision\Search\Field\Field $field
	 * @return array
	 */
	public function buildDeleteChunk(\TechDivision\Search\Field\Field $field){
		$inputDoc = array();
		$inputDoc[$field->getName()] = $field->getValue();
		return array('delete' => $inputDoc);
	}
}
