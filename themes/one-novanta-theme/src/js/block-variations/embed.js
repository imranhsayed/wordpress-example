/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import domReady from '@wordpress/dom-ready';
import { registerBlockVariation } from '@wordpress/blocks';
import { G, Path, SVG } from '@wordpress/components';

const wistiaLogo = (
	<SVG height="80" role="img" viewBox="0 0 36 34" className="jsx-1373105934 WistiaLogo">
		<G fill="hsla(230, 78%, 53%, 1)">
			<Path d="m16.4 22.7h-5.3c-1.6 0-3.1.7-4.2 1.9l-6.7 7.7c4.9.3 9.9.3 13.5.3 18.7 0 21.3-11.5 21.3-16.9-1.6 2-6.2 7-18.6 7zm16.3-17.4c-.1.9-.6 4.8-11.5 4.8-8.9 0-12.4 0-21.2-.2l6.5 7.5c1.3 1.5 3.1 2.3 5 2.3 2.2 0 5.1.1 5.6.1 11.2 0 17.5-5.1 17.5-10.1.1-1.9-.6-3.4-1.9-4.4z"></Path>
		</G>
	</SVG> );

domReady( () => {
	// Register a custom block variation for the core/gallery block
	registerBlockVariation(
		'core/embed',
		{
			name: 'wistia',
			title: __( 'Wistia Embed', 'one-novanta-theme' ),
			description: __(
				'Embed a Wistia video.',
				'one-novanta-theme',
			),
			icon: wistiaLogo,
			category: 'one-novanta',
			patterns: [
				/https?:\/\/(.+)?(wistia.com|wi.st)\/(medias|embed)\/.*/,
			],
			attributes: { providerNameSlug: 'wistia', responsive: true },
		},
	);
} );
