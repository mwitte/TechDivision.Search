<?php

namespace Com\TechDivision\Search\Tests\Functional\Provider\Solr;
/**
 * Testcase for Board
 */
class InputBuilderTest extends \TYPO3\Flow\Tests\FunctionalTestCase {

	/**
	 * @var boolean
	 */
	static protected $testablePersistenceEnabled = FALSE;

	/**
	 * @var \Com\TechDivision\Search\Provider\Solr\InputBuilder
	 */
	protected $inputBuilder;

	public function setUp(){
		parent::setUp();
		$this->inputBuilder = new \Com\TechDivision\Search\Provider\Solr\InputBuilder();
	}

	public function testCreateSolrInputDocumentWithEmptyDocument(){
		$this->assertSame(null, $this->inputBuilder->createSolrInputDocument(new \Com\TechDivision\Search\Document\Document()));
	}
}
?>