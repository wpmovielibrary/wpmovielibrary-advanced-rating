<?php
/**
 * Movie Headbox Trailer Tab Template view
 * 
 * Showing a movie's headbox trailer tab.
 * 
 * @since    2.0
 * 
 * @uses    $trailer
 */
?>

				<div class="wpmoly headbox movie details fields">
<?php foreach ( $ratings as $rating ) : ?>
					<div class="wpmoly headbox movie details field">
						<span class="wpmoly headbox movie details field title"><span class="<?php echo $rating['icon'] ?>"></span> <?php echo $rating['title'] ?></span>
						<span class="wpmoly headbox movie details field value"><span><?php echo $rating['value'] ?></span></span>
					</div>

<?php endforeach; ?>
				</div>
