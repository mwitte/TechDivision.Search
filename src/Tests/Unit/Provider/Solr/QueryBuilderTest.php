<?php

namespace Com\TechDivision\Search\Tests\Unit\Provider\Solr;


class QueryBuilderTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @var \Com\TechDivision\Search\Provider\Solr\QueryBuilder
	 */
	protected $queryBuilder;

	/**
	 * @var \SolrQuery
	 */
	protected $query;

	public function setUp(){
		parent::setUp();
		$this->queryBuilder = new \Com\TechDivision\Search\Provider\Solr\QueryBuilder();
		$this->query = new \SolrQuery();
		$this->query->setRows(50);
		$this->query->setStart(0);
	}

	public function testBuildQueryWithoutFields(){
		// these objects cannot be equal, they got a randomised _hashtable_index
		$similarQuery = $this->queryBuilder->buildQuery('lookingFor', array(), 50, 0);

		$this->assertSame($this->query->getStart(), $similarQuery->getStart(), 'same start');
		$this->assertSame($this->query->getRows(), $similarQuery->getRows(), 'same rows');
	}

	/**
	 * @depends testBuildQueryWithoutFields
	 */
	public function testBuildQueryWithOneField(){
		$this->query->addField('name');
		$this->query->setQuery('name:"lookingFor"');
		$field = new \Com\TechDivision\Search\Field\Field('name', 'value');
		// get the similar queryObject
		$similarQuery = $this->queryBuilder->buildQuery('lookingFor', array($field), 50, 0);
		// the queryString should be the same
		$this->assertSame($this->query->getQuery(), $similarQuery->getQuery());
	}

	/**
	 * @depends testBuildQueryWithOneField
	 */
	public function testBuildQueryWithMultipleFields(){
		$this->query->addField('name');
		$this->query->addField('surname');
		$this->query->setQuery('name:"lookingFor" OR surname:"lookingFor"');
		$fieldOne = new \Com\TechDivision\Search\Field\Field('name', 'value');
		$fieldTwo = new \Com\TechDivision\Search\Field\Field('surname', 'value');

		$similarQuery = $this->queryBuilder->buildQuery('lookingFor', array($fieldOne, $fieldTwo), 50, 0);

		$this->assertSame($this->query->getQuery(), $similarQuery->getQuery());
	}
}
?>