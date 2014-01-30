<?php
/**
 * Remove an Item
 */
class AjaxSnippetItemRemoveProcessor extends modObjectRemoveProcessor {
	public $checkRemovePermission = true;
	public $objectType = 'AjaxSnippetItem';
	public $classKey = 'AjaxSnippetItem';
	public $languageTopics = array('ajaxsnippet');

}

return 'AjaxSnippetItemRemoveProcessor';
