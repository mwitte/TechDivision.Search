<?php

namespace TechDivision\Search\Tests\Unit\Field;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

use \TechDivision\Search\Field\Field;

class SolrFieldFactoryTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @var \TechDivision\Search\Field\SolrFieldFactory
	 */
	protected $fieldFactory;

	public function setUp(){
		parent::setUp();
		$this->fieldFactory = new \TechDivision\Search\Field\SolrFieldFactory();
	}

	public function testCreateFieldsWithEmptyDocument(){
		$response = array();
		$this->assertSame(array(), $this->fieldFactory->createFieldsWith($response));
	}

	public function testCreateFieldsWithOneDocument(){
		$fieldName = 'fieldName';
		$fieldValue = 'fieldValue';
		$documents = array(
			$fieldName => $fieldValue
		);
		$equalFieldSet = array(new Field($fieldName, $fieldValue));
		$this->assertEquals($equalFieldSet, $this->fieldFactory->createFieldsWith($documents));
	}

	public function testCreateFieldsWithMultipleDocuments(){
		$nameA = 'fieldName';
		$valueA = 'fieldValue';
		$name2 = 'otherName';
		$value2 = 'otherValue';
		$documents = array(
			$nameA => $valueA,
			$name2 => $value2
		);
		$equalFieldSet = array(
			new Field($nameA, $valueA),
			new Field($name2, $value2)
		);
		$this->assertEquals($equalFieldSet, $this->fieldFactory->createFieldsWith($documents));
	}
}
?>