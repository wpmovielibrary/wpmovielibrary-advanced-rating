
		<div id="wpmoly-advanced-rating" class="wpmoly-advanced-rating">

			<p><strong><?php _e( 'Advanced Rating', 'wpmovielibrary-advanced-rating' ); ?></strong></p>

<?php foreach ( $ratings as $slug => $rating ) : ?>
			<div id="wpmoly-details-<?php echo $slug ?>" class="wpmoly-details-item wpmoly-details-<?php echo $slug ?>">
				<h4 class="wpmoly-details-item-title"><span class="<?php echo $rating['icon'] ?>"></span>&nbsp; <?php echo $rating['title'] ?></h4>
				<?php echo $rating['html'] ?>
			</div>

<?php endforeach; ?>

		</div>
