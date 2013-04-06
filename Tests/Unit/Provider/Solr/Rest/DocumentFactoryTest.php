<?php

namespace TechDivision\Search\Tests\Unit\Provider\Solr\Rest;

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
	 * @var \TechDivision\Search\Provider\Solr\Rest\DocumentFactory
	 */
	protected $documentFactory;

	public function setUp(){
		parent::setUp();
		$this->documentFactory = new \TechDivision\Search\Provider\Solr\Rest\DocumentFactory();
	}

	public function testCreateFromResponseEmpty(){
		$this->assertSame(array(), $this->documentFactory->createFromResponse(array()));
	}

	/**
	 * @depends testCreateFromResponseEmpty
	 */
	public function testCreateFromResponseWithEmptyDocs(){
		$this->assertSame(array(), $this->documentFactory->createFromResponse(array(array())));
	}

	/**
	 * @depends testCreateFromResponseWithEmptyDocs
	 */
	public function testCreateFromResponseWithDocs(){
		$rawDocs = array(
			array(
				'id' => 1234
			)
		);
		$document = new \TechDivision\Search\Document\Document();
		$document->addField(new \TechDivision\Search\Field\Field('id', 1234));
		$this->assertEquals(array($document), $this->documentFactory->createFromResponse($rawDocs));
	}
}
?>