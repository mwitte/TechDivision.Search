<?php

namespace Com\TechDivision\Search\Provider;

use \Com\TechDivision\Search\Document\DocumentInterface;
/**
 * Created by JetBrains PhpStorm.
 * User: wittem
 * Date: 23.03.13
 * Time: 07:46
 * To change this template use File | Settings | File Templates.
 */
interface FillProviderInterface extends ProviderInterface
{

	/**
	 * @param \Com\TechDivision\Search\Document\DocumentInterface $document
	 * @return bool
	 */
	public function addDocument(\Com\TechDivision\Search\Document\DocumentInterface $document);

	/**
	 * @param int $maxSegments
	 * @param bool $waitFlush
	 * @param bool $waitSearcher
	 */
	public function commit($maxSegments = 0, $waitFlush = true, $waitSearcher = true);

	/**
	 * @param \Com\TechDivision\Search\Document\DocumentInterface $document
	 * @return bool
	 */
	public function updateDocument(\Com\TechDivision\Search\Document\DocumentInterface $document);

	/**
	 * @param string $identifier
	 * @return bool
	 */
	public function removeDocumentByIdentifier($identifier);
}
