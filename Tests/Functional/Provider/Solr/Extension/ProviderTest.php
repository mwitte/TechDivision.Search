<?php

namespace TechDivision\Search\Tests\Functional\Provider\Solr\Extension;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class ProviderTest extends \TYPO3\Flow\Tests\FunctionalTestCase {

	/**
	 * @var boolean
	 */
	static protected $testablePersistenceEnabled = FALSE;

	/**
	 * @var \TechDivision\Search\Provider\Solr\Extension\Provider
	 */
	protected $provider;

	/**
	 * @var \TechDivision\Search\Document\Document
	 */
	protected $filledDocument;

	/**
	 * @var \TechDivision\Search\Field\Field
	 */
	protected $fieldIdentifier;

	/**
	 * @var \TechDivision\Search\Field\Field
	 */
	protected $fieldSubject;

	public function setUp(){
		parent::setUp();
		$this->provider = $this->objectManager->get('\TechDivision\Search\Provider\Solr\Extension\Provider');
		$this->filledDocument = new \TechDivision\Search\Document\Document();
		$this->fieldIdentifier = new \TechDivision\Search\Field\Field('id', '12345');
		$this->fieldSubject = new \TechDivision\Search\Field\Field('subject', 'awesome');
		$this->filledDocument->addField($this->fieldIdentifier);
		$this->filledDocument->addField($this->fieldSubject);
	}

	private function getFilledDocumentWithField($fieldName, $fieldValue){
		$filledDocument = new \TechDivision\Search\Document\Document();
		$field = new \TechDivision\Search\Field\Field($fieldName, $fieldValue);
		$filledDocument->addField($field);
		return $filledDocument;
	}

	public function testAddDocument(){
		$this->assertSame(true, $this->provider->addDocument($this->filledDocument));
	}

	public function testAddDocumentClientException(){
		$clientMock = $this->getMockBuilder('\SolrClient', array('addDocument'))->disableOriginalConstructor()->getMock();
		$clientMock->expects($this->any())->method('addDocument')->will($this->throwException(new \Exception()));
		$this->inject($this->provider, 'client', $clientMock);
		$this->assertSame(false, $this->provider->addDocument($this->filledDocument));
	}

	public function testAddDocumentNotCaughtClientException(){
		$clientMock = $this->getMockBuilder('\SolrClient', array('addDocument'))->disableOriginalConstructor()->getMock();
		$clientMock->expects($this->any())->method('addDocument')->will($this->throwException(new \Exception()));
		$this->inject($this->provider, 'client', $clientMock);

		$this->inject($this->provider, 'settings', array('Solr' => array('Debug' => true)));
		/**
		 * Use of annotation not good, if there is a exception in test itself this also gets caught,
		 * own try catch is better solution
		 */
		try {
			$this->provider->addDocument($this->filledDocument);
		}catch (\Exception $e){

		}
		$this->assertEquals(new \Exception(), $e);
	}

	public function testProviderNeedsInputDocuments(){
		$this->assertSame(true, $this->provider->providerNeedsInputDocuments());
	}

	/**
	 * @depends testAddDocument
	 */
	public function testSearchByStringWithoutResult(){
		$this->assertEquals(array(), $this->provider->searchByString('uniqueSe4rchT0kenWhichNotExists', array($this->fieldIdentifier, $this->fieldSubject)));
	}

	/**
	 * @depends testAddDocument
	 */
	public function testSearchByStringClientException(){
		$clientMock = $this->getMockBuilder('\SolrClient', array('query'))->disableOriginalConstructor()->getMock();
		$clientMock->expects($this->any())->method('query')->will($this->throwException(new \Exception()));
		$this->inject($this->provider, 'client', $clientMock);
		$this->inject($this->provider, 'settings', array('Solr' => array('Debug' => true)));
		/**
		 * Use of annotation not good, if there is a exception in test itself this also gets caught,
		 * own try catch is better solution
		 */
		try {
			$this->provider->searchByString('uniqueSe4rchT0kenWhichNotExists', array($this->fieldIdentifier, $this->fieldSubject));
		}catch (\Exception $e){

		}
		$this->assertEquals(new \Exception(), $e);
	}

