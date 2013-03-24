<?php

namespace Com\TechDivision\Search\Tests\Unit\Provider\Solr;


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