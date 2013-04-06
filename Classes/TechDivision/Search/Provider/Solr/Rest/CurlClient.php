<?php
namespace TechDivision\Search\Provider\Solr\Rest;

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
 *
 * TODO should probably covered by tests
 * few logic
 * @codeCoverageIgnore
 */
class CurlClient implements \TechDivision\Search\Provider\Solr\Rest\ClientInterface
{
	/**
	 * @param string $url
	 * @return string
	 */
	public function get($url)
	{
		return $this->performRequest($url);
	}

	/**
	 * @param string $url
	 * @param array $postParams
	 * @return string
	 */
	public function post($url, array $postParams)
	{
		// concatenate params as as one string
		$postToken = '';
		foreach($postParams as $postParam){
			$postToken .= (string) $postParam;
		}
		return $this->performRequest($url, 'POST', $postToken);
	}

	/**
	 * @param $url
	 * @param string $method
	 * @param string $postToken
	 * @return string
	 */
	protected function performRequest($url, $method = 'GET', $postToken = ''){
		// initialize curl
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
		if($method === 'POST'){
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $postToken);
		}
		// enable return transfer of response
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		// execute
		$response = curl_exec($curl);
		if($response){
			return $response;
		}
		return '';
	}
}
