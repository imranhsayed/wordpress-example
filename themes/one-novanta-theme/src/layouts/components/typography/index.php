<?php
/**
 * Component Typography
 * 
 * @component Typography
 * @description Renders styled text elements with configurable sizes and weights.
 * @group UI Elements
 * 
 * @package OneNovantaTheme\Components
 */

?>

<div class="typography">
	<h1>Heading 1</h1>
	<h2>Heading 2</h2>
	<h3>Heading 3</h3>
	<h4>Heading 4</h4>
	<h5>Heading 5</h5>
	<h6>Heading 6</h6>

	<hr />

	<p><strong>Paragraph</strong></p>

	<p>This is a paragraph of text. It should be easy to read and well-spaced.</p>
	<p>Lorem ipsum dolor sit amet, <strong>Bold text</strong> and <em>italic text</em> for emphasis. Inline <code>code snippet</code> inside a paragraph. consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
	<p>As a new WordPress user, you should go to <a href="#">your dashboard</a> to delete this page and create new pages for your content. Have fun!</p>

	<hr />

	<p><strong>Blockquote</strong></p>

	<blockquote>This is a blockquote. It is used to highlight quoted text.</blockquote>

	<blockquote class="wp-block-quote is-layout-flow wp-block-quote-is-layout-flow">
		<p>In quoting others, we cite ourselves.</p>
	</blockquote>

	<hr />

	<p><strong>Unordered List</strong></p>

	<ul>
		<li>Unordered list item 1</li>
		<li>Unordered list item 2</li>
	</ul>

	<hr />

	<p><strong>Ordered List</strong></p>

	<ol>
		<li>Ordered list item 1</li>
		<li>Ordered list item 2</li>
	</ol>

	<hr />

	<p><strong>Code</strong></p>

	<pre>
		<code aria-label="Code">
registerBlockType( name, settings );
		</code>
	</pre>

	<hr />

	<p><strong>Table</strong></p>

	<figure class="wp-block wp-block-table">
		<table class="has-fixed-layout">
			<thead>
				<tr>
					<th class="wp-block-table__cell-content">
					<div aria-label="Header cell text">Version</div>
					</th>
					<th class="wp-block-table__cell-content">
					<div aria-label="Header cell text">Jazz Musician</div>
					</th>
					<th class="wp-block-table__cell-content">
					<div aria-label="Header cell text">Release Date</div>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="wp-block-table__cell-content">
					<div aria-label="Body cell text">5.2</div>
					</td>
					<td class="wp-block-table__cell-content">
					<div aria-label="Body cell text">Jaco Pastorius</div>
					</td>
					<td class="wp-block-table__cell-content">
					<div aria-label="Body cell text">May 7, 2019</div>
					</td>
				</tr>
				<tr>
					<td class="wp-block-table__cell-content">
					<div aria-label="Body cell text">5.1</div>
					</td>
					<td class="wp-block-table__cell-content">
					<div aria-label="Body cell text">Betty Carter</div>
					</td>
					<td class="wp-block-table__cell-content">
					<div aria-label="Body cell text">February 21, 2019</div>
					</td>
				</tr>
				<tr>
					<td class="wp-block-table__cell-content">
					<div aria-label="Body cell text">5.0</div>
					</td>
					<td class="wp-block-table__cell-content">
					<div aria-label="Body cell text">Bebo Valdés</div>
					</td>
					<td class="wp-block-table__cell-content">
					<div aria-label="Body cell text">December 6, 2018</div>
					</td>
				</tr>
			</tbody>
		</table>
	</figure>
</div>
