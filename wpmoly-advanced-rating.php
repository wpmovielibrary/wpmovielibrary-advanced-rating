<?php
/**
 * WPMovieLibrary-Advanced-Rating
 *
 * Add Advanced Rating support to WPMovieLibrary
 *
 * @package   WPMovieLibrary-Advanced-Rating
 * @author    Charlie MERLAND <charlie@caercam.org>
 * @license   GPL-3.0
 * @link      http://www.caercam.org/
 * @copyright 2014 CaerCam.org
 *
 * @wordpress-plugin
 * Plugin Name: WPMovieLibrary-Advanced-Rating
 * Plugin URI:  http://wpmovielibrary.com/extensions/wpmovielibrary-advanced-rating/
 * Description: Add Advanced Rating support to WPMovieLibrary
 * Version:     1.0
 * Author:      Charlie MERLAND
 * Author URI:  http://www.caercam.org/
 * Text Domain: wpmoly-advanced-rating
 * License:     GPL-3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Domain Path: /languages
 * GitHub Plugin URI: https://github.com/wpmovielibrary/wpmovielibrary-advanced-rating
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WPMOLYAR_NAME',                    'WPMovieLibrary-Advanced-Rating' );
define( 'WPMOLYAR_VERSION',                 '1.0' );
define( 'WPMOLYAR_SLUG',                    'wpmoly-advanced-rating' );
define( 'WPMOLYAR_URL',                     plugins_url( basename( __DIR__ ) ) );
define( 'WPMOLYAR_PATH',                    plugin_dir_path( __FILE__ ) );
define( 'WPMOLYAR_REQUIRED_PHP_VERSION',    '5.4' );
define( 'WPMOLYAR_REQUIRED_WP_VERSION',     '3.8' );
define( 'WPMOLYAR_REQUIRED_WPMOLY_VERSION', '2.0' );

/**
 * Checks if the system requirements are met
 * 
 * @since    1.0
 * 
 * @return   bool    True if system requirements are met, false if not
 */
function wpmolyar_requirements_met() {

	global $wp_version;

	if ( version_compare( PHP_VERSION, WPMOLYAR_REQUIRED_PHP_VERSION, '<=' ) )
		return false;

	if ( version_compare( $wp_version, WPMOLYAR_REQUIRED_WP_VERSION, '<=' ) )
		return false;

	return true;
}

/**
 * Prints an error that the system requirements weren't met.
 * 
 * @since    1.0
 */
function wpmolyar_requirements_error() {

	global $wp_version;

	require_once WPMOLYAR_PATH . '/views/requirements-error.php';
}

/**
 * Prints an error that the system requirements weren't met.
 * 
 * @since    1.0.1
 */
function wpmolyar_l10n() {

	$domain = 'wpmovielibrary-advanced-rating';
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	load_textdomain( $domain, WPMOLYAR_PATH . 'languages/' . $domain . '-' . $locale . '.mo' );
	load_plugin_textdomain( $domain, FALSE, basename( __DIR__ ) . '/languages/' );
}

/*
 * Check requirements and load main class
 * The main program needs to be in a separate file that only gets loaded if the
 * plugin requirements are met. Otherwise older PHP installations could crash
 * when trying to parse it.
 */
if ( wpmolyar_requirements_met() ) {

	require_once( WPMOLYAR_PATH . 'includes/class-module.php' );
	require_once( WPMOLYAR_PATH . 'class-wpmoly-advanced-rating.php' );

	if ( class_exists( 'WPMovieLibrary_Advanced_Rating' ) ) {
		$GLOBALS['wpmolyar'] = new WPMovieLibrary_Advanced_Rating();
		register_activation_hook(   __FILE__, array( $GLOBALS['wpmolyar'], 'activate' ) );
		register_deactivation_hook( __FILE__, array( $GLOBALS['wpmolyar'], 'deactivate' ) );
	}

	WPMovieLibrary_Advanced_Rating::require_wpmoly_first();

	if ( is_admin() ) {
		//require_once( WPMOLYAR_PATH . 'admin/class-wpmoly-advanced-rating.php' );
	}
}
else {
	add_action( 'init', 'wpmolyar_l10n' );
	add_action( 'admin_notices', 'wpmolyar_requirements_error' );
}
