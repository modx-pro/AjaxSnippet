<?php
/** @var array $scriptProperties */
if (empty($snippet)) {return 'You must specify snippet!';}
elseif (!$modx->getCount('modSnippet', array('name' => $snippet))) {return 'Could not found snippet "'.$snippet.'"';}

if (!empty($wrapper)) {$wrapper = $modx->getChunk($wrapper);}
if (empty($wrapper)) {$wrapper = '<div id="[[+key]]" class="ajax-snippet">
	<img src="http://st.bezumkin.ru/files/8/3/3/8331d0647f1caccaa2d134de73d47bbb.gif" style="width:32px;margin:auto;display:block;">
</div>';}

/** @var xPDOFileCache $cache */
$cache = $modx->cacheManager->getCacheProvider($modx->getOption('cache_resource_key', null, 'resource'));
$cache_key = $modx->resource->getCacheKey() . '/as/';

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
	$key = sha1(serialize($scriptProperties));
	$modx->regClientScript(
		'<script type="text/javascript">
			$(document).ready(function() {
				$.post("", {as_action: "'.$key.'"}, function(response) {
				if (response.output) {
					$("#'.$key.'").html(response.output);
					$(document).trigger("as_complete", response);
				}
			}, "json");
		});
	</script>
	', true);

	$cache->set($cache_key . $key, $scriptProperties);
	return str_replace('[[+key]]', $key, $wrapper);
}
elseif (!empty($_REQUEST['as_action']) && $scriptProperties = $cache->get($cache_key . $_REQUEST['as_action'])) {

	$output = '';
	/** @var modSnippet $object */
	if ($object = $modx->getObject('modSnippet', array('name' => $scriptProperties['snippet']))) {
		$properties = $object->getProperties();
		if (!empty($scriptProperties['propertySet'])) {
			$properties = array_merge($properties, $object->getPropertySet($scriptProperties['propertySet']));
		}
		$scriptProperties = array_merge($properties, $scriptProperties);

		$output = $object->process($scriptProperties);
	}

	$response = array(
		'output' => $output,
		'key' => $_REQUEST['as_action']
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