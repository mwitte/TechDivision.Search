<?php
namespace Com\TechDivision\Search\Provider\Solr;

use TYPO3\Flow\Annotations as Flow;
/**
 * This is my great class.
 *
 * @Flow\Scope("singleton")
 */
class QueryBuilder
{
	/**
	 * @param string $searchToken
	 * @param array $fields
	 * @param int $rows
	 * @param int $offset
	 * @return \SolrQuery
	 */
	public function buildQuery($searchToken, array $fields, $rows = 50, $offset = 0){
		$query = new \SolrQuery();
		$queryString = $this->buildSearchString($searchToken, $fields);
		if(strlen($queryString)){
			$query->setQuery($queryString);
		}

		$query->setStart($offset);
		$query->setRows($rows);
		// add the fields to the requested data
		/** @var $field \Com\TechDivision\Search\Field\Field */
		foreach($fields as $field){
			$query->addField($field->getName());
		}
		return $query;
	}

	/**
	 * @param $searchString
	 * @param array $fields
	 * @return string
	 */
	protected function buildSearchString($searchString, array $fields){
		$query = '';
		$iterator = 0;
		/** @var $field \Com\TechDivision\Search\Field\Field */
		foreach($fields as $field){
			// after first iteration
			if($iterator > 0){
				// TODO configurable!
				// concatenate statements
				$query .= ' OR ';
			}
			$iterator++;
			// build statement and concatenate
			$query .= $field->getName() . ':"'. $searchString . '"';
		}
		return $query;
	}
}
