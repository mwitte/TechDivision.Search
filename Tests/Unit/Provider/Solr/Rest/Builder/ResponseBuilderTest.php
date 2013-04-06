<?php

namespace TechDivision\Search\Tests\Unit\Provider\Solr\Rest\Builder;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class ResponseBuilderTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @var \TechDivision\Search\Provider\Solr\Rest\Builder\ResponseBuilder
	 */
	protected $responseBuilder;

	public function setUp(){
		parent::setUp();
		$this->responseBuilder = new \TechDivision\Search\Provider\Solr\Rest\Builder\ResponseBuilder();
	}

	public function testEvaluateRawResponseNotJson(){
		$this->assertSame(false, $this->responseBuilder->evaluateRawResponse('string'));
	}

	/**
	 * @depends testEvaluateRawResponseNotJson
	 */
	public function testEvaluateRawResponseWithoutHeader(){
		$response = json_encode(array());
		$this->assertSame(false, $this->responseBuilder->evaluateRawResponse($response));
	}

	/**
	 * @depends testEvaluateRawResponseNotJson
	 */
	public function testEvaluateRawResponseWithoutStatus(){
		$response = new \stdClass();
		$response->responseHeader = '';
		$response = json_encode($response);
		$this->assertSame(false, $this->responseBuilder->evaluateRawResponse($response));
	}

	/**
	 * @depends testEvaluateRawResponseWithoutStatus
	 */
	public function testEvaluateRawResponseWithWrongStatus(){
		$header = new \stdClass();
		$header->status = 1;
		$response = new \stdClass();
		$response->responseHeader = $header;
		$response = json_encode($response);
		$this->assertSame(false, $this->responseBuilder->evaluateRawResponse($response));
	}

	/**
	 * @depends testEvaluateRawResponseWithWrongStatus
	 */
	public function testEvaluateRawResponseSuccess(){
		$header = new \stdClass();
		$header->status = 0;
		$response = new \stdClass();
		$response->responseHeader = $header;
		$response = json_encode($response);
		$this->assertSame(true, $this->responseBuilder->evaluateRawResponse($response));
	}

	/**
	 * @depends testEvaluateRawResponseSuccess
	 */
	public function testCreateSearchResponseWithWrongResponse(){
		$this->assertSame(array(), $this->responseBuilder->createSearchResponse(''));
	}

	/**
	 * @depends testCreateSearchResponseWithWrongResponse
	 */
	public function testCreateSearchResponseWithoutResponse(){
		$header = new \stdClass();
		$header->status = 0;
		$response = new \stdClass();
		$response->responseHeader = $header;
		$response = json_encode($response);
		$this->assertSame(array(), $this->responseBuilder->createSearchResponse($response));
	}

	/**
	 * @depends testCreateSearchResponseWithoutResponse
	 */
	public function testCreateSearchResponseWithoutDocs(){
		$header = new \stdClass();
		$header->status = 0;
		$response = new \stdClass();
		$response->responseHeader = $header;
		$response->response = '';
		$response = json_encode($response);
		$this->assertSame(array(), $this->responseBuilder->createSearchResponse($response));
	}

	/**
	 * @depends testCreateSearchResponseWithoutResponse
	 */
	public function testCreateSearchResponseWitDocs(){
		$header = new \stdClass();
		$header->status = 0;
		$responseProperty = new \stdClass();
		$responseProperty->docs = array();
		$response = new \stdClass();
		$response->responseHeader = $header;
		$response->response = $responseProperty;
		$response = json_encode($response);

		$documentFactoryMock = $this->getMock('\TechDivision\Search\Provider\Solr\Rest\Factories\DocumentFactory', array('createFromResponse'));
		$documentFactoryMock->expects($this->any())->method('createFromResponse')->will($this->returnValue(array()));
		$this->inject($this->responseBuilder, 'documentFactory', $documentFactoryMock);

		$this->assertSame(array(), $this->responseBuilder->createSearchResponse($response));
	}
}
?>