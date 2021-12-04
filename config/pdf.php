<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
	'font_path' => base_path('resources/fonts/'),
	'font_data' => [
		'Inconsolata' => [
			'R'  => 'Inconsolata-Regular.ttf',    // regular font
			'B'  => 'Inconsolata-Bold.ttf',       // optional: bold font
		]
	
	]
];
