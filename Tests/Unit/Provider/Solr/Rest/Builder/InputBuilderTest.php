<?php

namespace TechDivision\Search\Tests\Unit\Provider\Solr\Rest\Builder;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class InputBuilderTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @var \TechDivision\Search\Provider\Solr\Rest\Builder\InputBuilder
	 */
	protected $inputBuilder;

	public function setUp(){
		parent::setUp();
		$this->inputBuilder = new \TechDivision\Search\Provider\Solr\Rest\Builder\InputBuilder();
	}

	public function testBuildUpdateChunkWithEmptyDoc(){
		$document = new \TechDivision\Search\Document\Document();
		$expected = array(
			'add' => array(
				'doc' => array(

				)
			)
		);
		$this->assertSame(
			null,
			$this->inputBuilder->buildUpdateChunk($document)
		);
	}

	/**
	 * @depends testBuildUpdateChunkWithEmptyDoc
	 */
	public function testBuildUpdateChunkWithDoc(){
		$document = new \TechDivision\Search\Document\Document();
		$document->addField(new \TechDivision\Search\Field\Field('id', 1234));
		$expected = array(
			'add' => array(
				'doc' => array(
					'id' => 1234
				)
			)
		);
		$this->assertSame(
			$expected,
			$this->inputBuilder->buildUpdateChunk($document)
		);
	}

	/**
	 * @depends testBuildUpdateChunkWithDoc
	 */
	public function testBuildUpdateChunkWithDocWithBoost(){
		$document = new \TechDivision\Search\Document\Document();
		$document->addField(new \TechDivision\Search\Field\Field('id', 1234));
		$document->setBoost(2);
		$expected = array(
			'add' => array(
				'doc' => array(
					'id' => 1234
				),
				'boost' => 2
			)
		);
		$this->assertSame(
			$expected,
			$this->inputBuilder->buildUpdateChunk($document)
		);
	}

	public function testBuildDeleteChunk(){
		$field = new \TechDivision\Search\Field\Field('id', 1234);
		$this->assertSame(
			array(
				'delete' => array(
					'id' => 1234
				)
			),
			$this->inputBuilder->buildDeleteChunk($field)
		);
	}
}
?>