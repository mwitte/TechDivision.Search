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
/**
 * @Flow\Scope("singleton")
 */
class QueryBuilder
{
	/**
	 * Builds a \SolrQuery by given token and Fields
	 *
	 * @param string $searchToken
	 * @param array $fields
	 * @param int $rows
	 * @param int $offset
	 * @return \SolrQuery
	 */
	public function buildQuery($searchToken, array $fields, $rows = 50, $offset = 0){
		$query = new \SolrQuery();
		$queryString = $this->buildSearchString($searchToken, $fields);
		if(strlen($queryString)){
			$query->setQuery($queryString);
		}

		$query->setStart($offset);
		$query->setRows($rows);
		// add the fields to the requested data
		/** @var $field \Com\TechDivision\Search\Field\Field */
		foreach($fields as $field){
			$query->addField($field->getName());
		}
		return $query;
	}

	/**
	 * Builds the search query string for a \SolrQuery
	 *
	 * @param $searchString
	 * @param array $fields
	 * @return string
	 */
	protected function buildSearchString($searchString, array $fields){
		$query = '';
		$iterator = 0;
		$searchWords = explode(" ", trim($searchString));
		/** @var $field \Com\TechDivision\Search\Field\Field */
		foreach($fields as $field){
			foreach($searchWords as $searchWord){
				// after first iteration
				if($iterator > 0){
					// TODO configurable!
					// concatenate statements
					$query .= ' OR ';
				}
				$iterator++;
				// build statement and concatenate
				$query .= $field->getName() . ':"'. $searchWord . '"';
			}
		}
		return $query;
	}
}