	/**
	 * @depends testAddDocument
	 */
	public function testSearchByStringAddedDocument(){
		$this->assertEquals(array($this->filledDocument), $this->provider->searchByString('12345', array($this->fieldIdentifier, $this->fieldSubject)));
	}

	public function testRemoveExistingDocumentByIdentifierClientException(){
		$clientMock = $this->getMockBuilder('\SolrClient', array('deleteById'))->disableOriginalConstructor()->getMock();
		$clientMock->expects($this->any())->method('deleteById')->will($this->throwException(new \Exception()));
		$this->inject($this->provider, 'client', $clientMock);

		$this->assertSame(false, $this->provider->removeDocumentByIdentifier('12345'));
	}

	/**
	 * @depends testRemoveExistingDocumentByIdentifierClientException
	 */
	public function testRemoveExistingDocumentByIdentifierNotCaughtClientException(){
		$clientMock = $this->getMockBuilder('\SolrClient', array('deleteById'))->disableOriginalConstructor()->getMock();
		$clientMock->expects($this->any())->method('deleteById')->will($this->throwException(new \Exception()));
		$this->inject($this->provider, 'client', $clientMock);
		$this->inject($this->provider, 'settings', array('Solr' => array('Debug' => true)));
		/**
		 * Use of annotation not good, if there is a exception in test itself this also gets caught,
		 * own try catch is better solution
		 */
		try {
			$this->provider->removeDocumentByIdentifier('12345');
		}catch (\Exception $e){

		}
		$this->assertEquals(new \Exception(), $e);
	}

	/**
	 * @depends testAddDocument
	 */
	public function testDeleteExistingDocumentByIdentifier(){
		$this->assertSame(true, $this->provider->removeDocumentByIdentifier('12345'));
	}

	/**
	 * @depends testDeleteExistingDocumentByIdentifier
	 */
	public function testDeleteNotExistingDocumentByIdentifier(){
		$this->assertSame(true, $this->provider->removeDocumentByIdentifier('12345'));
	}

	/**
	 * @depends testDeleteNotExistingDocumentByIdentifier
	 */
	public function testSearchByStringDeletedDocument(){
		$this->assertEquals(array(), $this->provider->searchByString('12345', array($this->fieldIdentifier, $this->fieldSubject)));
	}

	public function testAddMultipleDocumentsClientException(){
		$clientMock = $this->getMockBuilder('\SolrClient', array('addDocuments'))->disableOriginalConstructor()->getMock();
		$clientMock->expects($this->any())->method('addDocuments')->will($this->throwException(new \Exception()));
		$this->inject($this->provider, 'client', $clientMock);
		$documentOne = $this->getFilledDocumentWithField('id', 'uniqueKey');
		$documentTwo = $this->getFilledDocumentWithField('id', 'otherUniqueKey');
		$this->assertSame(false, $this->provider->addDocuments(array($documentOne, $documentTwo)));
	}

	public function testAddMultipleDocumentsNotCaughtClientException(){
		$clientMock = $this->getMockBuilder('\SolrClient', array('addDocuments'))->disableOriginalConstructor()->getMock();
		$clientMock->expects($this->any())->method('addDocuments')->will($this->throwException(new \Exception()));
		$this->inject($this->provider, 'client', $clientMock);
		$documentOne = $this->getFilledDocumentWithField('id', 'uniqueKey');
		$documentTwo = $this->getFilledDocumentWithField('id', 'otherUniqueKey');
		$this->inject($this->provider, 'settings', array('Solr' => array('Debug' => true)));
		/**
		 * Use of annotation not good, if there is a exception in test itself this also gets caught,
		 * own try catch is better solution
		 */
		try {
			$this->provider->addDocuments(array($documentOne, $documentTwo));
		}catch (\Exception $e){

		}
		$this->assertEquals(new \Exception(), $e);
	}

	/**
	 * @depends testAddMultipleDocumentsClientException
	 */
	public function testAddMultipleDocuments(){
		$documentOne = $this->getFilledDocumentWithField('id', 'uniqueKey');
		$documentTwo = $this->getFilledDocumentWithField('id', 'otherUniqueKey');
		$this->assertSame(true, $this->provider->addDocuments(array($documentOne, $documentTwo)));
	}
}
?>