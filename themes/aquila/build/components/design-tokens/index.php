<?php
/**
 * Component Design Tokens
 *
 * @component Design Tokens
 * @description A comprehensive design system showcasing all design tokens including colors, typography, spacing, shadows, and more.
 * @group Design System
 * @props {
 *     "section": {"type": "string", "default": "all", "options": ["all", "colors", "headings", "paragraphs", "font-size", "line-height", "letter-spacing", "font-weight", "border-radius", "shadows"], "description": "Which section to display"}
 * }
 * @variations {
 *   "all": {"section": "all"},
 *   "colors": {"section": "colors"},
 *   "headings": {"section": "headings"},
 *   "paragraphs": {"section": "paragraphs"},
 *   "font-size": {"section": "font-size"},
 *   "line-height": {"section": "line-height"},
 *   "letter-spacing": {"section": "letter-spacing"},
 *   "font-weight": {"section": "font-weight"},
 *   "border-radius": {"section": "border-radius"},
 *   "shadows": {"section": "shadows"}
 * }
 * @package Aquila
 */

$section = $args['section'] ?? 'all';
?>

<div class="design-tokens">
	<?php if ( 'all' === $section || 'colors' === $section ) : ?>
		<!-- Colors Section -->
		<section class="design-tokens__section">
			<h2 class="design-tokens__section-title">Color Palette</h2>

			<!-- Primary Solids / Natives -->
			<div class="design-tokens__category">
				<h3 class="design-tokens__category-title">Primary Solids / Natives</h3>
				<div class="design-tokens__grid">
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-bunker)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Bunker</span>
							<span class="design-tokens__color-value">#242F3A</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-bunker-dark)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Bunker - Dark</span>
							<span class="design-tokens__color-value">#181D1B</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-tan)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Tan</span>
							<span class="design-tokens__color-value">#CCBB8D</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-tan-dark)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Tan - Dark</span>
							<span class="design-tokens__color-value">#A08F73</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-sand)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Sand</span>
							<span class="design-tokens__color-value">#E6E6E6</span>
						</div>
					</div>
				</div>
			</div>

			<!-- Blues -->
			<div class="design-tokens__category">
				<h3 class="design-tokens__category-title">Blues</h3>
				<div class="design-tokens__grid">
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-navy)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Navy</span>
							<span class="design-tokens__color-value">#043357</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-navy-dark)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Navy - Dark</span>
							<span class="design-tokens__color-value">#031E33</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-sky-blue)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Sky Blue</span>
							<span class="design-tokens__color-value">#B2E1FC</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-sky-blue-dark)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Sky Blue - Dark</span>
							<span class="design-tokens__color-value">#A3DDFC</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-blue)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Blue</span>
							<span class="design-tokens__color-value">#1DA6A6</span>
						</div>
					</div>
				</div>
			</div>

			<!-- Grayscale -->
			<div class="design-tokens__category">
				<h3 class="design-tokens__category-title">Grayscale</h3>
				<div class="design-tokens__grid design-tokens__grid--grayscale">
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-black)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Black</span>
							<span class="design-tokens__color-value">#000000</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-gray-900)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Gray 900</span>
							<span class="design-tokens__color-value">#3F3F3F</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-gray-800)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Gray 800</span>
							<span class="design-tokens__color-value">#595959</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-gray-700)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Gray 700</span>
							<span class="design-tokens__color-value">#808080</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-gray-600)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Gray 600</span>
							<span class="design-tokens__color-value">#9E9E9E</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-gray-500)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Gray 500</span>
							<span class="design-tokens__color-value">#BDBDBD</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-gray-400)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Gray 400</span>
							<span class="design-tokens__color-value">#D6D6D6</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-gray-300)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Gray 300</span>
							<span class="design-tokens__color-value">#DEDEDE</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-gray-200)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Gray 200</span>
							<span class="design-tokens__color-value">#F0F0F0</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-gray-100)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Gray 100</span>
							<span class="design-tokens__color-value">#F9F9F9</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch design-tokens__color-swatch--bordered" style="background-color: var(--color-white)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">White</span>
							<span class="design-tokens__color-value">#FFFFFF</span>
						</div>
					</div>
				</div>
			</div>

			<!-- Accent Colors -->
			<div class="design-tokens__category">
				<h3 class="design-tokens__category-title">Accent Colors</h3>
				<div class="design-tokens__grid">
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-green)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Green</span>
							<span class="design-tokens__color-value">#4EA690</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-red)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Red</span>
							<span class="design-tokens__color-value">#D24567</span>
						</div>
					</div>
					<div class="design-tokens__color-item">
						<div class="design-tokens__color-swatch" style="background-color: var(--color-yellow)"></div>
						<div class="design-tokens__color-info">
							<span class="design-tokens__color-name">Yellow</span>
							<span class="design-tokens__color-value">#DCBA71</span>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( 'all' === $section || 'headings' === $section ) : ?>
		<!-- Headings Section -->
		<section class="design-tokens__section">
			<h2 class="design-tokens__section-title">Headings</h2>
			<div class="design-tokens__category">
				<div class="design-tokens__typography-list">
					<div class="design-tokens__typography-item">
						<div class="design-tokens__typography-meta">
							<span class="design-tokens__typography-name">H1 Headline</span>
							<div class="design-tokens__typography-specs">
								<span>Font: Domaine Display</span>
								<span>Size: 64px</span>
								<span>Weight: Medium</span>
								<span>Line Height: 72px</span>
								<span>Letter Spacing: -1%</span>
							</div>
						</div>
						<h1 class="design-tokens__typography-sample design-tokens__h1">H1 Headline</h1>
					</div>

					<div class="design-tokens__typography-item">
						<div class="design-tokens__typography-meta">
							<span class="design-tokens__typography-name">H2 Headline</span>
							<div class="design-tokens__typography-specs">
								<span>Font: Domaine Display</span>
								<span>Size: 48px</span>
								<span>Weight: Medium</span>
								<span>Line Height: 56px</span>
								<span>Letter Spacing: -1%</span>
							</div>
						</div>
						<h2 class="design-tokens__typography-sample design-tokens__h2">H2 Headline</h2>
					</div>

					<div class="design-tokens__typography-item">
						<div class="design-tokens__typography-meta">
							<span class="design-tokens__typography-name">H3 Headline</span>
							<div class="design-tokens__typography-specs">
								<span>Font: Domaine Display</span>
								<span>Size: 36px</span>
								<span>Weight: Medium</span>
								<span>Line Height: 44px</span>
								<span>Letter Spacing: 0%</span>
							</div>
						</div>
						<h3 class="design-tokens__typography-sample design-tokens__h3">H3 Headline</h3>
					</div>

					<div class="design-tokens__typography-item">
						<div class="design-tokens__typography-meta">
							<span class="design-tokens__typography-name">H4 Headline</span>
							<div class="design-tokens__typography-specs">
								<span>Font: Domaine Display</span>
								<span>Size: 24px</span>
								<span>Weight: Medium</span>
								<span>Line Height: 32px</span>
								<span>Letter Spacing: 0%</span>
							</div>
						</div>
						<h4 class="design-tokens__typography-sample design-tokens__h4">H4 Headline</h4>
					</div>

					<div class="design-tokens__typography-item">
						<div class="design-tokens__typography-meta">
							<span class="design-tokens__typography-name">H5 Headline</span>
							<div class="design-tokens__typography-specs">
								<span>Font: Domaine Display</span>
								<span>Size: 18px</span>
								<span>Weight: Medium</span>
								<span>Line Height: 24px</span>
								<span>Letter Spacing: 0%</span>
							</div>
						</div>
						<h5 class="design-tokens__typography-sample design-tokens__h5">H5 Headline</h5>
					</div>

					<div class="design-tokens__typography-item">
						<div class="design-tokens__typography-meta">
							<span class="design-tokens__typography-name">H6 Headline</span>
							<div class="design-tokens__typography-specs">
								<span>Font: Domaine Display</span>
								<span>Size: 16px</span>
								<span>Weight: Medium</span>
								<span>Line Height: 24px</span>
								<span>Letter Spacing: 0%</span>
							</div>
						</div>
						<h6 class="design-tokens__typography-sample design-tokens__h6">H6 Headline</h6>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( 'all' === $section || 'paragraphs' === $section ) : ?>
		<!-- Paragraphs Section -->
		<section class="design-tokens__section">
			<h2 class="design-tokens__section-title">Paragraphs</h2>
			<div class="design-tokens__category">
				<div class="design-tokens__typography-list">
					<div class="design-tokens__typography-item">
						<div class="design-tokens__typography-meta">
							<span class="design-tokens__typography-name">Body Text Large - XL</span>
							<div class="design-tokens__typography-specs">
								<span>Font: Untitled Sans</span>
								<span>Size: 20px</span>
								<span>Weight: Regular</span>
								<span>Line Height: 32px</span>
								<span>Letter Spacing: 0%</span>
							</div>
						</div>
						<p class="design-tokens__typography-sample design-tokens__body-xl">Lorem ipsum dolor sit, consectetur adipiscing elit. Vestibulum ex erat, maximus eget erat sagittis, lobortis condimentum ipsum. Aliquam luctus ante ut mi convallis ultrices. Integer vitae ante et enim fermentum hendrerit. Suspendisse ut elementum sem. Donec a condimentum dolor consequat, sed vehicula ex.</p>
					</div>

					<div class="design-tokens__typography-item">
						<div class="design-tokens__typography-meta">
							<span class="design-tokens__typography-name">Body Text Large - L</span>
							<div class="design-tokens__typography-specs">
								<span>Font: Untitled Sans</span>
								<span>Size: 18px</span>
								<span>Weight: Regular</span>
								<span>Line Height: 28px</span>
								<span>Letter Spacing: 0%</span>
							</div>
						</div>
						<p class="design-tokens__typography-sample design-tokens__body-lg">Lorem ipsum dolor sit, consectetur adipiscing elit. Vestibulum ex erat, maximus eget erat sagittis, lobortis condimentum ipsum. Aliquam luctus ante ut mi convallis ultrices. Integer vitae ante et enim fermentum hendrerit. Suspendisse ut elementum sem. Donec a condimentum dolor consequat, sed vehicula ex.</p>
					</div>

					<div class="design-tokens__typography-item">
						<div class="design-tokens__typography-meta">
							<span class="design-tokens__typography-name">Body Text Standard - XL</span>
							<div class="design-tokens__typography-specs">
								<span>Font: Untitled Sans</span>
								<span>Size: 16px</span>
								<span>Weight: Regular</span>
								<span>Line Height: 24px</span>
								<span>Letter Spacing: 0%</span>
							</div>
						</div>
						<p class="design-tokens__typography-sample design-tokens__body-md">Lorem ipsum dolor sit, consectetur adipiscing elit. Vestibulum ex erat, maximus eget erat sagittis, lobortis condimentum ipsum. Aliquam luctus ante ut mi convallis ultrices. Integer vitae ante et enim fermentum hendrerit. Suspendisse ut elementum sem. Donec a condimentum dolor consequat, sed vehicula ex.</p>
					</div>

					<div class="design-tokens__typography-item">
						<div class="design-tokens__typography-meta">
							<span class="design-tokens__typography-name">Body Text Standard - S</span>
							<div class="design-tokens__typography-specs">
								<span>Font: Untitled Sans</span>
								<span>Size: 14px</span>
								<span>Weight: Regular</span>
								<span>Line Height: 20px</span>
								<span>Letter Spacing: 0%</span>
							</div>
						</div>
						<p class="design-tokens__typography-sample design-tokens__body-sm">Lorem ipsum dolor sit, consectetur adipiscing elit. Vestibulum ex erat, maximus eget erat sagittis, lobortis condimentum ipsum. Aliquam luctus ante ut mi convallis ultrices. Integer vitae ante et enim fermentum hendrerit. Suspendisse ut elementum sem. Donec a condimentum dolor consequat, sed vehicula ex.</p>
					</div>

					<div class="design-tokens__typography-item">
						<div class="design-tokens__typography-meta">
							<span class="design-tokens__typography-name">Body Text Tiny - XS</span>
							<div class="design-tokens__typography-specs">
								<span>Font: Untitled Sans</span>
								<span>Size: 12px</span>
								<span>Weight: Regular</span>
								<span>Line Height: 16px</span>
								<span>Letter Spacing: 0%</span>
							</div>
						</div>
						<p class="design-tokens__typography-sample design-tokens__body-xs">Lorem ipsum dolor sit, consectetur adipiscing elit. Vestibulum ex erat, maximus eget erat sagittis, lobortis condimentum ipsum. Aliquam luctus ante ut mi convallis ultrices. Integer vitae ante et enim fermentum hendrerit. Suspendisse ut elementum sem. Donec a condimentum dolor consequat, sed vehicula ex.</p>
					</div>

					<div class="design-tokens__typography-item">
						<div class="design-tokens__typography-meta">
							<span class="design-tokens__typography-name">UI Text Large - XL</span>
							<div class="design-tokens__typography-specs">
								<span>Font: Untitled Sans</span>
								<span>Size: 18px</span>
								<span>Weight: Medium</span>
								<span>Line Height: 24px</span>
								<span>Letter Spacing: 0%</span>
							</div>
						</div>
						<p class="design-tokens__typography-sample design-tokens__ui-lg">LOREM IPSUM DOLOR SIT AMET</p>
					</div>

					<div class="design-tokens__typography-item">
						<div class="design-tokens__typography-meta">
							<span class="design-tokens__typography-name">UI Text Large - L</span>
							<div class="design-tokens__typography-specs">
								<span>Font: Untitled Sans</span>
								<span>Size: 16px</span>
								<span>Weight: Medium</span>
								<span>Line Height: 24px</span>
								<span>Letter Spacing: 0%</span>
							</div>
						</div>
						<p class="design-tokens__typography-sample design-tokens__ui-md">LOREM IPSUM DOLOR SIT AMET</p>
					</div>

					<div class="design-tokens__typography-item">
						<div class="design-tokens__typography-meta">
							<span class="design-tokens__typography-name">UI Text Standard - XL</span>
							<div class="design-tokens__typography-specs">
								<span>Font: Untitled Sans</span>
								<span>Size: 14px</span>
								<span>Weight: Medium</span>
								<span>Line Height: 20px</span>
								<span>Letter Spacing: 2%</span>
							</div>
						</div>
						<p class="design-tokens__typography-sample design-tokens__ui-sm">LOREM IPSUM DOLOR SIT AMET</p>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( 'all' === $section || 'font-size' === $section ) : ?>
		<!-- Font Size Section -->
		<section class="design-tokens__section">
			<h2 class="design-tokens__section-title">Font Size</h2>
			<div class="design-tokens__category">
				<div class="design-tokens__size-list">
					<div class="design-tokens__size-item">
						<div class="design-tokens__size-example">
							<div class="design-tokens__size-sample" style="font-size: 64px; line-height: 1.2;">Quick brown fox</div>
							<div class="design-tokens__size-meta">2.25rem / 36px</div>
						</div>
						<div class="design-tokens__size-info">
							<span class="design-tokens__size-name">Font Size XXXL</span>
							<span class="design-tokens__size-description">This is the xxx-large font size.</span>
						</div>
						<div class="design-tokens__size-token">
							<span class="design-tokens__token-var">var(--font-size-xxxl)</span>
						</div>
					</div>

					<div class="design-tokens__size-item">
						<div class="design-tokens__size-example">
							<div class="design-tokens__size-sample" style="font-size: 48px; line-height: 1.2;">Quick brown fox</div>
							<div class="design-tokens__size-meta">1.5rem / 24px</div>
						</div>
						<div class="design-tokens__size-info">
							<span class="design-tokens__size-name">Font Size XXL</span>
							<span class="design-tokens__size-description">This is the xx-large font size.</span>
						</div>
						<div class="design-tokens__size-token">
							<span class="design-tokens__token-var">var(--font-size-xxl)</span>
						</div>
					</div>

					<div class="design-tokens__size-item">
						<div class="design-tokens__size-example">
							<div class="design-tokens__size-sample" style="font-size: 36px; line-height: 1.2;">Quick brown fox</div>
							<div class="design-tokens__size-meta">1.25rem / 20px</div>
						</div>
						<div class="design-tokens__size-info">
							<span class="design-tokens__size-name">Font Size XL</span>
							<span class="design-tokens__size-description">This is the x-large font size.</span>
						</div>
						<div class="design-tokens__size-token">
							<span class="design-tokens__token-var">var(--font-size-xl)</span>
						</div>
					</div>

					<div class="design-tokens__size-item">
						<div class="design-tokens__size-example">
							<div class="design-tokens__size-sample" style="font-size: 20px; line-height: 1.2;">Quick brown fox</div>
							<div class="design-tokens__size-meta">1rem / 16px</div>
						</div>
						<div class="design-tokens__size-info">
							<span class="design-tokens__size-name">Font Size L</span>
							<span class="design-tokens__size-description">This is the large font size.</span>
						</div>
						<div class="design-tokens__size-token">
							<span class="design-tokens__token-var">var(--font-size-l)</span>
						</div>
					</div>

					<div class="design-tokens__size-item">
						<div class="design-tokens__size-example">
							<div class="design-tokens__size-sample" style="font-size: 16px; line-height: 1.2;">Quick brown fox</div>
							<div class="design-tokens__size-meta">0.875rem / 14px</div>
						</div>
						<div class="design-tokens__size-info">
							<span class="design-tokens__size-name">Font Size M</span>
							<span class="design-tokens__size-description">This is the base font size.</span>
						</div>
						<div class="design-tokens__size-token">
							<span class="design-tokens__token-var">var(--font-size-m)</span>
						</div>
					</div>

					<div class="design-tokens__size-item">
						<div class="design-tokens__size-example">
							<div class="design-tokens__size-sample" style="font-size: 14px; line-height: 1.2;">Quick brown fox</div>
							<div class="design-tokens__size-meta">0.75rem / 12px</div>
						</div>
						<div class="design-tokens__size-info">
							<span class="design-tokens__size-name">Font Size S</span>
							<span class="design-tokens__size-description">This is the small font size.</span>
						</div>
						<div class="design-tokens__size-token">
							<span class="design-tokens__token-var">var(--font-size-s)</span>
						</div>
					</div>

					<div class="design-tokens__size-item">
						<div class="design-tokens__size-example">
							<div class="design-tokens__size-sample" style="font-size: 12px; line-height: 1.2;">Quick brown fox</div>
							<div class="design-tokens__size-meta">0.6875rem / 11px</div>
						</div>
						<div class="design-tokens__size-info">
							<span class="design-tokens__size-name">Font Size XS</span>
							<span class="design-tokens__size-description">This is the x-small font size.</span>
						</div>
						<div class="design-tokens__size-token">
							<span class="design-tokens__token-var">var(--font-size-xs)</span>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( 'all' === $section || 'line-height' === $section ) : ?>
		<!-- Line Height Section -->
		<section class="design-tokens__section">
			<h2 class="design-tokens__section-title">Line Height</h2>
			<div class="design-tokens__category">
				<div class="design-tokens__lineheight-list">
					<div class="design-tokens__lineheight-item">
						<div class="design-tokens__lineheight-example">
							<div class="design-tokens__lineheight-sample">1.15</div>
							<div class="design-tokens__lineheight-meta">1.15 renders as 16.1px with 14px font.</div>
						</div>
						<div class="design-tokens__lineheight-info">
							<span class="design-tokens__lineheight-name">Line Height Tight</span>
							<span class="design-tokens__lineheight-description">This token can be used when you don't want line height taking any extra space.</span>
						</div>
						<div class="design-tokens__lineheight-token">
							<span class="design-tokens__token-var">var(--line-height-tight)</span>
						</div>
					</div>

					<div class="design-tokens__lineheight-item">
						<div class="design-tokens__lineheight-example">
							<div class="design-tokens__lineheight-sample">1.2</div>
							<div class="design-tokens__lineheight-meta">1.2 renders as 16.8px with 14px font.</div>
						</div>
						<div class="design-tokens__lineheight-info">
							<span class="design-tokens__lineheight-name">Line Height Heading</span>
							<span class="design-tokens__lineheight-description">This is the default line height for headings.</span>
						</div>
						<div class="design-tokens__lineheight-token">
							<span class="design-tokens__token-var">var(--line-height-heading)</span>
						</div>
					</div>

					<div class="design-tokens__lineheight-item">
						<div class="design-tokens__lineheight-example">
							<div class="design-tokens__lineheight-sample">1.3</div>
							<div class="design-tokens__lineheight-meta">1.3 renders as 18.2px with 14px font.</div>
						</div>
						<div class="design-tokens__lineheight-info">
							<span class="design-tokens__lineheight-name">Line Height Caption</span>
							<span class="design-tokens__lineheight-description">This is the default line height for captions, hint texts and form errors.</span>
						</div>
						<div class="design-tokens__lineheight-token">
							<span class="design-tokens__token-var">var(--line-height-caption)</span>
						</div>
					</div>

					<div class="design-tokens__lineheight-item">
						<div class="design-tokens__lineheight-example">
							<div class="design-tokens__lineheight-sample">1.5</div>
							<div class="design-tokens__lineheight-meta">1.5 renders as 21px with 14px font.</div>
						</div>
						<div class="design-tokens__lineheight-info">
							<span class="design-tokens__lineheight-name">Line Height</span>
							<span class="design-tokens__lineheight-description">This is the default line height for body text.</span>
						</div>
						<div class="design-tokens__lineheight-token">
							<span class="design-tokens__token-var">var(--line-height)</span>
						</div>
					</div>

					<div class="design-tokens__lineheight-item">
						<div class="design-tokens__lineheight-example">
							<div class="design-tokens__lineheight-sample">20px</div>
							<div class="design-tokens__lineheight-meta">20px renders as 20px with 14px font.</div>
						</div>
						<div class="design-tokens__lineheight-info">
							<span class="design-tokens__lineheight-name">Line Height Form</span>
							<span class="design-tokens__lineheight-description">This is the default line height for form inputs, textareas and buttons.</span>
						</div>
						<div class="design-tokens__lineheight-token">
							<span class="design-tokens__token-var">var(--line-height-form)</span>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( 'all' === $section || 'letter-spacing' === $section ) : ?>
		<!-- Letter Spacing Section -->
		<section class="design-tokens__section">
			<h2 class="design-tokens__section-title">Letter Spacing</h2>

			<!-- Heading Letter Spacing -->
			<div class="design-tokens__category">
				<h3 class="design-tokens__category-title">Headings</h3>
				<div class="design-tokens__token-list">
					<div class="design-tokens__token-item">
						<span class="design-tokens__token-name">H1</span>
						<span class="design-tokens__token-value">-1%</span>
						<span class="design-tokens__token-var">var(--letter-spacing-h1)</span>
					</div>
					<div class="design-tokens__token-item">
						<span class="design-tokens__token-name">H2</span>
						<span class="design-tokens__token-value">-1%</span>
						<span class="design-tokens__token-var">var(--letter-spacing-h2)</span>
					</div>
					<div class="design-tokens__token-item">
						<span class="design-tokens__token-name">H3</span>
						<span class="design-tokens__token-value">0%</span>
						<span class="design-tokens__token-var">var(--letter-spacing-h3)</span>
					</div>
					<div class="design-tokens__token-item">
						<span class="design-tokens__token-name">H4</span>
						<span class="design-tokens__token-value">0%</span>
						<span class="design-tokens__token-var">var(--letter-spacing-h4)</span>
					</div>
					<div class="design-tokens__token-item">
						<span class="design-tokens__token-name">H5</span>
						<span class="design-tokens__token-value">0%</span>
						<span class="design-tokens__token-var">var(--letter-spacing-h5)</span>
					</div>
					<div class="design-tokens__token-item">
						<span class="design-tokens__token-name">H6</span>
						<span class="design-tokens__token-value">0%</span>
						<span class="design-tokens__token-var">var(--letter-spacing-h6)</span>
					</div>
				</div>
			</div>

			<!-- UI Letter Spacing -->
			<div class="design-tokens__category">
				<h3 class="design-tokens__category-title">UI Text</h3>
				<div class="design-tokens__token-list">
					<div class="design-tokens__token-item">
						<span class="design-tokens__token-name">UI Text</span>
						<span class="design-tokens__token-value">2%</span>
						<span class="design-tokens__token-var">var(--letter-spacing-ui)</span>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( 'all' === $section || 'font-weight' === $section ) : ?>
		<!-- Font Weight Section -->
		<section class="design-tokens__section">
			<h2 class="design-tokens__section-title">Font Weight</h2>
			<div class="design-tokens__category">
				<div class="design-tokens__token-list">
					<div class="design-tokens__token-item">
						<span class="design-tokens__token-name">Regular</span>
						<span class="design-tokens__token-value">400</span>
						<span class="design-tokens__token-var">var(--font-weight-regular)</span>
					</div>
					<div class="design-tokens__token-item">
						<span class="design-tokens__token-name">Medium</span>
						<span class="design-tokens__token-value">500</span>
						<span class="design-tokens__token-var">var(--font-weight-medium)</span>
					</div>
					<div class="design-tokens__token-item">
						<span class="design-tokens__token-name">Bold</span>
						<span class="design-tokens__token-value">700</span>
						<span class="design-tokens__token-var">var(--font-weight-bold)</span>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( 'all' === $section || 'border-radius' === $section ) : ?>
		<!-- Border Radius Section -->
		<section class="design-tokens__section">
			<h2 class="design-tokens__section-title">Border Radius</h2>
			<div class="design-tokens__category">
				<div class="design-tokens__border-radius-list">
					<div class="design-tokens__border-radius-item">
						<div class="design-tokens__border-radius-swatch design-tokens__border-radius-swatch--sharp"></div>
						<div class="design-tokens__border-radius-info">
							<span class="design-tokens__border-radius-name">Border Radius Sharp</span>
							<span class="design-tokens__border-radius-value">0.02em</span>
							<span class="design-tokens__border-radius-token">var(--border-radius-sharp)</span>
						</div>
					</div>

					<div class="design-tokens__border-radius-item">
						<div class="design-tokens__border-radius-swatch design-tokens__border-radius-swatch--small"></div>
						<div class="design-tokens__border-radius-info">
							<span class="design-tokens__border-radius-name">Border Radius Small</span>
							<span class="design-tokens__border-radius-value">3px</span>
							<span class="design-tokens__border-radius-token">var(--border-radius-s)</span>
						</div>
					</div>

					<div class="design-tokens__border-radius-item">
						<div class="design-tokens__border-radius-swatch design-tokens__border-radius-swatch--default"></div>
						<div class="design-tokens__border-radius-info">
							<span class="design-tokens__border-radius-name">Border Radius</span>
							<span class="design-tokens__border-radius-value">5px</span>
							<span class="design-tokens__border-radius-token">var(--border-radius)</span>
						</div>
					</div>

					<div class="design-tokens__border-radius-item">
						<div class="design-tokens__border-radius-swatch design-tokens__border-radius-swatch--pill"></div>
						<div class="design-tokens__border-radius-info">
							<span class="design-tokens__border-radius-name">Border Radius Pill</span>
							<span class="design-tokens__border-radius-value">999px</span>
							<span class="design-tokens__border-radius-token">var(--border-radius-pill)</span>
						</div>
					</div>

					<div class="design-tokens__border-radius-item">
						<div class="design-tokens__border-radius-swatch design-tokens__border-radius-swatch--circle"></div>
						<div class="design-tokens__border-radius-info">
							<span class="design-tokens__border-radius-name">Border Radius Circle</span>
							<span class="design-tokens__border-radius-value">50%</span>
							<span class="design-tokens__border-radius-token">var(--border-radius-circle)</span>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( 'all' === $section || 'shadows' === $section ) : ?>
		<!-- Box Shadow Section -->
		<section class="design-tokens__section">
			<h2 class="design-tokens__section-title">Box Shadow</h2>
			<div class="design-tokens__category">
				<div class="design-tokens__shadow-list">
					<div class="design-tokens__shadow-item">
						<div class="design-tokens__shadow-swatch design-tokens__shadow-swatch--default"></div>
						<div class="design-tokens__shadow-info">
							<span class="design-tokens__shadow-name">Box Shadow</span>
							<span class="design-tokens__shadow-value">0 1px 3px rgba(12, 12, 12, 0.09)</span>
							<span class="design-tokens__shadow-token">var(--box-shadow)</span>
							<span class="design-tokens__shadow-description">Default box shadow. Used with buttons, active states, and such.</span>
						</div>
					</div>

					<div class="design-tokens__shadow-item">
						<div class="design-tokens__shadow-swatch design-tokens__shadow-swatch--header"></div>
						<div class="design-tokens__shadow-info">
							<span class="design-tokens__shadow-name">Box Shadow Header</span>
							<span class="design-tokens__shadow-value">0 1px 5px rgba(12, 12, 12, 0.05)</span>
							<span class="design-tokens__shadow-token">var(--box-shadow-header)</span>
							<span class="design-tokens__shadow-description">Default box shadow for header component.</span>
						</div>
					</div>

					<div class="design-tokens__shadow-item">
						<div class="design-tokens__shadow-swatch design-tokens__shadow-swatch--card"></div>
						<div class="design-tokens__shadow-info">
							<span class="design-tokens__shadow-name">Box Shadow Card</span>
							<span class="design-tokens__shadow-value">0 0 0 1px var(--n-color-border), 0 1px 5px rgba(12, 12, 12, 0.05), 0 0 40px rgba(12, 12, 12, 0.015)</span>
							<span class="design-tokens__shadow-token">var(--box-shadow-card)</span>
							<span class="design-tokens__shadow-description">Default box shadow for card component that creates drop shadow, raised surface, and a border around the card.</span>
						</div>
					</div>

					<div class="design-tokens__shadow-item">
						<div class="design-tokens__shadow-swatch design-tokens__shadow-swatch--nav"></div>
						<div class="design-tokens__shadow-info">
							<span class="design-tokens__shadow-name">Box Shadow Nav</span>
							<span class="design-tokens__shadow-value">0 0 0 1px var(--n-color-border), 0 5px 17px rgba(12, 12, 12, 0.14)</span>
							<span class="design-tokens__shadow-token">var(--box-shadow-nav)</span>
							<span class="design-tokens__shadow-description">Default box shadow for navigation component. Used in collapsed state.</span>
						</div>
					</div>

					<div class="design-tokens__shadow-item">
						<div class="design-tokens__shadow-swatch design-tokens__shadow-swatch--popout"></div>
						<div class="design-tokens__shadow-info">
							<span class="design-tokens__shadow-name">Box Shadow Popout</span>
							<span class="design-tokens__shadow-value">0 4px 12px rgba(12, 12, 12, 0.15), 0 0 0 1px rgba(0, 0, 0, 0.05)</span>
							<span class="design-tokens__shadow-token">var(--box-shadow-popout)</span>
							<span class="design-tokens__shadow-description">Default box shadow to be used with all pop out windows.</span>
						</div>
					</div>

					<div class="design-tokens__shadow-item">
						<div class="design-tokens__shadow-swatch design-tokens__shadow-swatch--modal"></div>
						<div class="design-tokens__shadow-info">
							<span class="design-tokens__shadow-name">Box Shadow Modal</span>
							<span class="design-tokens__shadow-value">0 0 0 1px var(--n-color-border)</span>
							<span class="design-tokens__shadow-token">var(--box-shadow-modal)</span>
							<span class="design-tokens__shadow-description">Default box shadow for modal component. Used in dialogs, modals, and such.</span>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>
</div>
