<?php
// This file is generated. Do not modify it manually.
return array(
	'notice' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'aquila/notice',
		'version' => '1.0.0',
		'title' => 'Notice',
		'category' => 'aquila',
		'example' => array(
			'attributes' => array(
				'content' => 'Attention: This product has been discontinued. An upgraded product is QC-1000.'
			)
		),
		'icon' => 'info-outline',
		'description' => 'A custom notice block for OneNovanta theme.',
		'keywords' => array(
			'aquila',
			'notice',
			'Notice',
			'Novanta'
		),
		'supports' => array(
			'html' => false,
			'align' => array(
				'full',
				'wide'
			),
			'spacing' => array(
				'padding' => true,
				'margin' => true
			),
			'color' => array(
				'background' => true,
				'text' => true
			)
		),
		'attributes' => array(
			'content' => array(
				'type' => 'string',
				'default' => 'Attention: This product has been discontinued. An upgraded product is QC-1000.'
			)
		),
		'textdomain' => 'aquila-theme',
		'editorScript' => 'file:./index.js',
		'style' => 'file:./style.css',
		'render' => 'file:./render.php'
	),
	'todo-list' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/todo-list',
		'version' => '0.1.0',
		'title' => 'Todo List',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'Example block scaffolded with Create Block tool.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'todo-list',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js'
	)
);
