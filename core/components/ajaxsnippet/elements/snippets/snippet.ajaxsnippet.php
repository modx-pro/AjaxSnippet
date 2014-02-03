<?php
/** @var array $scriptProperties */
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {return;}

if (empty($snippet)) {return 'You must specify snippet!';}
elseif (!$modx->getCount('modSnippet', array('name' => $snippet))) {return 'Could not found snippet "'.$snippet.'"';}

if (!empty($wrapper)) {$wrapper = $modx->getChunk($wrapper);}
if (empty($wrapper)) {$wrapper = '<div id="[[+key]]" class="ajax-snippet">
	<img src="http://st.bezumkin.ru/files/8/3/3/8331d0647f1caccaa2d134de73d47bbb.gif" style="width:32px;margin:auto;display:block;">
</div>';}

/** @var xPDOFileCache $cache */
$cache = $modx->cacheManager->getCacheProvider($modx->getOption('cache_resource_key', null, 'resource'));
$cache_key = $modx->resource->getCacheKey() . '/as/';

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