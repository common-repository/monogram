<?php
/**
 * Plugin Name: Monogram
 * Plugin URI: http://wordpress.billdawson.net
 * Description: Automatically add an end mark (image or text) to the end of pages and posts. An end mark (sometimes called an end sign) is the small graphic element placed at the end of an article, chapter or story.
 * Version: 1.0
 * Author: Bill Dawson
 * Author URI: http://billdawson.net
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
$name = "monogram";

add_option($name, $value, $deprecated, $autoload);

add_action( 'the_content', 'monogram' );

function monogram ( $content ) {
	$monogram_options = get_option( 'monogram_option_name' ); // Array of All Options
	$monogram_0 = $monogram_options['monogram_0']; // Monogram
	$content .= '<div width="100%" align="center"><p>';
	if(strpos($monogram_0,'http') !== false) {
		$content .= '<img src='.$monogram_0.'>';
	} else {
		$content .= $monogram_0;
		}
	$content .= '</p></div>';
	return $content;
}


/** Settings */
/**
 * Generated by the WordPress Option Page generator
 * at http://jeremyhixon.com/wp-tools/option-page/
 */

class Monogram {
	private $monogram_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'monogram_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'monogram_page_init' ) );
	}

	public function monogram_add_plugin_page() {
		add_theme_page(
			'Monogram', // page_title
			'Monogram', // menu_title
			'manage_options', // capability
			'monogram', // menu_slug
			array( $this, 'monogram_create_admin_page' ) // function
		);
	}

	public function monogram_create_admin_page() {
		$this->monogram_options = get_option( 'monogram_option_name' ); ?>

		<div class="wrap">
			<h2>Monogram</h2>
			<p><b>Enter TEXT or IMAGE to appear at the end of each page or post.</b><br />(If linking to an image, use fully qualified URL or link from your site's Media Library. Include HTTP:// or HTTPS://.)</p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'monogram_option_group' );
					do_settings_sections( 'monogram-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function monogram_page_init() {
		register_setting(
			'monogram_option_group', // option_group
			'monogram_option_name', // option_name
			array( $this, 'monogram_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'monogram_setting_section', // id
			'Settings', // title
			array( $this, 'monogram_section_info' ), // callback
			'monogram-admin' // page
		);

		add_settings_field(
			'monogram_0', // id
			'Monogram', // title
			array( $this, 'monogram_0_callback' ), // callback
			'monogram-admin', // page
			'monogram_setting_section' // section
		);
	}

	public function monogram_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['monogram_0'] ) ) {
			$sanitary_values['monogram_0'] = trim(esc_textarea( $input['monogram_0'],'"'));
		}

		return $sanitary_values;
	}

	public function monogram_section_info() {
		
	}

	public function monogram_0_callback() {
		printf(
			'<textarea class="large-text" rows="5" name="monogram_option_name[monogram_0]" id="monogram_0">%s</textarea>',
			isset( $this->monogram_options['monogram_0'] ) ? esc_attr( $this->monogram_options['monogram_0']) : ''
		);
	}

}
if ( is_admin() )
	$monogram = new Monogram();

/* 
 * Retrieve this value with:
 * $monogram_options = get_option( 'monogram_option_name' ); // Array of All Options
 * $monogram_0 = $monogram_options['monogram_0']; // Monogram
 */
