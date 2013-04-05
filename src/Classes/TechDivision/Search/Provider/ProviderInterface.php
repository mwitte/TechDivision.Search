<?php

namespace TechDivision\Search\Provider;

/*                                                                        *
 * This belongs to the TYPO3 Flow package "TechDivision.Search"       *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * Copyright (C) 2013 Matthias Witte                                      *
 * http://www.matthias-witte.net                                          */

use \TechDivision\Search\Document\DocumentInterface;

interface ProviderInterface
{
	/**
	 * Returns true if the provider needs documents for it's index
	 *
	 * @return bool
	 */
	public function providerNeedsInputDocuments();


	/**
	 * Adds one single document
	 *
	 * @param \TechDivision\Search\Document\DocumentInterface $document
	 * @return bool
	 */
	public function addDocument(\TechDivision\Search\Document\DocumentInterface $document);

	/**
	 * Removes one single document by it's identifier
	 *
	 * @param string $identifier
	 * @return bool
	 */
	public function removeDocumentByIdentifier($identifier);

	/**
	 * Resolves documents which implement the DocumentInterface
	 *
	 * @param string $searchString
	 * @param array $fields
	 * @param int $rows
	 * @param int $offset
	 * @return array <\TechDivision\Search\Document\DocumentInterface>
	 */
	public function searchByString($searchString, array $fields, $rows = 50, $offset = 0);
}
