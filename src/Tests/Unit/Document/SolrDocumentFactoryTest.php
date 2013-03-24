<?php

namespace Com\TechDivision\Search\Tests\Unit\Field;


class SolrDocumentFactoryTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @var \Com\TechDivision\Search\Document\SolrDocumentFactory
	 */
	protected $documentFactory;

	/**
	 * @var \Com\TechDivision\Search\Document\Document
	 */
	protected $document;

	/**
	 * @var \Com\TechDivision\Search\Field\SolrFieldFactory
	 */
	protected $fieldFactoryMock;

	/**
	 * @var \Com\TechDivision\Search\Field\SolrFieldFactory
	 */
	protected $fieldFactory;

	public function setUp(){
		parent::setUp();
		$this->documentFactory = new \Com\TechDivision\Search\Document\SolrDocumentFactory();
		$this->document = new \Com\TechDivision\Search\Document\Document();

		$this->fieldFactoryMock = $this->getMock('\Com\TechDivision\Search\Field\SolrFieldFactory', array('createFieldsWith'));
		$this->fieldFactoryMock->expects($this->any())
			 ->method('createFieldsWith')
			 ->will($this->returnValue(array()));

		$this->fieldFactory = new \Com\TechDivision\Search\Field\SolrFieldFactory();
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
		$document = new \Com\TechDivision\Search\Document\Document();
		$document->addField(new \Com\TechDivision\Search\Field\Field('fieldName', 'fieldValue'));

		$this->assertEquals(array($document), $this->documentFactory->createFromResponse($incompleteResponse, new \Com\TechDivision\Search\Field\SolrFieldFactory()));
	}
}
?>