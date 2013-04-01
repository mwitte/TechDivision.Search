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

class InputBuilderTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @var \Com\TechDivision\Search\Provider\Solr\InputBuilder
	 */
	protected $inputBuilder;

	/**
	 * @var \Com\TechDivision\Search\Document\Document
	 */
	protected $emptyDocumentMock;

	/**
	 * @var \Com\TechDivision\Search\Document\Document
	 */
	protected $filledDocumentMock;

	public function setUp(){
		parent::setUp();
		$this->inputBuilder = new \Com\TechDivision\Search\Provider\Solr\InputBuilder();

		// create an empty document mock
		$this->emptyDocumentMock = $this->getMock("\Com\TechDivision\Search\Document\Document", array("getFields", "getBoost"));
		$this->emptyDocumentMock->expects($this->any())
			->method('getFields')
			->will($this->returnValue(array()));

		// create a filled field mock
		$fieldMock = $this->getMockBuilder("\Com\TechDivision\Search\Field\Field", array("getName", "getValue", "getBoost"))
			->disableOriginalConstructor()
			->getMock();

		$fieldMock->expects($this->any())
			->method('getName')
			->will($this->returnValue("id"));
		$fieldMock->expects($this->any())
			->method('getValue')
			->will($this->returnValue("12345"));
		$fieldMock->expects($this->any())
			->method('getBoost')
			->will($this->returnValue(1.5));

		// create an filled document mock with filled field
		$this->filledDocumentMock = $this->getMock("\Com\TechDivision\Search\Document\Document", array("getFields", "getBoost"));
		$this->filledDocumentMock->expects($this->any())
			->method('getFields')
			->will($this->returnValue(array($fieldMock)));

		$this->filledDocumentMock->expects($this->any())
			->method('getBoost')
			->will($this->returnValue(4.7));
	}

	public function testCreateInputDocWithEmptyDoc(){
		$this->assertSame(null, $this->inputBuilder->createSolrInputDocument($this->emptyDocumentMock));
	}

	/**
	 * @depends testCreateInputDocWithEmptyDoc
	 */
	public function testCreateInputDocWithFilledDoc(){
		$solrInputDoc = new \SolrInputDocument();
		$solrInputDoc->setBoost(4.7);
		$solrInputDoc->addField("id", "12345", 1.5);

		// not equal due randomised property _hashtable_index
		$similarSolrInputDoc = $this->inputBuilder->createSolrInputDocument($this->filledDocumentMock);

		$this->assertEquals($solrInputDoc->getField("id"), $similarSolrInputDoc->getField("id"), 'equal field');
		$this->assertSame($solrInputDoc->getBoost(), $similarSolrInputDoc->getBoost(), "same boost");
		$this->assertSame($solrInputDoc->getFieldCount(), $similarSolrInputDoc->getFieldCount(), "same field count");
	}

	public function testCreateInputDocumentsWithoutDocuments(){
		$this->assertSame(array(), $this->inputBuilder->createSolrInputDocuments(array()));
	}

	/**
	 * @depends testCreateInputDocumentsWithoutDocuments
	 */
	public function testCreateInputDocumentsWithEmptyDocument(){
		$this->assertSame(array(), $this->inputBuilder->createSolrInputDocuments(array($this->emptyDocumentMock)));
	}

	/**
	 * @depends testCreateInputDocumentsWithEmptyDocument
	 */
	public function testCreateInputDocumentsWithFilledDocument(){
		$solrInputDoc = new \SolrInputDocument();
		$solrInputDoc->setBoost(4.7);
		$solrInputDoc->addField("id", "12345", 1.5);

		// not equal due randomised property _hashtable_index
		$similarSolrInputDocs = $this->inputBuilder->createSolrInputDocuments(array($this->filledDocumentMock));

		$this->assertEquals($solrInputDoc->getField("id"), $similarSolrInputDocs[0]->getField("id"), 'equal field');
		$this->assertSame($solrInputDoc->getBoost(), $similarSolrInputDocs[0]->getBoost(), "same boost");
		$this->assertSame($solrInputDoc->getFieldCount(), $similarSolrInputDocs[0]->getFieldCount(), "same field count");
	}
}
?>