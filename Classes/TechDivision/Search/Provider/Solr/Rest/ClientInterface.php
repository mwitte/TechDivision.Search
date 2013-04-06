<?php

namespace TechDivision\Search\Provider\Solr\Rest;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

use \TechDivision\Search\Document\DocumentInterface;

interface ClientInterface
{
	/**
	 * @param string $url
	 * @return string
	 */
	public function get($url);

	/**
	 * @param string $url
	 * @param array $postParams
	 * @return string
	 */
	public function post($url, array $postParams);
}
