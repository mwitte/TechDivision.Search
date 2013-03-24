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
interface SearchProviderInterface extends ProviderInterface
{

	/**
	 * @param string $searchString
	 * @param array $fields
	 * @param int $rows
	 * @param int $offset
	 * @return array
	 */
	public function searchByString($searchString, array $fields, $rows = 50, $offset = 0);
}
