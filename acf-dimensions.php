<?php
/**
 * Plugin Name: ACF Dimensions
 * Plugin URI: https://github.com/ernilambar/acf-dimensions/
 * Description: ACF dimensions field.
 * Version: 1.0.4
 * Author: Nilambar Sharma
 * Author URI: https://www.nilambar.net/
 * Text Domain: acf-dimensions
 * GitHub Plugin URI: ernilambar/acf-dimensions
 * Primary Branch: main
 * Release Asset: true
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package ACF_Dimensions
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define.
define( 'ACF_DIMENSIONS_VERSION', '1.0.4' );
define( 'ACF_DIMENSIONS_BASENAME', basename( dirname( __FILE__ ) ) );
define( 'ACF_DIMENSIONS_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'ACF_DIMENSIONS_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );

if ( ! class_exists( 'NS_ACF_Plugin_Dimensions' ) ) :

	/**
	 * Main class.
	 *
	 * @since 1.0.0
	 */
	class NS_ACF_Plugin_Dimensions {

		/**
		 * Settings.
		 *
		 * @var array
		 *
		 * @since 1.0.0
		 */
		protected $settings;

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->settings = array(
				'version' => ACF_DIMENSIONS_VERSION,
				'url'     => plugin_dir_url( __FILE__ ),
				'path'    => plugin_dir_path( __FILE__ ),
			);

			add_action( 'acf/include_field_types', array( $this, 'include_field' ) );
		}

		/**
		 * Include field.
		 *
		 * @since 1.0.0
		 */
		public function include_field() {
			load_plugin_textdomain( 'acf-dimensions' );

			require_once ACF_DIMENSIONS_DIR . '/fields/class-ns-acf-field-dimensions-v5.php';
		}
	}

	new NS_ACF_Plugin_Dimensions();
endif;
