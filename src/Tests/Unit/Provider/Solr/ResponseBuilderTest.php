<?php

namespace Com\TechDivision\Search\Tests\Unit\Provider\Solr;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "Com.TechDivision.Search"       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class ResponseBuilderTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @var \Com\TechDivision\Search\Provider\Solr\ResponseBuilder
	 */
	protected $responseBuilder;

	/**
	 * @var \Com\TechDivision\Search\Document\Document
	 */
	protected $documentMock;

	public function setUp(){
		parent::setUp();
		$this->responseBuilder = new \Com\TechDivision\Search\Provider\Solr\ResponseBuilder();
		$this->documentMock = $this->getMock("\Com\TechDivision\Search\Document\Document", array("getFields", "getBoost"));
	}

	public function testCreateProviderSearchResponseWithoutResponse(){
		$solrResponse = new \SolrQueryResponse();
		$this->assertSame(array(), $this->responseBuilder->createProviderSearchResponse($solrResponse));
	}

	/**
	 * @depends testCreateProviderSearchResponseWithoutResponse
	 */
	public function testCreateProviderSearchResponseWithEmptyRawResponse(){
		$rawResponse = array();
		$solrResponseMock = $this->getMock('\SolrQueryResponse', array("getResponse"));
		$solrResponseMock->expects($this->any())
			->method("getResponse")
			->will($this->returnValue($rawResponse));
		$this->assertSame(array(), $this->responseBuilder->createProviderSearchResponse($solrResponseMock));
	}

	/**
	 * @depends testCreateProviderSearchResponseWithEmptyRawResponse
	 */
	public function testCreateProviderSearchResponseWithRawResponse(){
		$rawResponse = array('response');
		$solrResponseMock = $this->getMock('\SolrQueryResponse', array("getResponse"));
		$solrResponseMock->expects($this->any())
			->method("getResponse")
			->will($this->returnValue($rawResponse));
		$this->assertSame(array(), $this->responseBuilder->createProviderSearchResponse($solrResponseMock));
	}
}
?>