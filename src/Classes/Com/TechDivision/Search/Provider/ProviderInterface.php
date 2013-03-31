<?php

namespace Com\TechDivision\Search\Provider;

use \Com\TechDivision\Search\Document\DocumentInterface;

interface ProviderInterface
{
	/**
	 * @return bool
	 */
	public function providerNeedsInputDocuments();


	/**
	 * @param \Com\TechDivision\Search\Document\DocumentInterface $document
	 * @return bool
	 */
	public function addDocument(\Com\TechDivision\Search\Document\DocumentInterface $document);

	/**
	 * @param string $identifier
	 * @return bool
	 */
	public function removeDocumentByIdentifier($identifier);

	/**
	 * @param string $searchString
	 * @param array $fields
	 * @param int $rows
	 * @param int $offset
	 * @return array
	 */
	public function searchByString($searchString, array $fields, $rows = 50, $offset = 0);
}
