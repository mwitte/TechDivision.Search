<?php

namespace Com\TechDivision\Search\Tests\Unit\Field;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "Com.TechDivision.Search"       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class FieldTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @var \Com\TechDivision\Search\Field\Field
	 */
	protected $field;

	public function setUp(){
		parent::setUp();
		$this->field = new \Com\TechDivision\Search\Field\Field('initName', 'initValue', 0);
	}

	public function testSetGetNameWithString(){
		$this->field->setName('myName');
		$this->assertSame('myName', $this->field->getName());
	}

	public function testSetGetValueWithString(){
		$this->field->setValue('valuetoken');
		$this->assertSame('valuetoken', $this->field->getValue());
	}


	public function testSetGetBoostWithFloat(){
		$this->field->setBoost(4.6);
		$this->assertSame(4.6, $this->field->getBoost());
	}

}
?>