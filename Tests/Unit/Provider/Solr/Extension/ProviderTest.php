<?php

namespace TechDivision\Search\Tests\Unit\Provider\Solr\Extension;

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
	 * @var \TechDivision\Search\Provider\Solr\Extension\Provider
	 */
	protected $provider;

	/**
	 * @var \SolrQuery
	 */
	protected $query;

	public function setUp(){
		parent::setUp();
		$this->provider = new \TechDivision\Search\Provider\Solr\Extension\Provider();

		$queryBuilderMock = $this->getMock('\TechDivision\Search\Provider\Solr\Extension\QueryBuilder', array('buildQuery'));
		$solrQueryMock = $this->getMock('\SolrQuery', array());
		$queryBuilderMock->expects($this->any())->method('buildQuery')->will($this->returnValue($solrQueryMock));
		$this->inject($this->provider, 'queryBuilder', $queryBuilderMock);

		$responseBuilder = $this->getMock('\TechDivision\Search\Provider\Solr\Extension\ResponseBuilder', array('createProviderSearchResponse'));
		$responseBuilder->expects($this->any())->method('createProviderSearchResponse')->will($this->returnValue(array()));
		$this->inject($this->provider, 'responseBuilder', $responseBuilder);
	}

	public function testSearchByStringClientException(){
		$clientMock = $this->getMockBuilder('\SolrClient', array('query'))->disableOriginalConstructor()->getMock();
		$clientMock->expects($this->any())->method('query')->will($this->throwException(new \Exception()));
		$this->inject($this->provider, 'client', $clientMock);
		$fields = array(
			new \TechDivision\Search\Field\Field('id', '123')
		);
		$this->assertSame(array(), $this->provider->searchByString('SearchString', $fields));
	}

	/**
	 * @depends testSearchByStringClientException
	 */
	public function testSearchByStringNotCaughtClientException(){
		$clientMock = $this->getMockBuilder('\SolrClient', array('query'))->disableOriginalConstructor()->getMock();
		$clientMock->expects($this->any())->method('query')->will($this->throwException(new \Exception()));
		$this->inject($this->provider, 'client', $clientMock);
		$fields = array(
			new \TechDivision\Search\Field\Field('id', '123')
		);

		$this->inject($this->provider, 'settings', array('Solr' => array('Debug' => true)));
		/**
		 * Use of annotation not good, if there is a exception in test itself this also gets caught,
		 * own try catch is better solution
		 */
		try {
			$this->provider->searchByString('SearchString', $fields);
		}catch (\Exception $e){

		}
		$this->assertEquals(new \Exception(), $e);
	}

	/**
	 * @depends testSearchByStringClientException
	 */
	public function testSearchByStringClientSuccessful(){
		$clientMock = $this->getMockBuilder('\SolrClient', array('query'))->disableOriginalConstructor()->getMock();
		$solrQueryResponseMock = $this->getMock('SolrQueryResponse');
		$clientMock->expects($this->any())->method('query')->will($this->returnValue($solrQueryResponseMock));
		$this->inject($this->provider, 'client', $clientMock);

		$fields = array(
			new \TechDivision\Search\Field\Field('id', '123')
		);
		$this->assertSame(array(), $this->provider->searchByString('SearchString', $fields));
	}

	public function testAddDocumentWithEmptyDocument(){
		$document = new \TechDivision\Search\Document\Document();
		$inputBuilderMock = $this->getMock('\TechDivision\Search\Provider\Solr\Extension\InputBuilder');
		$this->inject($this->provider, 'inputBuilder', $inputBuilderMock);
		$this->assertSame(false, $this->provider->addDocument($document));
	}

	/**
	 * @depends testAddDocumentWithEmptyDocument
	 */
	public function testAddDocumentClientException(){
		$document = new \TechDivision\Search\Document\Document();
		$document->addField(new \TechDivision\Search\Field\Field('id', 'value'));
		$this->inject($this->provider, 'inputBuilder', new \TechDivision\Search\Provider\Solr\Extension\InputBuilder());

		$clientMock = $this->getMockBuilder('\SolrClient', array('addDocument'))->disableOriginalConstructor()->getMock();
		$solrUpdateResponseMock = $this->getMock('\SolrUpdateResponse', array('success'));
		$solrUpdateResponseMock->expects($this->any())->method('success')->will($this->returnValue(true));
		$clientMock->expects($this->any())->method('addDocument')->will($this->throwException(new \Exception()));
		$this->inject($this->provider, 'client', $clientMock);

		$this->assertSame(false, $this->provider->addDocument($document));
	}

	/**
	 * @depends testAddDocumentWithEmptyDocument
	 */
	public function testAddDocumentNotCaugthClientException(){
		$document = new \TechDivision\Search\Document\Document();
		$document->addField(new \TechDivision\Search\Field\Field('id', 'value'));
		$this->inject($this->provider, 'inputBuilder', new \TechDivision\Search\Provider\Solr\Extension\InputBuilder());

		$clientMock = $this->getMockBuilder('\SolrClient', array('addDocument'))->disableOriginalConstructor()->getMock();
		$solrUpdateResponseMock = $this->getMock('\SolrUpdateResponse', array('success'));
		$solrUpdateResponseMock->expects($this->any())->method('success')->will($this->returnValue(true));
		$clientMock->expects($this->any())->method('addDocument')->will($this->throwException(new \Exception()));
		$this->inject($this->provider, 'client', $clientMock);

		$this->inject($this->provider, 'settings', array('Solr' => array('Debug' => true)));
		/**
		 * Use of annotation not good, if there is a exception in test itself this also gets caught,
		 * own try catch is better solution
		 */
		try {
			$this->provider->addDocument($document);
		}catch (\Exception $e){

		}
		$this->assertEquals(new \Exception(), $e);
	}

	/**
	 * @depends testAddDocumentClientException
	 */
	public function testAddDocumentClientSuccessful(){
		$document = new \TechDivision\Search\Document\Document();
		$document->addField(new \TechDivision\Search\Field\Field('id', 'value'));
		$this->inject($this->provider, 'inputBuilder', new \TechDivision\Search\Provider\Solr\Extension\InputBuilder());

		$clientMock = $this->getMockBuilder('\SolrClient', array('addDocument'))->disableOriginalConstructor()->getMock();
		$solrUpdateResponseMock = $this->getMock('\SolrUpdateResponse', array('success'));
		$solrUpdateResponseMock->expects($this->any())->method('success')->will($this->returnValue(true));
		$clientMock->expects($this->any())->method('addDocument')->will($this->returnValue($solrUpdateResponseMock));
		$this->inject($this->provider, 'client', $clientMock);

		$this->assertSame(true, $this->provider->addDocument($document));
	}

	public function testAddDocumentsNoDocuments(){
		$this->inject($this->provider, 'inputBuilder', new \TechDivision\Search\Provider\Solr\Extension\InputBuilder());
		$this->assertSame(false, $this->provider->addDocuments(array()));
	}

	/**
	 * @depends testAddDocumentsNoDocuments
	 */
	public function testAddDocumentsClientException(){
		$this->inject($this->provider, 'inputBuilder', new \TechDivision\Search\Provider\Solr\Extension\InputBuilder());
		$document = new \TechDivision\Search\Document\Document();
		$document->addField(new \TechDivision\Search\Field\Field('id', 'value'));

		$clientMock = $this->getMockBuilder('\SolrClient', array('addDocuments'))->disableOriginalConstructor()->getMock();
		$clientMock->expects($this->any())->method('addDocuments')->will($this->throwException(new \Exception()));
		$this->inject($this->provider, 'client', $clientMock);

		$this->assertSame(false, $this->provider->addDocuments(array($document)));
	}

	/**
	 * @depends testAddDocumentsNoDocuments
	 */
	public function testAddDocumentsNotCaughtClientException(){
		$this->inject($this->provider, 'inputBuilder', new \TechDivision\Search\Provider\Solr\Extension\InputBuilder());
		$document = new \TechDivision\Search\Document\Document();
		$document->addField(new \TechDivision\Search\Field\Field('id', 'value'));

		$clientMock = $this->getMockBuilder('\SolrClient', array('addDocuments'))->disableOriginalConstructor()->getMock();
		$clientMock->expects($this->any())->method('addDocuments')->will($this->throwException(new \Exception()));
		$this->inject($this->provider, 'client', $clientMock);

		$this->inject($this->provider, 'settings', array('Solr' => array('Debug' => true)));
		/**
		 * Use of annotation not good, if there is a exception in test itself this also gets caught,
		 * own try catch is better solution
		 */
		try {
			$this->provider->addDocuments(array($document));
		}catch (\Exception $e){

		}
		$this->assertEquals(new \Exception(), $e);
	}

	/**
	 * @depends testAddDocumentsClientException
	 */
	public function testAddDocumentsSuccessful(){
		$this->inject($this->provider, 'inputBuilder', new \TechDivision\Search\Provider\Solr\Extension\InputBuilder());
		$document = new \TechDivision\Search\Document\Document();
		$document->addField(new \TechDivision\Search\Field\Field('id', 'value'));

		$clientMock = $this->getMockBuilder('\SolrClient', array('addDocuments'))->disableOriginalConstructor()->getMock();
		$solrUpdateResponseMock = $this->getMock('\SolrUpdateResponse', array('success'));
		$solrUpdateResponseMock->expects($this->any())->method('success')->will($this->returnValue(true));
		$clientMock->expects($this->any())->method('addDocuments')->will($this->returnValue($solrUpdateResponseMock));
		$this->inject($this->provider, 'client', $clientMock);

		$this->assertSame(true, $this->provider->addDocuments(array($document)));
	}


	public function testRemoveDocumentByFieldClientException(){
		$clientMock = $this->getMockBuilder('\SolrClient', array('deleteById'))->disableOriginalConstructor()->getMock();
		$clientMock->expects($this->any())->method('deleteById')->will($this->throwException(new \Exception()));
		$this->inject($this->provider, 'client', $clientMock);
		$this->assertSame(false, $this->provider->removeDocumentByField(new \TechDivision\Search\Field\Field('id', 123)));
	}

	/**
	 * @depends testRemoveDocumentByFieldClientException
	 */
	public function testRemoveDocumentByFieldNotCaughtClientException(){
		$clientMock = $this->getMockBuilder('\SolrClient', array('deleteById'))->disableOriginalConstructor()->getMock();
		$clientMock->expects($this->any())->method('deleteById')->will($this->throwException(new \Exception()));
		$this->inject($this->provider, 'client', $clientMock);

		$this->inject($this->provider, 'settings', array('Solr' => array('Debug' => true)));
		/**
		 * Use of annotation not good, if there is a exception in test itself this also gets caught,
		 * own try catch is better solution
		 */
		try {
			$this->provider->removeDocumentByField(new \TechDivision\Search\Field\Field('id', 123));
		}catch (\Exception $e){

		}
		$this->assertEquals(new \Exception(), $e);
	}

	/**
	 * @depends testRemoveDocumentByFieldClientException
	 */
	public function testRemoveDocumentByFieldSuccessful(){
		$clientMock = $this->getMockBuilder('\SolrClient', array('deleteById'))->disableOriginalConstructor()->getMock();
		$solrUpdateResponseMock = $this->getMock('\SolrUpdateResponse', array('success'));
		$solrUpdateResponseMock->expects($this->any())->method('success')->will($this->returnValue(true));
		$clientMock->expects($this->any())->method('deleteById')->will($this->returnValue($solrUpdateResponseMock));
		$this->inject($this->provider, 'client', $clientMock);
		$this->assertSame(true, $this->provider->removeDocumentByField(new \TechDivision\Search\Field\Field('id', 123)));
	}

	public function testProviderNeedsInputDocuments(){
		$this->assertSame(true, $this->provider->providerNeedsInputDocuments());
	}
}
?>