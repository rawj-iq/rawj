<?php 
	$project = OhioObjectParser::parse_to_project_object( $post );
?>
<div class="sticky-nav">
	<div class="sticky-nav-image"
		<?php if ($project['next']['image']) { 
			echo 'style="background-image: url(\'' . $project['next']['image'] . '\');"';
		}?>
		>
	</div>
	<div class="sticky-nav-holder">
		<div class="sticky-nav_item">
			<h6 class="heading-sm">
				<?php esc_html_e( 'Next Project', 'ohio' ); ?>
			</h6>
			<div class="nav-holder">
				<a href="<?php echo esc_url( $project['prev']['url'] ); ?>" class="btn-round btn-round-small btn-round-light">
					<i class="ion"><svg class="arrow-icon arrow-icon-back" width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 7H16M16 7L11 1M16 7L11 13" stroke-width="2"/></svg></i>
				</a>
				<a href="<?php echo esc_url( $project['next']['url'] ); ?>" class="btn-round btn-round-small btn-round-light">
					<i class="ion"><svg class="arrow-icon" width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 7H16M16 7L11 1M16 7L11 13" stroke-width="2"/></svg></i>
				</a>	
			</div>
		</div>
		<a href="<?php echo esc_url( $project['next']['url'] ); ?>">
			<h5 class="sticky-nav_heading">
				<?php echo wp_kses( $project['next']['title'], 'default' ); ?>
			</h5>
		</a>	
	</div>
</div>