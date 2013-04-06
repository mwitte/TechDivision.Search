<?php

namespace TechDivision\Search\Tests\Unit\Provider\Solr\Rest\Builder;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class UrlBuilderTest extends \TYPO3\Flow\Tests\UnitTestCase {

	/**
	 * @var \TechDivision\Search\Provider\Solr\Rest\Builder\UrlBuilder
	 */
	protected $urlBuilder;

	public function setUp(){
		parent::setUp();
		$this->urlBuilder = new \TechDivision\Search\Provider\Solr\Rest\Builder\UrlBuilder();

		$settings = array(
			'Solr' => array(
				'ServerData' => array(
					'protocol' => 'http',
					'hostname' => 'localhost',
					'port' => '8983'
				)
			)
		);
		$this->inject($this->urlBuilder, 'settings', $settings);
	}

	public function testBuildSearchUrlWithoutFields(){
		$this->assertSame(null, $this->urlBuilder->buildSearchUrl('test', array()));
	}

	/**
	 * @depends testBuildSearchUrlWithoutFields
	 */
	public function testBuildSearchUrlWithField(){
		$field = new \TechDivision\Search\Field\Field('title', null);
		$this->assertSame(
			'http://localhost:8983/solr/select/?indent=off&wt=json&q=' . urlencode('title:"test"'),
			$this->urlBuilder->buildSearchUrl('test', array($field))
		);
	}

	/**
	 * @depends testBuildSearchUrlWithoutFields
	 */
	public function testBuildSearchUrlWithMultipleFields(){
		$field1 = new \TechDivision\Search\Field\Field('title', null);
		$field2 = new \TechDivision\Search\Field\Field('description', null);
		$this->assertSame(
			'http://localhost:8983/solr/select/?indent=off&wt=json&q=' . urlencode('title:"test" OR description:"test"'),
			$this->urlBuilder->buildSearchUrl('test', array($field1, $field2))
		);
	}

	public function testBuildUpdateUrl(){
		$this->assertSame(
			'http://localhost:8983/solr/update/json?commit=true&wt=json',
			$this->urlBuilder->buildUpdateUrl()
		);
	}
}
?>