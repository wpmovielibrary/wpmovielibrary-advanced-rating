
		<div id="wpmoly-advanced-rating" class="wpmoly-advanced-rating">

			<?php wpmoly_nonce_field( 'save-rating' ) ?>

			<p><strong><?php _e( 'Advanced Rating', 'wpmovielibrary-advanced-rating' ); ?></strong></p>
			<p><em><?php _e( 'Evaluate different aspects of this movie.', 'wpmovielibrary-advanced-rating' ); ?> <?php if ( $average ) printf( __( 'Current average rating is %s (%s out of 10).', 'wpmovielibrary-advanced-rating' ), sprintf( '<strong><span id="wpmoly-ratings-average">%s</span></strong>', $average ), sprintf( '<span id="wpmoly-ratings-average-10">%s</span>', $average_10 ) ); ?></em></p>

<?php foreach ( $ratings as $slug => $rating ) : ?>
			<div id="wpmoly-ratings-<?php echo $slug ?>" class="wpmoly-details-item wpmoly-ratings-item wpmoly-details-<?php echo $slug ?>" data-rating="<?php echo $rating['value']; ?>">
				<h4 class="wpmoly-details-item-title"><span class="<?php echo $rating['icon'] ?>"></span>&nbsp; <?php echo $rating['title'] ?></h4>
				<?php echo $rating['html'] ?>
				<div id="wpmoly-ratings-<?php echo $slug ?>-select-stars" class="wpmoly-details-item-select-stars wpmoly-ratings-item-select-stars<?php if ( '0.0' != $rating['value'] ) echo ' rated'; ?>"></div>
			</div>

<?php endforeach; ?>

		</div>
