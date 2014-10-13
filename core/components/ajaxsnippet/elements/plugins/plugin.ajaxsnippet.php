<?php

switch ($modx->event->name) {

	case 'OnLoadWebDocument':
		if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
			return;
		}
		/** @var xPDOFileCache $cache */
		$cache = $modx->cacheManager;
		$cache_key = '/ajaxsnippet/';

		if (!empty($_REQUEST['as_action']) && $scriptProperties = $cache->get($cache_key . $_REQUEST['as_action'])) {
			$output = '';
			/** @var modSnippet $object */
			if ($object = $modx->getObject('modSnippet', array('name' => $scriptProperties['snippet']))) {
				$properties = $object->getProperties();
				if (!empty($scriptProperties['propertySet'])) {
					$properties = array_merge($properties, $object->getPropertySet($scriptProperties['propertySet']));
				}
				$scriptProperties = array_merge($properties, $scriptProperties);

				$output = $object->process($scriptProperties);
				if (strpos($output, '[[') !== false) {
					$maxIterations = intval($modx->getOption('parser_max_iterations', $options, 10));
					$modx->parser->processElementTags('', $output, true, false, '[[', ']]', array(), $maxIterations);
					$modx->parser->processElementTags('', $output, true, true, '[[', ']]', array(), $maxIterations);
				}
			}

			$response = array(
				'output' => $output,
				'key' => $_REQUEST['as_action'],
				'snippet' => $scriptProperties['snippet'],
			);
			if (!empty($scriptProperties['totalVar'])) {
				$response['total'] = $modx->getPlaceholder($scriptProperties['totalVar']);
			}
			if (!empty($scriptProperties['pageNavVar'])) {
				$response['pagination'] = $modx->getPlaceholder($scriptProperties['pageNavVar']);
			}

			echo $modx->toJSON($response);
			@session_write_close();
			exit;
		}
		break;

}
