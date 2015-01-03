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
		protected $ratings = array();

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

			$this->ratings['making'] = array(
				'id'       => 'wpmoly-movie-rating-making',
				'name'     => 'wpmoly_details[rating-making]',
				'type'     => 'select',
				'title'    => __( 'Making', 'wpmovielibrary-advanced-rating' ),
				'desc'     => __( 'Rate this movie’s making.', 'wpmovielibrary-advanced-rating' ),
				'icon'     => 'wpmolicon icon-director',
				'options'  => $options,
				'default'  => '',
				'panel'    => 'custom',
				'rewrite'  => array( 'makingrating' => __( 'makingrating', 'wpmovielibrary-advanced-rating' ) )
			);

			$this->ratings['story'] = array(
				'id'       => 'wpmoly-movie-rating-story',
				'name'     => 'wpmoly_details[rating-story]',
				'type'     => 'select',
				'title'    => __( 'Story', 'wpmovielibrary-advanced-rating' ),
				'desc'     => __( 'Rate this movie’s story.', 'wpmovielibrary-advanced-rating' ),
				'icon'     => 'wpmolicon icon-book',
				'options'  => $options,
				'default'  => '',
				'panel'    => 'custom',
				'rewrite'  => array( 'storyrating' => __( 'storyrating', 'wpmovielibrary-advanced-rating' ) )
			);

			$this->ratings['cast'] = array(
				'id'       => 'wpmoly-movie-rating-cast',
				'name'     => 'wpmoly_details[rating-cast]',
				'type'     => 'select',
				'title'    => __( 'Cast', 'wpmovielibrary-advanced-rating' ),
				'desc'     => __( 'Rate this movie’s cast.', 'wpmovielibrary-advanced-rating' ),
				'icon'     => 'wpmolicon icon-actor',
				'options'  => $options,
				'default'  => '',
				'panel'    => 'custom',
				'rewrite'  => array( 'castrating' => __( 'castrating', 'wpmovielibrary-advanced-rating' ) )
			);

			$this->ratings['soundtrack'] = array(
				'id'       => 'wpmoly-movie-rating-soundtrack',
				'name'     => 'wpmoly_details[rating-soundtrack]',
				'type'     => 'select',
				'title'    => __( 'Soundtrack', 'wpmovielibrary-advanced-rating' ),
				'desc'     => __( 'Rate this movie’s original soundtrack.', 'wpmovielibrary-advanced-rating' ),
				'icon'     => 'wpmolicon icon-composer',
				'options'  => $options,
				'default'  => '',
				'panel'    => 'custom',
				'rewrite'  => array( 'soundtrackrating' => __( 'soundtrackrating', 'wpmovielibrary-advanced-rating' ) )
			);

			$this->ratings['photography'] = array(
				'id'       => 'wpmoly-movie-rating-photography',
				'name'     => 'wpmoly_details[rating-photography]',
				'type'     => 'select',
				'title'    => __( 'Photography', 'wpmovielibrary-advanced-rating' ),
				'desc'     => __( 'Rate this movie’s photography.', 'wpmovielibrary-advanced-rating' ),
				'icon'     => 'wpmolicon icon-camera',
				'options'  => $options,
				'default'  => '',
				'panel'    => 'custom',
				'rewrite'  => array( 'photographyrating' => __( 'photographyrating', 'wpmovielibrary-advanced-rating' ) )
			);

			$this->ratings['vfx'] = array(
				'id'       => 'wpmoly-movie-rating-vfx',
				'name'     => 'wpmoly_details[rating-vfx]',
				'type'     => 'select',
				'title'    => __( 'VFX', 'wpmovielibrary-advanced-rating' ),
				'desc'     => __( 'Rate this movie’s visual effects', 'wpmovielibrary-advanced-rating' ),
				'icon'     => 'wpmolicon icon-format',
				'options'  => $options,
				'default'  => '',
				'panel'    => 'custom',
				'rewrite'  => array( 'vfxrating' => __( 'vfxrating', 'wpmovielibrary-advanced-rating' ) )
			);

			/*$this->ratings[''] = array(
				'id'       => 'wpmoly-movie-rating-',
				'name'     => 'wpmoly_details[rating-]',
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
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

			add_action( 'save_post', array( $this, 'save_advanced_rating' ), 10, 3 );

			// Create new details
			add_filter( 'wpmoly_pre_filter_details', array( $this, 'create_ratings' ), 10, 1 );

			// Add new details to the settings panel
			add_filter( 'redux/options/wpmoly_settings/field/wpmoly-sort-details/register', array( $this, 'ratings_setting' ), 10, 1 );

			// Create a new Metabox tab
			add_filter( 'wpmoly_filter_metabox_panels', array( $this, 'add_metabox_panel' ), 10, 1 );

			// Add new detail to the settings panel
			add_filter( 'redux/options/wpmoly_settings/field/wpmoly-headbox-tabs/register', array( $this, 'headbox_tabs_settings' ), 10, 1 );

			add_filter( 'wpmoly_filter_headbox_menu_link', array( $this, 'headbox_menu_adv_rating_link' ), 10, 1 );
			add_filter( 'wpmoly_filter_headbox_menu_tabs', array( $this, 'headbox_menu_adv_rating_tab' ), 10, 1 );

			// AJAX callbacks
			add_action( 'wp_ajax_wpmoly_save_rating', array( $this, 'save_rating_callback' ), 10, 1 );
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
		 * Register and enqueue public-facing style sheet.
		 *
		 * @since    1.0
		 */
		public function admin_enqueue_styles() {

			wp_enqueue_style( WPMOLYAR_SLUG . '-admin-css', WPMOLYAR_URL . '/assets/css/admin.css', array(), WPMOLYAR_VERSION );
		}

		/**
		 * Register and enqueue public-facing style sheet.
		 *
		 * @since    1.0
		 */
		public function admin_enqueue_scripts() {

			wp_enqueue_script( WPMOLYAR_SLUG . 'admin-js', WPMOLYAR_URL . '/assets/js/admin/wpmoly-advanced-rating.js', array( WPMOLY_SLUG . '-admin' ), WPMOLYAR_VERSION, true );
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
		 *                               Callbacks
		 * 
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

		/**
		 * AJAX Callback
		 * 
		 * @since    1.0
		 */
		public function save_rating_callback() {

			wpmoly_check_ajax_referer( 'save-rating' );

			$post_id      = ( isset( $_POST['post_id'] ) && '' != $_POST['post_id'] ? intval( $_POST['post_id'] ) : null );
			$rating_type  = ( isset( $_POST['rating']['type'] ) && '' != $_POST['rating']['type'] ? esc_attr( $_POST['rating']['type'] ) : null );
			$rating_value = ( isset( $_POST['rating']['value'] ) && '' != $_POST['rating']['value'] ? intval( $_POST['rating']['value'] ) : null );

			$rating = self::save_rating( $post_id, $rating_type, $rating_value );
		}

		/**
		 * AJAX Callback
		 *
		 * @since    1.0
		 */
		public static function b_callback() {

			
		}

		/**
		 * AJAX Callback
		 * 
		 * @since    1.1
		 */
		public static function c_callback() {

			
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
					'content' => self::movie_headbox_adv_rating_tab()
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
		public static function movie_headbox_adv_rating_tab() {

			global $post;

			$attributes = array();

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
		 *                             Metabox
		 * 
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

		/**
		 * Register Advanced Rating Metabox
		 *
		 * @since    2.0
		 * 
		 * @param    array    $metaboxes Existing Metaboxes
		 * 
		 * @return   array    Updated Metaboxes List
		 */
		public function add_metabox_panel( $panels ) {

			$new_panels = array(
				'adv_rating' => array(
					'title'    => __( 'Advanced Rating', 'wpmovielibrary-advanced-rating' ),
					'icon'     => 'wpmolicon icon-star-half',
					'callback' => array( $this, 'render_adv_rating_panel' )
				)
			);

			$panels = array_merge( $panels, $new_panels );

			return $panels;
		}

		/**
		 * Render Panel content
		 *
		 * @since    2.0
		 */
		public function render_adv_rating_panel() {

			$class   = new ReduxFramework();
			$ratings = array();
			$average = array();

			foreach ( $this->ratings as $slug => $rating ) {

				$_slug = $slug;
				if ( 'rating' != $slug )
					$slug = "rating_$slug";

				$field_name = $rating['type'];
				$class_name = "ReduxFramework_{$field_name}";
				$value      = call_user_func_array( 'wpmoly_get_movie_meta', array( 'post_id' => $post_id, 'meta' => $slug ) );

				if ( 'rating' != $slug && 0 < $value )
					$average[] = $value;

				if ( ! class_exists( $class_name ) )
					require_once WPMOLY_PATH . "includes/framework/redux/ReduxCore/inc/fields/{$field_name}/field_{$field_name}.php";

				$field = new $class_name( $rating, $value, $class );

				ob_start();
				$field->render();
				$html = ob_get_contents();
				ob_end_clean();

				$this->ratings[ $_slug ]['html'] = $html;
				$this->ratings[ $_slug ]['value'] = $value;
			}

			if ( empty( $average ) ) {
				$average = '0';
				$average_10 = '0';
			} else {
				$average = array_sum( $average ) / count( $average );
				$average_10 = number_format( ( $average * 2 ), 2, ',', ' ' );
				$average = number_format( $average, 2, ',', ' ' );
			}

			$attributes = array( 'ratings' => $this->ratings, 'average' => $average, 'average_10' => $average_10 );

			$content = self::render_template( 'metabox/panels/panel-advanced-rating.php', $attributes, $require = 'always' );

			return $content;
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
			$details['rating']['title'] = __( 'Overall', 'wpmovielibrary-advanced-rating' );
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

			//$field['options']['available'] = array_merge( $field['options']['available'], array( 'audio' => $this->detail['title'] ) );

			return $field;
		}

		

		/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 *
		 *                             Shortcodes
		 * 
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

		

		/** * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
		 *
		 *                               Utils
		 * 
		 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

		/**
		 * Save a single rating
		 *
		 * @since    1.0
		 *
		 * @param    int        $post_ID Post ID.
		 * @param    string     $type Rating type
		 * @param    int        $value Rating value
		 * 
		 * @return   int|WP_Error    Post ID if advanced ratings were saved successfully, WP_Error if an error occurred.
		 */
		public function save_rating( $post_ID, $rating, $value ) {

			$post = get_post( $post_ID );
			if ( ! $post || 'movie' != get_post_type( $post ) )
				return new WP_Error( 'invalid_post', __( 'Error: submitted post is not a movie.', 'wpmovielibrary' ) );

			$value = max( 0, $value );
			$value = min( 10, $value );
			if ( $value > 5 )
				$value = (float) $value / 2.0;
			$value = number_format( $value, 1, '.', ' ' );

			if ( 'rating' != $rating )
				$rating = 'rating_' . $rating;

			update_post_meta( $post_ID, "_wpmoly_movie_{$rating}", $value );

			WPMOLY_Cache::clean_transient( 'clean', $force = true );

			return $post_ID;
		}

		/**
		 * Save Trailers along with movie.
		 *
		 * @since    1.0
		 *
		 * @param    int        $post_ID Post ID.
		 * @param    WP_Post    $post Post object.
		 * @param    bool       $update Whether this is an existing post being updated or not.
		 * 
		 * @return   int|WP_Error    Post ID if advanced ratings were saved successfully, WP_Error if an error occurred.
		 */
		public function save_advanced_rating( $post_ID, $post, $update ) {

			if ( ! current_user_can( 'edit_post', $post_ID ) )
				return new WP_Error( __( 'You are not allowed to edit posts.', 'wpmovielibrary-advanced-rating' ) );

			if ( ! $post = get_post( $post_ID ) || 'movie' != get_post_type( $post ) )
				return new WP_Error( sprintf( __( 'Posts with #%s is invalid or is not a movie.', 'wpmovielibrary-advanced-rating' ), $post_ID ) );

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
				return $post_ID;

			$errors = new WP_Error();

			if ( isset( $_POST['wpmoly_details'] ) && ! empty( $_POST['wpmoly_details'] ) ) {

				$details = $_POST['wpmoly_details'];
				$allowed = array_keys( $this->ratings );

				foreach ( $details as $slug => $detail ) {

					if ( 'rating' != $slug ) {
						$_slug = str_replace( 'rating-', '', $slug );
						$slug  = str_replace( 'rating-', 'rating_', $slug );
					}

					$rating = esc_attr( $detail );
					if ( in_array( $_slug, $allowed ) && '' != $rating ) {

						$rating = update_post_meta( $post_ID, "_wpmoly_movie_$slug", $rating );
						if ( ! $rating )
							$errors->add( 'rating-' . $_slug, sprintf( __( 'An error occurred while saving the %s rating.', 'wpmovielibrary-advanced-rating' ), $_slug ) );
					}
				}
			}

			return ( ! empty( $errors->errors ) ? $errors : $post_ID );
		}

	}
endif;