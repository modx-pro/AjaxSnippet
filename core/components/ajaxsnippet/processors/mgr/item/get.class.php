<?php
/**
 * Get an Item
 */
class AjaxSnippetItemGetProcessor extends modObjectGetProcessor {
	public $objectType = 'AjaxSnippetItem';
	public $classKey = 'AjaxSnippetItem';
	public $languageTopics = array('ajaxsnippet:default');
}

return 'AjaxSnippetItemGetProcessor';
