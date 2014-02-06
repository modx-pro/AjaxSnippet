<?php

$properties = array();

$tmp = array(
	'snippet' => array(
		'type' => 'textfield',
		'value' => 'pdoResources',
	),
	'propertySet' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'wrapper' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'as_mode' => array(
		'type' => 'list',
		'options' => array(
			array('text' => 'OnLoad','value' => 'onload'),
			array('text' => 'OnClick','value' => 'onclick'),
			array('text' => 'None','value' => 'none'),
		),
		'value' => 'onload'
	),
	'as_trigger' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'as_target' => array(
		'type' => 'textfield',
		'value' => '',
	),
);

foreach ($tmp as $k => $v) {
	$properties[] = array_merge(
		array(
			'name' => $k,
			'desc' => PKG_NAME_LOWER . '_prop_' . $k,
			'lexicon' => PKG_NAME_LOWER . ':properties',
		), $v
	);
}

return $properties;
