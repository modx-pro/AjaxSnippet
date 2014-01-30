<?php
/**
 * Get a list of Items
 */
class AjaxSnippetItemGetListProcessor extends modObjectGetListProcessor {
	public $objectType = 'AjaxSnippetItem';
	public $classKey = 'AjaxSnippetItem';
	public $defaultSortField = 'id';
	public $defaultSortDirection = 'DESC';
	public $renderers = '';


	/**
	 * @param xPDOQuery $c
	 *
	 * @return xPDOQuery
	 */
	public function prepareQueryBeforeCount(xPDOQuery $c) {
		return $c;
	}


	/**
	 * @param xPDOObject $object
	 *
	 * @return array
	 */
	public function prepareRow(xPDOObject $object) {
		$array = $object->toArray();

		return $array;
	}

}

return 'AjaxSnippetItemGetListProcessor';
