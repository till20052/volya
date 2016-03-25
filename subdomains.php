<?php

header("Access-Control-Allow-Origin: *");

return [
	'if.volya.ua' => [
		'module' => 'cells1'
	],
	'if.volya.dev' => [
		'module' => 'cells1'
	],
	'cdi.volya.ua' => [
		'module' => 'projects',
		'controller' => 'Cdi'
	]
];
