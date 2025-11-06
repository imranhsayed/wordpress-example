<?php
/**
 * ACF fields for the Accessories block.
 *
 * @package one-novanta-theme
 */

acf_add_local_field_group(
	[
		'key'                   => 'group_680662aa9b941',
		'title'                 => 'Accessories',
		'fields'                => [
			[
				'key'                  => 'accessories',
				'label'                => 'Accessories',
				'name'                 => 'accessories',
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
					0 => 'product',
				],
				'post_status'          => [
					0 => 'publish',
					1 => 'hidden',
				],
				'taxonomy'             => [
					0 => 'product_type:accessory',
				],
				'filters'              => [
					0 => 'search',
				],
				'return_format'        => 'id',
				'min'                  => '',
				'max'                  => '',
				'allow_in_bindings'    => 0,
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
					'value'    => 'one-novanta/accessories',
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
