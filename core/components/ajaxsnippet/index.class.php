<?php

require_once dirname(__FILE__) . '/model/ajaxsnippet/ajaxsnippet.class.php';

/**
 * Class AjaxSnippetMainController
 */
abstract class AjaxSnippetMainController extends modExtraManagerController {
	/** @var AjaxSnippet $AjaxSnippet */
	public $AjaxSnippet;


	/**
	 * @return void
	 */
	public function initialize() {
		$this->AjaxSnippet = new AjaxSnippet($this->modx);

		$this->modx->regClientCSS($this->AjaxSnippet->config['cssUrl'] . 'mgr/main.css');
		$this->modx->regClientStartupScript($this->AjaxSnippet->config['jsUrl'] . 'mgr/ajaxsnippet.js');
		$this->modx->regClientStartupHTMLBlock('<script type="text/javascript">
		Ext.onReady(function() {
			AjaxSnippet.config = ' . $this->modx->toJSON($this->AjaxSnippet->config) . ';
			AjaxSnippet.config.connector_url = "' . $this->AjaxSnippet->config['connectorUrl'] . '";
		});
		</script>');

		parent::initialize();
	}


	/**
	 * @return array
	 */
	public function getLanguageTopics() {
		return array('ajaxsnippet:default');
	}


	/**
	 * @return bool
	 */
	public function checkPermissions() {
		return true;
	}
}


/**
 * Class IndexManagerController
 */
class IndexManagerController extends AjaxSnippetMainController {

	/**
	 * @return string
	 */
	public static function getDefaultController() {
		return 'home';
	}
}
