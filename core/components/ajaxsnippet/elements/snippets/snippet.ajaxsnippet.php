<?php
/** @var array $scriptProperties */
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {return;}

if (empty($snippet)) {return 'You must specify snippet!';}
elseif (!$modx->getCount('modSnippet', array('name' => $snippet))) {return 'Could not found snippet "'.$snippet.'"';}

/** @var xPDOFileCache $cache */
$cache = $modx->cacheManager->getCacheProvider($modx->getOption('cache_resource_key', null, 'resource'));
$cache_key = $modx->resource->getCacheKey() . '/as/';
$key = sha1(serialize($scriptProperties));
$modx->lexicon->load('ajaxsnippet:default');

if (!empty($wrapper)) {$wrapper = $modx->getChunk($wrapper);}
if (empty($as_mode)) {$as_mode = 'OnLoad';}
if (empty($as_target)) {$as_target = '#'.$key;}

$script = '
$.post("'.$modx->context->makeUrl($modx->resource->id, '', 'full').'", {as_action: "'.$key.'"}, function(response) {
	if (typeof response.output !== "undefined") {
		$("'.$as_target.'").html(response.output);
		spinner.remove();
		$(document).trigger("as_complete", response);
	}
}, "json");';

$output = '';
switch (strtolower($as_mode)) {
	case 'none':
		/** @var modSnippet $object */
		$object = $modx->getObject('modSnippet', array('name' => $snippet));
		$properties = $object->getProperties();
		if (!empty($propertySet)) {
			$properties = array_merge($properties, $object->getPropertySet($propertySet));
		}
		$scriptProperties = array_merge($properties, $scriptProperties);
		$output = $object->process($scriptProperties);
		break;

	case 'onclick':
		if (empty($wrapper)) {$wrapper = '<div id="[[+key]]" class="ajax-snippet">
			<a href="#" class="as_trigger">[[+trigger]]</a>
			<img src="http://st.bezumkin.ru/files/8/3/3/8331d0647f1caccaa2d134de73d47bbb.gif" class="as_spinner" style="width:32px;margin:auto;display:none;">
		</div>';}
		if (empty($as_trigger)) {
			$as_trigger = $modx->lexicon('as_trigger');
		}

		$modx->regClientScript(preg_replace('/(\t|\n)/', '','
		<script type="text/javascript">
			$(document).on("click", ".as_trigger", function(e) {
				var spinner = $(this).parent().find(".as_spinner");
				spinner.css("display","block");
				$(this).remove();
				'.$script.'
				return false;
			});
		</script>'), true);
		$cache->set($cache_key . $key, $scriptProperties);
		$output = str_replace(array('[[+key]]','[[+trigger]]'), array($key, $as_trigger), $wrapper);
		break;

	case 'onload':
	default:
		if (empty($wrapper)) {$wrapper = '<div id="[[+key]]" class="ajax-snippet">
			<img src="http://st.bezumkin.ru/files/8/3/3/8331d0647f1caccaa2d134de73d47bbb.gif" class="as_spinner" style="width:32px;margin:auto;display:block;">
		</div>';}

		$modx->regClientScript(preg_replace('/(\t|\n)/', '','
		<script type="text/javascript">
			$(document).ready(function() {
				var spinner = $(this).parent().find(".as_spinner");
				'.$script.'
			});
		</script>'), true);
		$cache->set($cache_key . $key, $scriptProperties);
		$output = str_replace('[[+key]]', $key, $wrapper);
}

return $output;
