<?php

namespace TechDivision\Search\Tests\Unit\Provider\Solr\Rest;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class ProviderTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @var \TechDivision\Search\Provider\Solr\Rest\Provider
	 */
	protected $provider;

	public function setUp(){
		parent::setUp();
		$this->provider = new \TechDivision\Search\Provider\Solr\Rest\Provider();
		$clientMock = $this->getMock('\TechDivision\Search\Provider\Solr\Rest\CurlClient', array('get'));
		$this->inject($this->provider, 'client', $clientMock);

		$urlBuilderMock = $this->getMock('\TechDivision\Search\Provider\Solr\Rest\Builder\UrlBuilder', array('buildSearchUrl', 'buildUpdateUrl'));
		$urlBuilderMock->expects($this->any())->method('buildSearchUrl')->will($this->returnValue(''));
		$urlBuilderMock->expects($this->any())->method('buildUpdateUrl')->will($this->returnValue(''));
		$this->inject($this->provider, 'urlBuilder', $urlBuilderMock);

		$inputBuilderMock = $this->getMock('\TechDivision\Search\Provider\Solr\Rest\Builder\InputBuilder', array('buildUpdateChunk'));
		$inputBuilderMock->expects($this->any())->method('buildUpdateChunk')->will($this->returnValue(array()));
		$this->inject($this->provider, 'inputBuilder', $inputBuilderMock);

		$responseBuilderMock  = $this->getMock('\TechDivision\Search\Provider\Solr\Rest\Builder\ResponseBuilder', array('evaluateRawResponse', 'createSearchResponse'));
		$responseBuilderMock->expects($this->any())->method('evaluateRawResponse')->will($this->returnValue(true));
		$responseBuilderMock->expects($this->any())->method('createSearchResponse')->will($this->returnValue(array()));
		$this->inject($this->provider, 'responseBuilder', $responseBuilderMock);
	}

	public function testProviderNeedsInputDocuments(){
		$this->assertSame(true, $this->provider->providerNeedsInputDocuments());
	}

	public function testSearchByString(){
		$this->assertSame(array(), $this->provider->searchByString('', array()));
	}

	public function testAddDocument(){
		$this->assertSame(true, $this->provider->addDocument(new \TechDivision\Search\Document\Document()));
	}

	/**
	 * @depends testAddDocument
	 */
	public function testAddDocuments(){
		$this->assertSame(1, $this->provider->addDocuments(array(new \TechDivision\Search\Document\Document())));
	}

	public function testRemoveDocumentByField(){
		$this->assertSame(true, $this->provider->removeDocumentByField(new \TechDivision\Search\Field\Field('id', 1234)));
	}
}
?>