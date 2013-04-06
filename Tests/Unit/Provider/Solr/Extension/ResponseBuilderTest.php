<?php

namespace TechDivision\Search\Tests\Unit\Provider\Solr\Extension;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class ResponseBuilderTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @var \TechDivision\Search\Provider\Solr\Extension\ResponseBuilder
	 */
	protected $responseBuilder;

	/**
	 * @var \TechDivision\Search\Document\Document
	 */
	protected $documentMock;

	public function setUp(){
		parent::setUp();
		$this->responseBuilder = new \TechDivision\Search\Provider\Solr\Extension\ResponseBuilder();
		$this->documentMock = $this->getMock("\TechDivision\Search\Document\Document", array("getFields", "getBoost"));
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
		$this->inject($this->responseBuilder, 'documentFactory', new \TechDivision\Search\Provider\Solr\Extension\Factories\DocumentFactory());
		$this->assertSame(array(), $this->responseBuilder->createProviderSearchResponse($solrResponseMock));
	}
}
?>