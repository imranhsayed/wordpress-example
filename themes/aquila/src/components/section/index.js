/**
 * External dependencies
 */
import classnames from 'classnames';

/**
 * Section Component
 *
 * @param {Object} props Component properties
 * @param {string} props.className Additional CSS classes
 * @param {boolean} props.background Whether section has background
 * @param {string} props.backgroundColor Background color (black or gray)
 * @param {boolean} props.padding Whether section has padding
 * @param {boolean} props.seamless Whether section is seamless
 * @param {boolean} props.narrow Whether section has narrow width
 * @param {Object} props.children Child components
 */
export default function Section({
	className,
	background = false,
	backgroundColor = 'gray',
	padding = false,
	seamless = false,
	narrow = false,
	children,
	...props
}) {
	const classes = classnames('section', className, {
		'section--seamless': seamless || background,
		'section--seamless-with-padding': background || padding,
		'section--narrow': narrow,
		'section--has-background': background,
		[`section--has-background-${backgroundColor}`]: background && backgroundColor,
		'full-width': background,
	});

	return (
		<div className={classes} {...props}>
			{background && <div className="wrap">{children}</div>}
			{!background && children}
		</div>
	);
}
