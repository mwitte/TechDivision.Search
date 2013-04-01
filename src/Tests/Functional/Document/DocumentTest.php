<?php

namespace Com\TechDivision\Search\Tests\Functional\Document;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "Com.TechDivision.Search"       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class DocumentTest extends \TYPO3\Flow\Tests\FunctionalTestCase {

	/**
	 * @var boolean
	 */
	static protected $testablePersistenceEnabled = FALSE;

	/**
	 * @var \Com\TechDivision\Search\Document\Document
	 */
	protected $document;

	/**
	 * @var \Com\TechDivision\Search\Field\Field
	 */
	protected $oneField;

	/**
	 * @var \Com\TechDivision\Search\Field\Field
	 */
	protected $otherField;

	public function setUp(){
		parent::setUp();
		$this->document = new \Com\TechDivision\Search\Document\Document();
		$this->oneField = new \Com\TechDivision\Search\Field\Field('id', '12345');
		$this->otherField = new \Com\TechDivision\Search\Field\Field('id', 'otherField');
	}

	public function testSetGetBoost(){
		$this->document->setBoost(4.5);
		$this->assertSame(4.5, $this->document->getBoost());
	}

	public function testGetFieldCountWithEmptyDocument(){
		$this->assertSame(0, $this->document->getFieldCount());
	}

	/**
	 * @depends testGetFieldCountWithEmptyDocument
	 */
	public function testGetFieldCountWithFilledDocument(){
		$this->document->addField($this->oneField);
		$this->assertSame(1, $this->document->getFieldCount());
	}

	/**
	 * @depends testGetFieldCountWithFilledDocument
	 */
	public function testRemoveNotExistingField(){
		$this->assertSame(false, $this->document->removeField($this->oneField));
	}

	/**
	 * @depends testGetFieldCountWithFilledDocument
	 */
	public function testGetField(){
		$this->document->addField($this->oneField);
		$this->assertSame($this->oneField, $this->document->getField($this->oneField->getName()));
	}

	/**
	 * @depends testGetFieldCountWithFilledDocument
	 */
	public function testGetFieldWithWrongName(){
		$this->document->addField($this->oneField);
		$this->assertSame(null, $this->document->getField('wrongName'));
	}

	/**
	 * @depends testGetFieldCountWithFilledDocument
	 */
	public function testRemoveExistingField(){
		$this->document->addField($this->oneField);
		$this->assertSame(true, $this->document->removeField($this->oneField));
	}

	public function testRemoveCorrectField(){
		$this->document->addField($this->oneField);
		$this->document->addField($this->otherField);
		// remove one field
		$this->document->removeField($this->oneField);
		$this->assertSame(array($this->otherField), $this->document->getFields());
	}
}
?>