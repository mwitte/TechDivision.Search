<?php

namespace Com\TechDivision\Search\Tests\Unit\Field;


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