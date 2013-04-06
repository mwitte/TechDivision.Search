<?php

namespace TechDivision\Search\Tests\Unit\Provider\Solr\Extension\Factories;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class DocumentFactoryTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @var \TechDivision\Search\Provider\Solr\Extension\Factories\DocumentFactory
	 */
	protected $documentFactory;

	/**
	 * @var \TechDivision\Search\Document\Document
	 */
	protected $document;

	/**
	 * @var \TechDivision\Search\Provider\Solr\Extension\Factories\FieldFactory
	 */
	protected $fieldFactoryMock;

	/**
	 * @var \TechDivision\Search\Provider\Solr\Extension\Factories\FieldFactory
	 */
	protected $fieldFactory;

	public function setUp(){
		parent::setUp();
		$this->documentFactory = new \TechDivision\Search\Provider\Solr\Extension\Factories\DocumentFactory();
		$this->document = new \TechDivision\Search\Document\Document();

		$this->fieldFactoryMock = $this->getMock('\TechDivision\Search\Provider\Solr\Extension\Factories\FieldFactory', array('createFieldsWith'));
		$this->fieldFactoryMock->expects($this->any())
			 ->method('createFieldsWith')
			 ->will($this->returnValue(array()));

		$this->fieldFactory = new \TechDivision\Search\Provider\Solr\Extension\Factories\FieldFactory();
	}

	public function testCreateFromResponseWithEmptyResponse(){
		$solrObject = array();
		$this->assertSame(array(), $this->documentFactory->createFromResponse($solrObject, $this->fieldFactoryMock));
	}

	/**
	 * @depends testCreateFromResponseWithEmptyResponse
	 */
	public function testCreateFromResponseWithIncompleteResponse(){
		$incompleteResponse = array(
			'response' => array()
		);
		$this->assertSame(array(), $this->documentFactory->createFromResponse($incompleteResponse, $this->fieldFactory));
	}

	/**
	 * @depends testCreateFromResponseWithIncompleteResponse
	 */
	public function testCreateFromResponseWithCompleteResponse(){
		$incompleteResponse = array(
			'response' => array(
				'docs' => array(
					array(
						'fieldName' => 'fieldValue'
					)
				)
			)
		);
		$document = new \TechDivision\Search\Document\Document();
		$document->addField(new \TechDivision\Search\Field\Field('fieldName', 'fieldValue'));

		$this->assertEquals(array($document), $this->documentFactory->createFromResponse($incompleteResponse, new \TechDivision\Search\Provider\Solr\Extension\Factories\FieldFactory()));
	}
}
?>