<?php
/**
 * WPMOLYAR_Advanced_Rating Admin Class
 * 
 * @package   WPMovieLibrary-Advanced-Rating
 * @author    Charlie MERLAND <charlie.merland@gmail.com>
 * @license   GPL-3.0
 * @link      http://www.caercam.org/
 * @copyright 2014 CaerCam.org
 */

if ( ! class_exists( 'WPMOLYAR_Advanced_Rating_Admin' ) ) :

	/**
	 * WPMOLYAR_Advanced_Rating Admin Class
	 * 
	 * @since    1.0
	 */
	class WPMOLYAR_Advanced_Rating_Admin extends WPMOLYAR_Module {

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

			if ( ! is_admin() )
				return false;

			$this->init();

			$this->register_hook_callbacks();
		}

		/**
		 * Initializes variables
		 *
		 * @since    1.0
		 */
		public function init() {

			global $wpmolyar;
			$this->ratings = $wpmolyar->ratings;
		}

		/**
		 * Register callbacks for actions and filters
		 * 
		 * @since    1.0
		 */
		public function register_hook_callbacks() {

			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

			// Save ratings
			add_action( 'save_post_movie', array( $this, 'save_advanced_rating' ), 15, 3 );

			// Create a new Metabox tab
			add_filter( 'wpmoly_filter_metabox_panels', array( $this, 'add_metabox_panel' ), 10, 1 );

			// AJAX callbacks
			add_action( 'wp_ajax_wpmoly_save_rating', array( $this, 'save_rating_callback' ), 10, 1 );

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

				if ( 'rating' == $slug )
					$this->ratings[ $slug ]['title'] = __( 'Overall', 'wpmovielibrary-advanced-rating' );

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

				$this->ratings[ $slug ]['html'] = $html;
				$this->ratings[ $slug ]['value'] = $value;
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

			if ( isset( $_POST['wpmoly_ratings'] ) && ! empty( $_POST['wpmoly_ratings'] ) ) {

				$ratings = $_POST['wpmoly_ratings'];
				$allowed = array_keys( $this->ratings );

				foreach ( $ratings as $slug => $rating ) {

					$rating = esc_attr( $rating );
					if ( in_array( $slug, $allowed ) && '' != $rating ) {

						$rating = update_post_meta( $post_ID, "_wpmoly_movie_$slug", $rating );
						if ( ! $rating )
							$errors->add( 'rating-' . $slug, sprintf( __( 'An error occurred while saving the %s value.', 'wpmovielibrary-advanced-rating' ), $slug ) );
					}
				}
			}

			return ( ! empty( $errors->errors ) ? $errors : $post_ID );
		}

		/**
		 * Prepares sites to use the plugin during single or network-wide activation
		 *
		 * @since    1.0
		 *
		 * @param    bool    $network_wide
		 */
		public function activate( $network_wide ) {}

		/**
		 * Rolls back activation procedures when de-activating the plugin
		 *
		 * @since    1.0
		 */
		public function deactivate() {}

	}

endif;