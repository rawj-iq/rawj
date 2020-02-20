<?php
	$logo = OhioSettings::get_logo();
	$logo_for_fixed = OhioSettings::get_logo( false, true );
	$logo_as_image = is_array( $logo );
	$logo_for_fixed_as_image = is_array( $logo_for_fixed );
	$logo_for_onepage = OhioSettings::get_logo_for_onepage();
	$header_style = OhioOptions::get( 'page_header_menu_style', 'style1' );
	$logo_text = OhioOptions::get( 'page_header_logo_text', get_bloginfo( 'name' ), false, true );
?>

<div class="site-branding<?php if ( $logo == "sitename" ) { echo ' text-logo'; } ?>">
	<div class="site-title">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<div class="logo<?php if ( $logo_as_image && $logo['mobile'] ) { echo ' with-mobile'; } ?>">
				<?php if ( $logo_as_image && ( $logo['default'] || $logo['retina'] ) ) : ?>
					<img src="<?php echo esc_url( ( $logo['default'] ) ? $logo['default'] : $logo['retina'] ); ?>" <?php if ( $logo['have_vector'] ) { echo ' class="svg-logo"'; } ?><?php if ( $logo['retina'] ) { echo ' srcset="' . $logo['retina'] . ' 2x"'; } ?> alt="<?php echo esc_attr( $logo_text ); ?>">
				<?php else : ?>
					<?php echo esc_html( $logo_text ); ?>
				<?php endif; ?>
			</div>
			<div class="fixed-logo">
				<?php if ( $logo_for_fixed_as_image && ( $logo_for_fixed['default'] || $logo_for_fixed['retina'] ) ) : ?>
					<img src="<?php echo esc_url( ( $logo_for_fixed['default'] ) ? $logo_for_fixed['default'] : $logo_for_fixed['retina'] ); ?>" <?php if ( $logo_for_fixed['have_vector'] ) { echo ' class="svg-logo"'; } ?><?php if ( $logo_for_fixed['retina'] ) { echo ' srcset="' . $logo_for_fixed['retina'] . ' 2x"'; } ?> alt="<?php echo esc_attr( $logo_text ); ?>">
				<?php else : ?>
					<?php echo esc_html( $logo_text ); ?>
				<?php endif; ?>
			</div>
			<?php if ( $logo_as_image && $logo['mobile'] ) : ?>
			<div class="mobile-logo">
				<img src="<?php echo esc_url( $logo['mobile'] ); ?>" class="<?php if ( $logo['have_vector'] ) { echo ' svg-logo'; } ?> alt="<?php echo esc_attr( $logo_text ); ?>">
			</div>
			<?php endif; ?>
			<?php if ( $logo_for_fixed_as_image && $logo_for_fixed['mobile'] ) : ?>
			<div class="fixed-mobile-logo">
				<img src="<?php echo esc_url( $logo_for_fixed['mobile'] ); ?>" class="<?php if ( $logo_for_fixed['have_vector'] ) { echo ' svg-logo'; } ?>" alt="<?php echo esc_attr( $logo_text ); ?>">
			</div>
			<?php endif; ?>
			<div class="for-onepage">
				<span class="dark hidden">
					<?php if ( $logo_for_onepage['dark'] || $logo_for_onepage['dark_retina'] ) : ?>
						<img src="<?php echo esc_url( ( $logo_for_onepage['dark'] ) ? $logo_for_onepage['dark'] : $logo_for_onepage['dark_retina'] ); ?>" <?php if ( $logo_for_onepage['have_vector'] ) { echo ' class="svg-logo"'; } ?><?php if ( $logo_for_onepage['dark_retina'] ) { echo ' srcset="' . $logo_for_onepage['dark_retina'] . ' 2x"'; } ?> alt="<?php echo esc_attr( $logo_text ); ?>">
					<?php else : ?>
						<?php echo esc_html( $logo_text ); ?>
					<?php endif; ?>
				</span>
				<span class="light hidden">
					<?php if ( $logo_for_onepage['light'] || $logo_for_onepage['light_retina'] ) : ?>
						<img src="<?php echo esc_url( ( $logo_for_onepage['light'] ) ? $logo_for_onepage['light'] : $logo_for_onepage['light_retina'] ); ?>" <?php if ( $logo_for_onepage['have_vector'] ) { echo ' class="svg-logo"'; } ?><?php if ( $logo_for_onepage['light_retina'] ) { echo ' srcset="' . $logo_for_onepage['light_retina'] . ' 2x"'; } ?> alt="<?php echo esc_attr( $logo_text ); ?>">
					<?php else : ?>
						<?php echo esc_html( $logo_text ); ?>
					<?php endif; ?>
				</span>
			</div>
		</a>
	</div>
</div><!-- .site-branding -->