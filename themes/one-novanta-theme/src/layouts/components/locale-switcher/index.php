<?php
/**
 * Component Locale Switcher
 *
 * @component Locale Switcher
 * @description A reusable locale switcher component
 * @group UI Elements
 * @props {}
 * @variations {}
 * @example render_component('locale-switcher');
 *
 * @package OneNovantaTheme\Components
 */

use OneNovanta\Controllers\Common\Template;

use function Novanta\Multilingual\get_languages;

// Get the arguments passed to the component.
$wrapper_attributes    = $args['wrapper_attributes'] ?? '';
$current_language_data = $args['current_language_data'] ?? [];
$other_languages_data  = $args['other_languages_data'] ?? [];

// Disable the switcher if there are no items.
$is_disabled = empty( $other_languages_data ) || ! is_array( $other_languages_data );

?>

<one-novanta-theme-locale-switcher
	class="locale-switcher <?php echo $is_disabled ? 'locale-switcher__disabled' : ''; ?>"
	<?php echo esc_attr( $wrapper_attributes ); ?>
	<?php if ( $is_disabled ) : ?>
		data-disabled="true"
	<?php endif; ?>
>
	<button
		class="locale-switcher__button"
		aria-haspopup="listbox"
		aria-expanded="false"
		aria-controls="locale-switcher-list"
		aria-label="Select language"
	>
		<img
			src="<?php echo esc_url( $current_language_data['flag_url'] ?? '' ); ?>"
			alt="<?php esc_attr_e( 'Current language flag', 'one-novanta-theme' ); ?>"
			class="locale-switcher__flag"
		/>

		<span class="locale-switcher__button-arrow">
			<?php
			// SVG Component.
			Template::render_component( 'svg', null, [ 'name' => 'arrow-down' ] );
			?>
		</span>
	</button>

	<?php if ( ! $is_disabled ) : ?>
		<ul
			class="locale-switcher__dropdown"
			role="listbox"
			tabindex="-1"
			aria-labelledby="locale-switcher-toggle"
			hidden
		>
			<?php
			foreach ( $other_languages_data as $language_data ) :
				$url = $language_data['url'];

				// Check if the language code and URL are valid.
				if ( empty( $url ) ) {
					continue;
				}

				// Get the translated name and flag URL for the language.
				$name     = $language_data['label'] ?? '';
				$flag_url = $language_data['flag_url'] ?? '';
				?>
				<li role="option">
					<button
						class="locale-switcher__dropdown-button"
						aria-label="<?php echo esc_attr( sprintf( 'Switch to %s', $name ) ); ?>"
						data-url="<?php echo esc_url( $url ); ?>"
					>
						<img
							src="<?php echo esc_url( $flag_url ); ?>"
							alt="<?php echo esc_attr( $name ); ?> flag"
							class="locale-switcher__flag"
						/>

						<span class="locale-switcher__locale-name">
						<?php echo esc_html( $name ); ?>
					</span>
					</button>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</one-novanta-theme-locale-switcher>
