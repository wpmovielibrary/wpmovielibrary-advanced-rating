<?php
/**
 * WPMovieLibrary-Advanced-Rating
 *
 * @package   WPMovieLibrary-Advanced-Rating
 * @author    Charlie MERLAND <charlie@caercam.org>
 * @license   GPL-3.0
 * @link      http://www.caercam.org/
 * @copyright 2014 Charlie MERLAND
 */

if ( ! class_exists( 'WPMovieLibrary_Advanced_Rating' ) ) :

	/**
	* Plugin class
	*
	* @package WPMovieLibrary-Advanced-Rating
	* @author  Charlie MERLAND <charlie@caercam.org>
	*/
	class WPMovieLibrary_Advanced_Rating extends WPMOLYAR_Module {

		/**
		 * Settings for new details
		 * 
		 * @since     1.0
		 * @var       array
		 */
		public $ratings = array();

		/**
		 * Initialize the plugin by setting localization and loading public scripts
		 * and styles.
		 *
		 * @since     1.0
		 */
		public function __construct() {

			$this->init();
		}

		/**
		 * Initializes variables
		 *
		 * @since    1.0
		 */
		public function init() {

			$options = array(
				'0.0' => __( 'Not rated', 'wpmovielibrary' ),
				'0.5' => __( 'Junk', 'wpmovielibrary' ),
				'1.0' => __( 'Very bad', 'wpmovielibrary' ),
				'1.5' => __( 'Bad', 'wpmovielibrary' ),
				'2.0' => __( 'Not that bad', 'wpmovielibrary' ),
				'2.5' => __( 'Average', 'wpmovielibrary' ),
				'3.0' => __( 'Not bad', 'wpmovielibrary' ),
				'3.5' => __( 'Good', 'wpmovielibrary' ),
				'4.0' => __( 'Very good', 'wpmovielibrary' ),
				'4.5' => __( 'Excellent', 'wpmovielibrary' ),
				'5.0' => __( 'Masterpiece', 'wpmovielibrary' )
			);

			$this->ratings = array();

			$this->ratings['rating_making'] = array(
				'id'       => 'wpmoly-movie-rating-making',
				'name'     => 'wpmoly_ratings[rating_making]',
				'type'     => 'select',
				'title'    => __( 'Making', 'wpmovielibrary-advanced-rating' ),
				'desc'     => __( 'Rate this movie’s making.', 'wpmovielibrary-advanced-rating' ),
				'icon'     => 'wpmolicon icon-director',
				'options'  => $options,
				'default'  => '',
				'panel'    => 'custom',
				'rewrite'  => array( 'makingrating' => __( 'makingrating', 'wpmovielibrary-advanced-rating' ) )
			);

			$this->ratings['rating_story'] = array(
				'id'       => 'wpmoly-movie-rating-story',
				'name'     => 'wpmoly_ratings[rating_story]',
				'type'     => 'select',
				'title'    => __( 'Story', 'wpmovielibrary-advanced-rating' ),
				'desc'     => __( 'Rate this movie’s story.', 'wpmovielibrary-advanced-rating' ),
				'icon'     => 'wpmolicon icon-book',
				'options'  => $options,
				'default'  => '',
				'panel'    => 'custom',
				'rewrite'  => array( 'storyrating' => __( 'storyrating', 'wpmovielibrary-advanced-rating' ) )
			);

			$this->ratings['rating_cast'] = array(
				'id'       => 'wpmoly-movie-rating-cast',
				'name'     => 'wpmoly_ratings[rating_cast]',
				'type'     => 'select',
				'title'    => __( 'Cast', 'wpmovielibrary-advanced-rating' ),
				'desc'     => __( 'Rate this movie’s cast.', 'wpmovielibrary-advanced-rating' ),
				'icon'     => 'wpmolicon icon-actor',
				'options'  => $options,
				'default'  => '',
				'panel'    => 'custom',
				'rewrite'  => array( 'castrating' => __( 'castrating', 'wpmovielibrary-advanced-rating' ) )
			);

			$this->ratings['rating_soundtrack'] = array(
				'id'       => 'wpmoly-movie-rating-soundtrack',
				'name'     => 'wpmoly_ratings[rating_soundtrack]',
				'type'     => 'select',
				'title'    => __( 'Soundtrack', 'wpmovielibrary-advanced-rating' ),
				'desc'     => __( 'Rate this movie’s original soundtrack.', 'wpmovielibrary-advanced-rating' ),
				'icon'     => 'wpmolicon icon-composer',
				'options'  => $options,
				'default'  => '',
				'panel'    => 'custom',
				'rewrite'  => array( 'soundtrackrating' => __( 'soundtrackrating', 'wpmovielibrary-advanced-rating' ) )
			);

			$this->ratings['rating_photography'] = array(
				'id'       => 'wpmoly-movie-rating-photography',
				'name'     => 'wpmoly_ratings[rating_photography]',
				'type'     => 'select',
				'title'    => __( 'Photography', 'wpmovielibrary-advanced-rating' ),
				'desc'     => __( 'Rate this movie’s photography.', 'wpmovielibrary-advanced-rating' ),
				'icon'     => 'wpmolicon icon-camera',
				'options'  => $options,
				'default'  => '',
				'panel'    => 'custom',
				'rewrite'  => array( 'photographyrating' => __( 'photographyrating', 'wpmovielibrary-advanced-rating' ) )
			);

			$this->ratings['rating_vfx'] = array(
				'id'       => 'wpmoly-movie-rating-vfx',
				'name'     => 'wpmoly_ratings[rating_vfx]',
				'type'     => 'select',
				'title'    => __( 'VFX', 'wpmovielibrary-advanced-rating' ),
				'desc'     => __( 'Rate this movie’s visual effects', 'wpmovielibrary-advanced-rating' ),
				'icon'     => 'wpmolicon icon-vfx',
				'options'  => $options,
				'default'  => '',
				'panel'    => 'custom',
				'rewrite'  => array( 'vfxrating' => __( 'vfxrating', 'wpmovielibrary-advanced-rating' ) )
			);

			$this->ratings['rating'] = array(
				'id'       => 'wpmoly-movie-rating',
				'name'     => 'wpmoly_ratings[rating]',
				'type'     => 'select',
				'title'    => __( 'Overall', 'wpmovielibrary' ),
				'desc'     => __( 'Select a global rating for this movie', 'wpmovielibrary' ),
				'icon'     => 'wpmolicon icon-star-half',
				'options'  => $options,
				'default'  => '',
				'panel'    => 'custom',
				'rewrite'  => array( 'rating' => __( 'rating', 'wpmovielibrary' ) )
			);

			/*$this->ratings['rating_'] = array(
				'id'       => 'wpmoly-movie-rating-',
				'name'     => 'wpmoly_ratings[rating_]',
				'type'     => 'select',
				'title'    => __( '', 'wpmovielibrary-advanced-rating' ),
				'desc'     => __( '', 'wpmovielibrary-advanced-rating' ),
				'icon'     => '',
				'options'  => $options,
				'default'  => '',
				'multi'    => true,
				'panel'    => 'custom',
				'rewrite'  => array( 'rating' => __( 'rating', 'wpmovielibrary-advanced-rating' ) )
			);*/

			$this->register_hook_callbacks();
		}

		/**
		 * Register callbacks for actions and filters
		 * 
		 * @since    1.0
		 */
		public function register_hook_callbacks() {

			add_action( 'plugins_loaded', 'wpmolyar_l10n' );

			add_action( 'activated_plugin', __CLASS__ . '::require_wpmoly_first' );

			// Enqueue scripts and styles
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

			// Create new details
			add_filter( 'wpmoly_pre_filter_details', array( $this, 'create_ratings' ), 10, 1 );

			// Add new details to the settings panel
			add_filter( 'redux/options/wpmoly_settings/field/wpmoly-sort-details/register', array( $this, 'ratings_setting' ), 10, 1 );
			add_filter( 'redux/options/wpmoly_settings/field/wpmoly-headbox-title/register', array( $this, 'ratings_setting' ), 15, 1 );
			add_filter( 'redux/options/wpmoly_settings/field/wpmoly-headbox-subtitle/register', array( $this, 'ratings_setting' ), 15, 1 );
			add_filter( 'redux/options/wpmoly_settings/field/wpmoly-headbox-details-1/register', array( $this, 'ratings_setting' ), 15, 1 );
			add_filter( 'redux/options/wpmoly_settings/field/wpmoly-headbox-details-2/register', array( $this, 'ratings_setting' ), 15, 1 );
			add_filter( 'redux/options/wpmoly_settings/field/wpmoly-headbox-details-3/register', array( $this, 'ratings_setting' ), 15, 1 );

			// Add new detail to the settings panel
			add_filter( 'redux/options/wpmoly_settings/field/wpmoly-headbox-tabs/register', array( $this, 'headbox_tabs_settings' ), 10, 1 );

			add_filter( 'wpmoly_filter_headbox_menu_link', array( $this, 'headbox_menu_adv_rating_link' ), 10, 1 );
			add_filter( 'wpmoly_filter_headbox_menu_tabs', array( $this, 'headbox_menu_adv_rating_tab' ), 10, 1 );
		}

		/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 *
		 *                     Plugin  Activate/Deactivate
		 * 
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

		/**
		 * Fired when the plugin is activated.
		 *
		 * @since    1.0
		 *
		 * @param    boolean    $network_wide    True if WPMU superadmin uses
		 *                                       "Network Activate" action, false if
		 *                                       WPMU is disabled or plugin is
		 *                                       activated on an individual blog.
		 */
		public function activate( $network_wide ) {

			global $wpdb;

			if ( function_exists( 'is_multisite' ) && is_multisite() ) {
				if ( $network_wide ) {
					$blogs = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );

					foreach ( $blogs as $blog ) {
						switch_to_blog( $blog );
						$this->single_activate( $network_wide );
					}

					restore_current_blog();
				} else {
					$this->single_activate( $network_wide );
				}
			} else {
				$this->single_activate( $network_wide );
			}

		}

		/**
		 * Fired when the plugin is deactivated.
		 * 
		 * When deactivatin/uninstalling WPMOLY, adopt different behaviors depending
		 * on user options. Movies and Taxonomies can be kept as they are,
		 * converted to WordPress standars or removed. Default is conserve on
		 * deactivation, convert on uninstall.
		 *
		 * @since    1.0
		 */
		public function deactivate() {
		}

		/**
		 * Runs activation code on a new WPMS site when it's created
		 *
		 * @since    1.0
		 *
		 * @param    int    $blog_id
		 */
		public function activate_new_site( $blog_id ) {
			switch_to_blog( $blog_id );
			$this->single_activate( true );
			restore_current_blog();
		}

		/**
		 * Prepares a single blog to use the plugin
		 *
		 * @since    1.0
		 *
		 * @param    bool    $network_wide
		 */
		protected function single_activate( $network_wide ) {

			self::require_wpmoly_first();
		}

		/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 *
		 *                     Scripts/Styles and Utils
		 * 
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

		/**
		 * Register and enqueue public-facing style sheet.
		 *
		 * @since    1.0
		 */
		public function enqueue_styles() {

			wp_enqueue_style( WPMOLYAR_SLUG . '-css', WPMOLYAR_URL . '/assets/css/public.css', array(), WPMOLYAR_VERSION );
		}

		/**
		 * Make sure the plugin is load after WPMovieLibrary and not
		 * before, which would result in errors and missing files.
		 *
		 * @since    1.0
		 */
		public static function require_wpmoly_first() {

			$this_plugin_path = plugin_dir_path( __FILE__ );
			$this_plugin      = basename( $this_plugin_path ) . '/wpmoly-advanced-rating.php';
			$active_plugins   = get_option( 'active_plugins' );
			$this_plugin_key  = array_search( $this_plugin, $active_plugins );
			$wpmoly_plugin_key  = array_search( 'wpmovielibrary/wpmovielibrary.php', $active_plugins );

			if ( $this_plugin_key < $wpmoly_plugin_key ) {

				unset( $active_plugins[ $this_plugin_key ] );
				$active_plugins = array_merge(
					array_slice( $active_plugins, 0, $wpmoly_plugin_key ),
					array( $this_plugin ),
					array_slice( $active_plugins, $wpmoly_plugin_key )
				);

				update_option( 'active_plugins', $active_plugins );
			}
		}

		/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 *
		 *                             Headbox
		 * 
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

		/**
		 * Modern headbox advanced rating tab menu links.
		 *
		 * @since    2.0
		 * 
		 * @param    array     $links Existing links
		 * 
		 * @return   string    Updated Menu links
		 */
		public function headbox_menu_adv_rating_link( $links ) {

			$new_links = array(
				'adv_rating' => array(
					'title' => __( 'Advanced Rating', 'wpmovielibrary' ),
					'icon'  => 'wpmolicon icon-star-half'
				)
			);

			$links = array_merge( $links, $new_links );

			return $links;
		}

		/**
		 * Modern headbox advanced rating tab.
		 *
		 * @since    2.0
		 * 
		 * @param    array    $tabs Existing tabs
		 * 
		 * @return   string    Updated Tab list
		 */
		public function headbox_menu_adv_rating_tab( $tabs ) {

			$new_tabs = array(
				'adv_rating' => array(
					'title'   => __( 'Advanced Rating', 'wpmovielibrary' ),
					'icon'    => 'wpmolicon icon-star-half',
					'content' => $this->movie_headbox_adv_rating_tab()
				)
			);

			$tabs = array_merge( $tabs, $new_tabs );

			return $tabs;
		}

		/**
		 * Modern headbox advanced rating tab content callback.
		 * 
		 * @since    2.0
		 * 
		 * @return   string    Tab content HTML markup
		 */
		public function movie_headbox_adv_rating_tab() {

			global $post;

			$ratings = array();

			foreach ( $this->ratings as $slug => $rating ) {

				$value = wpmoly_get_movie_meta( $post->ID, "rating_$slug" );
				if ( '' == $value )
					$value = '0.0';

				$rewrite = array_pop( $rating['rewrite'] );
				$value = apply_filters( "wpmoly_movie_meta_link", $rewrite, $value, 'detail', $rating['options'][ $value ] );
				$title = __( $rating['title'], 'wpmovielibrary-advanced-rating' );
				$icon  = $rating['icon'];

				$ratings[] = compact( 'slug', 'icon', 'title', 'value' );
			}

			$attributes = compact( 'ratings' );
			$content = self::render_template( 'movies/headbox/tabs/advanced-rating.php', $attributes, $require = 'always' );

			return $content;
		}

		/**
		 * Add Advanced Rating to the Settings panel
		 *
		 * @since    1.1
		 * 
		 * @param    array    Exisiting Headbox Tabs settings
		 * 
		 * @return   array    Updated Headbox Tabs settings
		 */
		public function headbox_tabs_settings( $field ) {

			$field['options'] = array_merge( $field['options'], array( 'advanced-rating' => __( 'Advanced Rating', 'wpmovielibrary-advanced-rating' ) ) );

			return $field;
		}

		/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 *
		 *                        Advanced Rating Details
		 * 
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

		/**
		 * Create new movie details
		 *
		 * @since    1.0
		 * 
		 * @param    array    Exisiting details
		 * 
		 * @return   array    Updated details
		 */
		public function create_ratings( $details ) {

			$details['rating']['panel'] = 'custom';
			$this->ratings['rating'] = $details['rating'];

			$details = array_merge( $details, $this->ratings );

			return $details;
		}

		/**
		 * Add new movie detail to the Settings panel
		 *
		 * @since    1.0
		 * 
		 * @param    array    Exisiting detail field
		 * 
		 * @return   array    Updated detail field
		 */
		public function ratings_setting( $field ) {

			$ratings = array();
			foreach ( $this->ratings as $slug => $rating ) {
				if ( 'rating' != $slug ) {
					$ratings[ $slug ] = sprintf( '%s (%s)', $rating['title'], __( 'Rating', 'wpmovielibrary' ) );
				} else {
					$ratings[ $slug ] = __( 'Overall Rating', 'wpmovielibrary-advanced-rating' );
				}
			}

			if ( isset( $field['options']['available'] ) ) {
				$field['options']['available'] = array_merge( $field['options']['available'], $ratings );
			} elseif ( isset( $field['options'] ) ) {
				$field['options'] = array_merge( $field['options'], $ratings );
			}

			return $field;
		}

		

		/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 *
		 *                             Shortcodes
		 * 
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

		

	}
endif;