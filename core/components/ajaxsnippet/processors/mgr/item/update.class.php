<?php
/**
 * Update an Item
 */
class AjaxSnippetItemUpdateProcessor extends modObjectUpdateProcessor {
	public $objectType = 'AjaxSnippetItem';
	public $classKey = 'AjaxSnippetItem';
	public $languageTopics = array('ajaxsnippet');
	public $permission = 'update_document';
}

return 'AjaxSnippetItemUpdateProcessor';
