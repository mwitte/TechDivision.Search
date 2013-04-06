<?php

namespace TechDivision\Search\Tests\Functional\Provider\Solr\Extension;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

class InputBuilderTest extends \TYPO3\Flow\Tests\FunctionalTestCase {

	/**
	 * @var boolean
	 */
	static protected $testablePersistenceEnabled = FALSE;

	/**
	 * @var \TechDivision\Search\Provider\Solr\Extension\InputBuilder
	 */
	protected $inputBuilder;

	public function setUp(){
		parent::setUp();
		$this->inputBuilder = new \TechDivision\Search\Provider\Solr\Extension\InputBuilder();
	}

	public function testCreateSolrInputDocumentWithEmptyDocument(){
		$this->assertSame(null, $this->inputBuilder->createSolrInputDocument(new \TechDivision\Search\Document\Document()));
	}
}
?>