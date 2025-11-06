<?php
/**
 * PHP file to render the block on server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @var array<mixed> $attributes The block attributes.
 * @var string       $content The block content.
 * @var WP_Block     $block The block.
 *
 * @package OneNovantaTheme\Blocks
 */

use OneNovanta\Controllers\Common\Template;

$wrapper_attributes = get_block_wrapper_attributes(
	[
		'class' => 'header-search',
	]
);
?>

<novanta-search <?php one_novanta_kses_post_e( $wrapper_attributes ); ?>>
	<form
		action="<?php echo esc_url( home_url( '/' ) ); ?>"
		method="get"
		class="header-search__form"
		role="search"
	>
		<input
			type="text"
			name="s"
			class="header-search__input"
			placeholder="<?php echo esc_attr__( 'Search...', 'one-novanta-theme' ); ?>"
			aria-label="Search"
			autocomplete="off"
		/>
		<button type="button" class="header-search__clear header-search__clear--hidden">
			<?php esc_html_e( 'clear', 'one-novanta-theme' ); ?>
		</button>
		<!-- This interactive button will be displayed on the desktop device -->
		<button type="button" class="header-search__button header-search__button-handler" aria-label="<?php esc_attr_e( 'Search button for desktop', 'one-novanta-theme' ); ?>">
			<span class="header-search__search-icon">
				<?php
				Template::render_component(
					'svg',
					null,
					[ 'name' => 'search' ],
				);
				?>
			</span>
			<span class="header-search__close-icon">
				<?php
				Template::render_component(
					'svg',
					null,
					[ 'name' => 'close-alt' ],
				);
				?>
			</span>
		</button>
		<!-- This search button will be displayed on the mobile device -->
		<button type="submit" class="header-search__button header-search__button-submit" aria-label="<?php esc_attr_e( 'Search button for mobile', 'one-novanta-theme' ); ?>">
			<?php
			Template::render_component(
				'svg',
				null,
				[ 'name' => 'search' ],
			);
			?>
		</button>
	</form>
</novanta-search>
