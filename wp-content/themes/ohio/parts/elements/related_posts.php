<?php
// Settings
$post_show_related = OhioOptions::get_global( 'post_related_posts_visibility', true );

$meta_visibility = array(
    'author_visibility' => OhioOptions::get_global( 'posts_author_visibility', true ),
    'category_visibility' =>  OhioOptions::get_global( 'posts_category_visibility', true ),
    'short_description_visibility' => OhioOptions::get_global( 'posts_short_description_visibility', true ),
    'read_more_visibility' => OhioOptions::get_global( 'posts_read_more_visibility', true ),
    'reading_time_visibility' => OhioOptions::get_global( 'posts_reading_time_visibility', true )
);

if ( $post_show_related ) {
	global $post;
	$tags = wp_get_post_tags( $post->ID );
	$tag_ids = array();
	foreach ( $tags as $individual_tag ) {
		$tag_ids[] = intval( $individual_tag->term_id );
	}
	$categories = wp_get_post_categories( $post->ID );
	$category_ids = array();
	foreach ( $categories as $individual_category ) {
		$category_ids[] = intval( $individual_category );
	}

	$args = array(
		'tag__in' => $tag_ids,
		'category__in' => $category_ids,
		'post__not_in' => array( $post->ID ),
		'posts_per_page' => 2,
		'ignore_sticky_posts' => 1
	);

	$related_query = new wp_query( $args );

	if ( $related_query->found_posts > 0 ) {
	$posts_count = intval( $related_query->found_posts );
	if ( $posts_count >= 1 ) { $grid_size = 6; }

?>
	<div class="related-posts">
		<div class="page-container">
			<div class="vc_row">
				<div class="vc_col-md-12">
					<h4 class="heading-md related-post-heading">
						<?php esc_html_e( 'Recent Posts', 'ohio' ); ?>
					</h4>
				</div>
				<?php
					while( $related_query->have_posts() ):
						$related_query->the_post();
						$parsed_post = OhioObjectParser::parse_to_post_object( $post, 'index' );
						$parsed_post['meta_visibility'] = $meta_visibility;
						$parsed_post['boxed'] = true;
						OhioHelper::set_storage_item_data( $parsed_post );
				?>
						<div class="vc_col-md-<?php echo esc_attr( $grid_size ); ?> vc_col-xs-12 vc_col-blog">
							<?php get_template_part( 'parts/blog_grid/layout_type1' ); ?>
						</div>
				<?php
					endwhile;
				?>
			</div>
		</div>
	</div>
	<?php
	}
	
	wp_reset_postdata();
}