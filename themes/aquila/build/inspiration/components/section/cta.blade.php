@props( [
	'url'        => '',
	'text'       => '',
	'new_window' => false,
	'class'      => '',
	'color'      => '',
	'appearance' => '',
] )

@php
	if ( empty( $slot ) ) {
		return;
	}

	$classes = [ 'section__cta-button' ];

	if ( ! empty( $class ) ) {
		$classes[] = $class;
	}
@endphp

<div @class( $classes )>
	<x-button
		href="{{ $url }}"
		:target="! empty( $new_window ) ? '_blank' : ''"
		:color="$color ?? ''"
		:appearance="$appearance ? $appearance : 'outline'"
	>
		<x-escape :content="$text" />
	</x-button>
</div>
