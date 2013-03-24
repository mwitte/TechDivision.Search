<?php

namespace Com\TechDivision\Search\Tests\Functional\Provider\Solr;
/**
 * Testcase for Board
 */
class ResponseBuilderTest extends \TYPO3\Flow\Tests\FunctionalTestCase {

	/**
	 * @var boolean
	 */
	static protected $testablePersistenceEnabled = FALSE;

	/**
	 * @var \Com\TechDivision\Search\Provider\Solr\ResponseBuilder
	 */
	protected $responseBuilder;

	public function setUp(){
		parent::setUp();
		$this->responseBuilder = new \Com\TechDivision\Search\Provider\Solr\ResponseBuilder();
	}

	public function testCreateProviderSearchResponseWithEmptyResponse(){
		$this->assertSame(array(), $this->responseBuilder->createProviderSearchResponse(new \SolrQueryResponse()));
	}
}
?>