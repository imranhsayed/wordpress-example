@php
	if ( empty( $slot ) ) {
		return;
	}
@endphp

<div class="section__description">
	<x-content :content="$slot ?? ''" />
</div>
