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
class UrlBuilder
{

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
	 * Builds a query string by given token and Fields
	 *
	 * @param string $searchToken
	 * @param array $fields
	 * @return string
	 */
	public function buildSearchUrl($searchToken, array $fields){
		$query = '';
		$iterator = 0;
		$searchWords = explode(" ", trim($searchToken));
		/** @var $field \TechDivision\Search\Field\Field */
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
		if(strlen($query)){
			return
				$this->settings['Solr']['ServerData']['protocol'] .
				'://' .
				$this->settings['Solr']['ServerData']['hostname'] .
				':' .
				$this->settings['Solr']['ServerData']['port'] .
				'/solr/select/?indent=off&wt=json&q=' .
				urlencode($query);
		}
		return null;
	}

	public function buildUpdateUrl(){
		return
			$this->settings['Solr']['ServerData']['protocol'] .
			'://' .
			$this->settings['Solr']['ServerData']['hostname'] .
			':' .
			$this->settings['Solr']['ServerData']['port'] .
			'/solr/update/json?commit=true&wt=json';
	}
}
