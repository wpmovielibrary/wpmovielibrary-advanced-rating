<div class="error">
	<p><?php _e( 'WPMovieLibrary-Advanced-Rating error: your environment does not meet all of the system requirements listed below.', 'wpmovielibrary-advanced-rating' ); ?></p>

<?php if ( is_wpmoly_active() ) : ?>
	<ul class="ul-disc">
		<li><strong style="color:<?php echo $wp; ?>;"><?php _e( 'WPMovieLibrary is required', 'wpmovielibrary-advanced-rating' ); ?></strong>.<br /><em><?php _e( 'WPMovieLibrary-Advanced-Rating extends the WPMovieLibrary plugin and therefore requires it to be installed and activated.', 'wpmovielibrary-advanced-rating' ); ?></em></li>
	</ul>

<?php else : ?>
	<ul class="ul-disc">
		<li>
			<strong>PHP <?php echo WPMLTR_REQUIRED_PHP_VERSION; ?>+</strong>
			<em><?php printf( __( '(You\'re running version %s)', 'wpmovielibrary-advanced-rating' ), PHP_VERSION ); ?></em>
		</li>
		<li>
			<strong>WordPress <?php echo WPMLTR_REQUIRED_WP_VERSION; ?>+</strong>
			<em><?php printf( __( '(You\'re running version %s)', 'wpmovielibrary-advanced-rating' ), esc_html( $wp_version ) ); ?></em>
		</li>
		<li>
			<strong>WPMovieLibrary <?php echo WPMLTR_REQUIRED_WPML_VERSION; ?>+</strong>
			<em><?php if ( is_wpmoly_active() ) printf( __( '(You\'re running version %s)', 'wpmovielibrary-advanced-rating' ), WPML_VERSION ); ?></em>
		</li>
	</ul>

	<p><?php _e( 'If you need to upgrade your version of PHP you can ask your hosting company for assistance, and if you need help upgrading WordPress you can refer to <a href="http://codex.wordpress.org/Upgrading_WordPress">the Codex</a>.', 'wpmovielibrary-advanced-rating' ); ?></p>

	<p><?php _e( 'If you tried activating WPMovieLibrary-Advanced-Rating without activating WPMovieLibrary first, you will need to deactivate and reactivate WPMovieLibrary-Advanced-Rating for this notice to disapear. <a href="http://wpmovielibrary.com/wpmovielibrary-advanced-rating/documentation/installation/#requirements">Learn why</a>.', 'wpmovielibrary-advanced-rating' ); ?></p>
<?php endif; ?>

</div>