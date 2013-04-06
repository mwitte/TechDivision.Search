<?php

namespace TechDivision\Search\Tests\Unit\Field;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class DocumentTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @var \TechDivision\Search\Document\Document
	 */
	protected $document;

	/**
	 * @var \TechDivision\Search\Field\Field
	 */
	protected $fieldOne;

	/**
	 * @var \TechDivision\Search\Field\Field
	 */
	protected $fieldTwo;

	public function setUp(){
		parent::setUp();
		$this->document = new \TechDivision\Search\Document\Document();
		$this->fieldOne = new \TechDivision\Search\Field\Field('name', 'value');
		$this->fieldTwo = new \TechDivision\Search\Field\Field('otherName', 'otherValue');
	}

	public function testAddAndGetField(){
		$this->document->addField($this->fieldOne);
		$this->assertSame($this->fieldOne, $this->document->getField('name'));
	}

	public function testAddAndGetFieldWithWrongName(){
		$this->document->addField($this->fieldOne);
		$this->assertSame(null, $this->document->getField('wrongName'));
	}

	/**
	 * @depends testAddAndGetField
	 */
	public function testAddAndGetFields(){
		$this->document->addField($this->fieldOne);
		$this->document->addField($this->fieldTwo);
		$fields = array($this->fieldOne, $this->fieldTwo);
		$this->assertSame($fields, $this->document->getFields());
	}

	public function testSetFieldsAndGetFields(){
		$fields = array($this->fieldOne, $this->fieldTwo);
		$this->document->setFields($fields);
		$this->assertSame($fields, $this->document->getFields());
	}


	public function testRemoveFieldOfEmptyDocument(){
		$this->assertSame(false, $this->document->removeField($this->fieldOne));
	}

	/**
	 * @depends testAddAndGetField
	 */
	public function testRemoveAddedField(){
		$this->document->addField($this->fieldOne);
		$this->document->removeField($this->fieldOne);
		$this->assertSame(array(), $this->document->getFields());
	}

	/**
	 * @depends testRemoveAddedField
	 */
	public function testRemoveNotAddedField(){
		$this->document->addField($this->fieldOne);
		$this->document->removeField($this->fieldTwo);
		$this->assertSame(array($this->fieldOne), $this->document->getFields());
	}

	/**
	 * @depends testAddAndGetField
	 */
	public function testGetFieldCount(){
		$this->document->addField($this->fieldOne);
		$this->document->addField($this->fieldTwo);
		$this->assertSame(2, $this->document->getFieldCount());
	}

	public function testSetGetBoost(){
		$this->document->setBoost(4.5);
		$this->assertSame(4.5, $this->document->getBoost());
	}
}
?>