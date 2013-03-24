<?php

namespace Com\TechDivision\Search\Field;

class SolrFieldFactory
{
	/**
	 * @param array $documentArray
	 * @return array contains
	 */
	public function createFieldsWith($documentArray){
		$fields = array();
		// create one field for each field in the response
		foreach($documentArray as $fieldName => $fieldValue){
			$fields[] = new Field($fieldName, $fieldValue);
		}
		return $fields;
	}
}
