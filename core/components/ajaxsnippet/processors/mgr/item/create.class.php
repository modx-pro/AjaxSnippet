<?php
/**
 * Create an Item
 */
class AjaxSnippetItemCreateProcessor extends modObjectCreateProcessor {
	public $objectType = 'AjaxSnippetItem';
	public $classKey = 'AjaxSnippetItem';
	public $languageTopics = array('ajaxsnippet');
	public $permission = 'new_document';


	/**
	 * @return bool
	 */
	public function beforeSet() {
		$alreadyExists = $this->modx->getObject('AjaxSnippetItem', array(
			'name' => $this->getProperty('name'),
		));
		if ($alreadyExists) {
			$this->modx->error->addField('name', $this->modx->lexicon('ajaxsnippet_item_err_ae'));
		}

		return !$this->hasErrors();
	}

}

return 'AjaxSnippetItemCreateProcessor';
