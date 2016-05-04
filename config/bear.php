<?php

return [

	'title' => 'Bear Content',

	'layouts' => [
		[
			'id'          => 'pagerightsidebarfeature',
			'image'       => '/vendor/bear/images/pagerightsidebarfeature.png',
			'description' => 'Right sidebar page with feature image',
		],
		[
			'id'          => 'pagerightsidebar',
			'image'       => '/vendor/bear/images/pagerightsidebar.png',
			'description' => 'Right sidebar page without feature image',
		],
		[
			'id'          => 'pageleftsidebarfeature',
			'image'       => '/vendor/bear/images/pageleftsidebarfeature.png',
			'description' => 'Left sidebar page with feature image',
		],
		[
			'id'          => 'pageleftsidebar',
			'image'       => '/vendor/bear/images/pageleftsidebar.png',
			'description' => 'Left sidebar page without feature image',
		],
		[
			'id'          => 'pagefullfeature',
			'image'       => '/vendor/bear/images/pagefullfeature.png',
			'description' => 'Full width page with feature image',
		],
		[
			'id'          => 'pagefull',
			'image'       => '/vendor/bear/images/pagefull.png',
			'description' => 'Full width page without feature image',
		],
	],

	'page_entities' => [
		'home'    => 'Landing Pages',
		'content' => 'Content Pages',
	],

	'content_models' => [
		'section' => Rudivdme\BearContent\Models\PageSection::class,
		'widget'  => Rudivdme\BearContent\Models\PageWidget::class,
		'page'    => Rudivdme\BearContent\Models\Page::class,
	],
];
