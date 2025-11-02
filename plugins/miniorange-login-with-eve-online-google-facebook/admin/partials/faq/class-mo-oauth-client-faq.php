<?php
/**
 * FAQ
 *
 * @package    faq
 * @author     miniOrange <info@miniorange.com>
 * @license    Expat
 * @link       https://miniorange.com
 */

/**
 * Class for handling FAQ
 */
class MO_OAuth_Client_Faq {

	/**
	 * Call internal FAQ function to display FAQ page
	 */
	public static function faq() {
		self::faq_page();
	}
	/**
	 * Display FAQ page
	 */
	public static function faq_page() {
		?>
			<div class="mo_table_layout">
				<object type="text/html" data="https://faq.miniorange.com/kb/oauth-openid-connect/" width="100%" height="600px" > 
				</object>
			</div>
		<?php
	}
}
