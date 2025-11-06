<?php
/**
 * ACF fields for the block.
 *
 * @package one-novanta-theme
 */

acf_add_local_field_group(
	[
		'key'                   => 'group_680662aa9b943',
		'title'                 => 'Documents',
		'fields'                => [
			[
				'key'                  => 'documents',
				'label'                => 'Documents and Downloads',
				'name'                 => 'documents',
				'aria-label'           => '',
				'type'                 => 'relationship',
				'instructions'         => '',
				'required'             => 0,
				'conditional_logic'    => 0,
				'wrapper'              => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'post_type'            => [
					0 => 'novanta_document',
				],
				'post_status'          => [
					0 => 'publish',
				],
				'taxonomy'             => '',
				'filters'              => [
					0 => 'search',
				],
				'return_format'        => 'id',
				'min'                  => '',
				'max'                  => '',
				'allow_in_bindings'    => 1,
				'elements'             => '',
				'bidirectional'        => 0,
				'bidirectional_target' => [],
			],
		],
		'location'              => [
			[
				[
					'param'    => 'block',
					'operator' => '==',
					'value'    => 'one-novanta/documents',
				],
			],
		],
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 0,
	]
);
