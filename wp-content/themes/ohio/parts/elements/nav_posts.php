<?php
	// Settings
	$prev_post = get_adjacent_post( false, '', false );
	$next_post = get_adjacent_post( false, '', true );
	if (!$next_post) $next_post = $prev_post;

	$toggle_post_column = ( ! empty( $prev_post ) && ! empty( $next_post ) ) ? '6' : '12';

	$show_prev_n_next = OhioOptions::get( 'post_previous_n_next_visibility', true );

	if ( ( $prev_post || $next_post ) && $show_prev_n_next ) :
?>
<div class="sticky-nav">
	<div class="sticky-nav-image"
		<?php 
			$next_image_thumb = get_the_post_thumbnail_url( $next_post, 'medium_large' );
			if ($next_image_thumb) {
				echo 'style="background-image: url(\'' . $next_image_thumb . '\');"';
			}
		?>
		>
	</div>
	<div class="sticky-nav-holder">
		<div class="sticky-nav_item">
			<h6 class="heading-sm">
				<?php esc_html_e( 'Next Post', 'ohio' ); ?>
			</h6>
			<div class="nav-holder">
				<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="btn-round btn-round-small btn-round-light">
					<i class="ion"><svg class="arrow-icon arrow-icon-back" width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 7H16M16 7L11 1M16 7L11 13" stroke-width="2"/></svg></i>
				</a>
				<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="btn-round btn-round-small btn-round-light">
					<i class="ion"><svg class="arrow-icon" width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 7H16M16 7L11 1M16 7L11 13" stroke-width="2"/></svg></i>
				</a>	
			</div>
		</div>
		<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>">
			<h5 class="sticky-nav_heading ">
				<?php
					$next_title = get_the_title( $next_post->ID );
					if ( empty( $next_title ) ) {
						echo wp_kses( '[' . get_the_date( false, $next_post->ID ) . ']', 'default' );
					} else {
						echo wp_kses( $next_title, 'default' );
					}
				?>
			</h5>
		</a>	
	</div>
</div>
<?php endif; ?>