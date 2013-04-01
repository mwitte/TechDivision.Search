<?php

namespace Com\TechDivision\Search\Tests\Functional\Provider\Solr;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "Com.TechDivision.Search"       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class ResponseBuilderTest extends \TYPO3\Flow\Tests\FunctionalTestCase {

	/**
	 * @var boolean
	 */
	static protected $testablePersistenceEnabled = FALSE;

	/**
	 * @var \Com\TechDivision\Search\Provider\Solr\ResponseBuilder
	 */
	protected $responseBuilder;

	public function setUp(){
		parent::setUp();
		$this->responseBuilder = new \Com\TechDivision\Search\Provider\Solr\ResponseBuilder();
	}

	public function testCreateProviderSearchResponseWithEmptyResponse(){
		$this->assertSame(array(), $this->responseBuilder->createProviderSearchResponse(new \SolrQueryResponse()));
	}
}
?>