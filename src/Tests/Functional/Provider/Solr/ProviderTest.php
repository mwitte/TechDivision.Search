<?php

namespace Com\TechDivision\Search\Tests\Functional\Provider\Solr;
/**
 * Testcase for Board
 */
class ProviderTest extends \TYPO3\Flow\Tests\FunctionalTestCase {

	/**
	 * @var boolean
	 */
	static protected $testablePersistenceEnabled = FALSE;

	/**
	 * @var \Com\TechDivision\Search\Provider\Solr\Provider
	 */
	protected $solrProvider;

	/**
	 * @var \Com\TechDivision\Search\Document\Document
	 */
	protected $filledDocument;

	/**
	 * @var \Com\TechDivision\Search\Field\Field
	 */
	protected $fieldIdentifier;

	/**
	 * @var \Com\TechDivision\Search\Field\Field
	 */
	protected $fieldSubject;

	public function setUp(){
		parent::setUp();
		$this->solrProvider = $this->objectManager->get('\Com\TechDivision\Search\Provider\Solr\Provider');
		$this->filledDocument = new \Com\TechDivision\Search\Document\Document();
		$this->fieldIdentifier = new \Com\TechDivision\Search\Field\Field('id', '12345');
		$this->fieldSubject = new \Com\TechDivision\Search\Field\Field('subject', 'awesome');
		$this->filledDocument->addField($this->fieldIdentifier);
		$this->filledDocument->addField($this->fieldSubject);
	}

	private function getFilledDocumentWithField($fieldName, $fieldValue){
		$filledDocument = new \Com\TechDivision\Search\Document\Document();
		$field = new \Com\TechDivision\Search\Field\Field($fieldName, $fieldValue);
		$filledDocument->addField($field);
		return $filledDocument;
	}

	public function testSuccessfulCommit(){
		$this->assertSame(true, $this->solrProvider->commit());
	}

	public function testAddDocument(){
		$this->assertSame(true, $this->solrProvider->addDocument($this->filledDocument));
	}

	/**
	 * @depends testAddDocument
	 */
	public function testUpdateDocument(){
		$this->assertSame(true, $this->solrProvider->updateDocument($this->filledDocument));
	}

	public function testProviderNeedsInputDocuments(){
		$this->assertSame(true, $this->solrProvider->providerNeedsInputDocuments());
	}

	/**
	 * @depends testAddDocument
	 */
	public function testSearchByStringWithoutResult(){
		$this->assertEquals(array(), $this->solrProvider->searchByString('uniqueSe4rchT0kenWhichNotExists', array($this->fieldIdentifier, $this->fieldSubject)));
	}

	/**
	 * @depends testAddDocument
	 */
	public function testSearchByStringAddedDocument(){
		$this->assertEquals(array($this->filledDocument), $this->solrProvider->searchByString('12345', array($this->fieldIdentifier, $this->fieldSubject)));
	}

	/**
	 * @depends testSuccessfulCommit
	 */
	public function testDeleteExistingDocumentByIdentifier(){
		$this->assertSame(true, $this->solrProvider->removeDocumentByIdentifier('12345'));
	}

	/**
	 * @depends testSuccessfulCommit
	 */
	public function testDeleteNotExistingDocumentByIdentifier(){
		$this->assertSame(true, $this->solrProvider->removeDocumentByIdentifier('12345'));
	}

	/**
	 * @depends testAddDocument
	 */
	public function testSearchByStringDeletedDocument(){
		$this->assertEquals(array(), $this->solrProvider->searchByString('12345', array($this->fieldIdentifier, $this->fieldSubject)));
	}

	/**
	 * @depends testAddDocument
	 */
	public function testAddMultipleDocuments(){
		$documentOne = $this->getFilledDocumentWithField('id', 'uniqueKey');
		$documentTwo = $this->getFilledDocumentWithField('id', 'otherUniqueKey');
		$this->assertSame(true, $this->solrProvider->addDocuments(array($documentOne, $documentTwo)));
	}
}
?>