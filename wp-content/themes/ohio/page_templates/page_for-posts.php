<?php /* Template Name: Blog page */ ?>

<?php
	OhioBuffer::start_content_bufferization();

	$show_breadcrumbs = OhioOptions::get( 'page_breadcrumbs_visibility', true );
	$page_wrapped = OhioOptions::get( 'page_add_wrapper', true );
	$add_content_padding = OhioOptions::get( 'page_add_top_padding', true );

	$categories = OhioOptions::get_local( 'blog_categories' );
	$categories = ( is_array( $categories ) ) ? implode( ',', $categories ) : '';

	$count_args = array(
		'cat' => $categories,
		'post_type' => 'post',
		'post_status' => 'publish'
	);
	$the_query = new WP_Query( $count_args );
	$published_posts = $the_query->found_posts;

	if ( get_query_var( 'paged' ) ) {
		$pagination_page = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
		$pagination_page = get_query_var( 'page' );
	} else {
		$pagination_page = 1;
	}

	$posts_per_page = OhioSettings::posts_per_page();
	$posts_offset = ( $pagination_page - 1 ) * $posts_per_page;

	$pagination_type = OhioOptions::get( 'pagination_type', 'simple' );
	$pagination_position = OhioOptions::get( 'pagination_position', 'left' );

	$paginator_current = $pagination_page;
	if ( ! $posts_per_page || $posts_per_page < 1 ) {
		$posts_per_page = 1;
	}
	$paginator_all = ceil( $published_posts / $posts_per_page );

	$posts_show_from = $posts_offset + 1;
	$posts_show_to = $posts_offset + $posts_per_page;
	if ( $posts_show_to > $published_posts ) {
		$posts_show_to = $published_posts;
	}

	$args = array(
		'posts_per_page' => $posts_per_page,
		'offset' => $posts_offset,
		'category' => $categories,
		'orderby' => 'date',
		'order' => 'DESC',
		'include' => '',
		'exclude' => '',
		'meta_key' => '',
		'meta_value' => '',
		'post_type' => 'post',
		'post_mime_type' => '',
		'post_parent' => '',
		'author' => '',
		'author_name' => '',
		'post_status' => 'publish',
		'suppress_filters' => false
	);
	$posts_array = get_posts( $args );

	$sidebar_position = OhioOptions::get( 'page_sidebar_position', 'left' );
	$sidebar_page_class = '';
	if ( $sidebar_position == 'left' ) {
		$sidebar_page_class = ' with-left-sidebar';
	}
	if ( $sidebar_position == 'right' ) {
		$sidebar_page_class = ' with-right-sidebar';
	}

	$sidebar_layout = OhioOptions::get( 'page_sidebar_layout', 'simple' );
	$sidebar_class = '';
	if ( $sidebar_layout ) {
		$sidebar_class .= ' sidebar-' . $sidebar_layout;
	}

	$metro_style = OhioOptions::get( 'blog_metro_style' );
	$boxed = OhioOptions::get( 'blog_items_boxed_style' );
	if ( !is_bool( $boxed ) ) {
		if ( $boxed == 'default' ) $boxed = false;
		else $boxed = true;
	}
	$alignment = OhioOptions::get( 'posts_text_alignment' );
	$hover_effect = OhioOptions::get( 'blog_item_hover_type', 'type1' );
	$meta_visibility = array(
		'author_visibility' => OhioOptions::get( 'posts_author_visibility', true ),
		'category_visibility' =>  OhioOptions::get( 'posts_category_visibility', true ),
		'short_description_visibility' => OhioOptions::get( 'posts_short_description_visibility', true ),
		'read_more_visibility' => OhioOptions::get( 'posts_read_more_visibility', true ),
		'reading_time_visibility' => OhioOptions::get( 'posts_reading_time_visibility', true )
	);

	$posts_grid = OhioOptions::get( 'blog_page_layout', 'masonry' );
	if ( $posts_grid == 'masonry' ) {
		OhioHelper::add_required_script( 'masonry' );
	}
	$grid_style_class = ( $posts_grid == 'masonry' ) ? 'blog-posts-masonry ohio-masonry' : 'blog-posts-classic';


	$grid_item_style_class = '';
	$posts_without_paddings = OhioOptions::get( 'grid_items_without_padding', false );
	if ( $posts_without_paddings ) {
		$grid_item_style_class .= ' post-offset';
	}

	
	
	$columns_num = OhioOptions::get_local( 'blog_columns_in_row' );

	$columns_in_row = explode( '-', $columns_num );
	if ( is_array( $columns_in_row ) ) {
		$columns_in_row = intval( $columns_in_row[0] );
	}

	$asymmetric_parallax = OhioOptions::get( 'grid_asymmetric_parallax', false );
	$asymmetric_atts = "";
	
	if ($asymmetric_parallax) {

		$asymmetric_parallax_speed = (int) OhioOptions::get( 'asymmetric_parallax_speed', 20, false, true );
		$asymmetric_atts = ' data-asymmetric-parallax-grid=true data-grid-number='. $columns_num .' data-asymmetric-parallax-speed='. $asymmetric_parallax_speed. '';
	}

	if ( $columns_num == "i-i-i" ) $columns_num = OhioOptions::get_global( 'blog_columns_in_row', '2-2-1' );
	$columns_num_global = OhioOptions::get_global( 'blog_columns_in_row', '2-2-1' );
	
	$posts_layout_item = OhioOptions::get( 'blog_item_layout_type', 'blog_grid_1' );

	$animation_type = OhioOptions::get( 'page_animation_type', 'default' );
	$animation_effect = OhioOptions::get( 'page_animation_effect', 'fade-up' );

	if ( $posts_grid == 'blog_grid_1' ) { $columns_num = '2-2-1'; }



	$columns_class = OhioHelper::parse_columns_to_css( $columns_num, false, $columns_num_global );
	$columns_double_class = OhioHelper::parse_columns_to_css( $columns_num, true, $columns_num_global );

	$page_container_class = '';
	if ( !$show_breadcrumbs && $add_content_padding ) {
		$page_container_class .= ' top-offset';
	}
	if ( !$page_wrapped ) {
		$page_container_class .= ' full';
	}
	if ( $add_content_padding ) {
		$page_container_class .= ' bottom-offset';
	}

    $content_location = OhioOptions::get_global( 'post_content_position', 'top' );
?>

<?php get_template_part( 'parts/elements/page_headline' ); ?>

<?php get_template_part( 'parts/elements/breadcrumbs' ); ?>

<div class="page-container<?php echo esc_attr( $page_container_class ); ?>">
	<div id="primary" class="content-area">

		<?php if ( $sidebar_position == 'left' ) : ?>
		<div class="page-sidebar sidebar-left<?php echo esc_attr( $sidebar_class ); ?>">
			<aside id="secondary" class="widget-area">
				<?php dynamic_sidebar( 'ohio-sidebar-blog' ); ?>
			</aside>
		</div>
		<?php endif; ?>

		<div class="page-content<?php echo esc_attr( $sidebar_page_class ); ?>">
			<main id="main" class="site-main">

                <!-- Custom content -->
                <?php
                if ($content_location == 'top'):
                    if(have_posts()) :
                        echo '<div class="page_content blog_page_content">';
                        while(have_posts()) : the_post();
                            the_content();
                        endwhile;
                        echo '</div>';
                    endif;
                endif;
                ?>

				<div class="vc_row <?php echo esc_attr( $grid_style_class ); ?>" data-lazy-container="true" <?php echo esc_attr($asymmetric_atts); ?>>
				<?php
				$_post_i = 0;
				foreach ( $posts_array as $post_index => $post ) {
					$post->metro = $metro_style;
					$_parsed_post = OhioObjectParser::parse_to_post_object( $post, NULL, $_post_i + 1 );
					$_parsed_post['metro_style'] = $metro_style;
					$_parsed_post['alignment'] = $alignment;
					$_parsed_post['hover_effect'] = $hover_effect;
					$_parsed_post['meta_visibility'] = $meta_visibility;
					$_parsed_post['boxed'] = $boxed;
					OhioHelper::set_storage_item_data( $_parsed_post );

					$col_class = $columns_class;
					$grid_class = ' grid-item';

					if ( $_parsed_post['grid_style'] == '2col' ) {
						$col_class = $columns_double_class;
					}

					// Animation calculating
					$_anim_attrs = '';
					if ( in_array( $animation_type, array( 'sync', 'async' ) ) ) {
						OhioHelper::add_required_script( 'aos' );

						$_anim_attrs .= ' data-aos-once="true"';
						$_anim_attrs .= ' data-aos="' . $animation_effect . '"';
						if ( $animation_type == 'async' ) {
							$columns_num = (int) substr( $columns_num, 0, 1 );
							if ( $columns_num <= 0 ) { $columns_num = 1; }
							$_delay = ( 400 / $columns_num ) * ( $_post_i % $columns_num );
							$_delay = (int) $_delay - ( $_delay % 50 );
							$_anim_attrs .= ' data-aos-delay="' . $_delay . '"';
						}
					}

					echo '<div class="' . esc_attr( $col_class . $grid_class . $grid_item_style_class . ( ( $posts_grid == 'masonry' ) ? ' ohio-card-wrapper blog-post-masonry masonry-block' : '' ) ) . '" ' . $_anim_attrs . ' data-lazy-item="true">';

					switch ( $posts_layout_item ) {
						case 'blog_grid_1':
							get_template_part( 'parts/blog_grid/layout_type1' );
							break;
						case 'blog_grid_2':
							get_template_part( 'parts/blog_grid/layout_type2' );
							break;
						case 'blog_grid_3':
							get_template_part( 'parts/blog_grid/layout_type3' );
							break;
						case 'blog_grid_4':
							get_template_part( 'parts/blog_grid/layout_type4' );
							break;
						case 'blog_grid_5':
							get_template_part( 'parts/blog_grid/layout_type5' );
							break;
						default:
							get_template_part( 'parts/blog_grid/layout_type1' );
							break;
					}
					echo '</div>';

					$_post_i++;
				}
				?>
				</div>

				<?php

                if ( $paginator_all > 1 ) {
					$large_number = 10000000;
					$paginator_pattern = str_replace( $large_number, '{{page}}', get_pagenum_link( $large_number ) );
                    switch ( $pagination_type ) {
                        case 'simple':
                            OhioLayout::the_paginator_layout( $pagination_page, $paginator_all, $pagination_position );
                            break;
                        case 'standard':
                            echo '<div class="pagination-standard">';
                            OhioLayout::the_paginator_layout( $pagination_page, $paginator_all, $pagination_position );
                            echo '</div>';
                            break;
                        case 'lazy_scroll':
                            echo '<div class="lazy-load loading font-titles text-' . $pagination_position . '" data-lazy-load="scroll" data-lazy-pages-count="' . esc_attr( $paginator_all ) . '" data-lazy-load-url-pattern="' . esc_attr( $paginator_pattern ) . '">';
                            echo '<span class="btn-round btn-round-light" tabindex="0"><i class="ion ion-md-sync"></i></span>';
                            echo '<span class="loading-text">' . esc_html__( 'Loading', 'ohio' ) . '</span>';
                            echo '</div>';
                            break;
                        case 'lazy_button':
                            echo '<div class="lazy-load load-more font-titles text-' . $pagination_position . '" data-lazy-load="click" data-lazy-pages-count="' . esc_attr( $paginator_all ) . '" data-lazy-load-url-pattern="' . esc_attr( $paginator_pattern ) . '">';
                            echo '<span class="btn-round btn-round-light" tabindex="0"><i class="ion ion-md-sync"></i></span>';
                            echo '<span class="loadmore-text">' . esc_html__( 'Load More', 'ohio' ) . '</span>';
                            echo '<span class="loading-text">' . esc_html__( 'Loading', 'ohio' ) . '</span>';
                            echo '</div>';
                            break;
                        }
                    }
                ?>

                <!-- Custom content -->
                <?php
                if ($content_location == 'bottom'):
                    if(have_posts()) :
                        echo '<div class="page_content blog_page_content">';
                        while(have_posts()) : the_post();
                            the_content();
                        endwhile;
                        echo '</div>';
                    endif;
                endif;
                ?>

			</main>
		</div>

		<?php if ( $sidebar_position == 'right' ) : ?>
			<div class="page-sidebar sidebar-right<?php echo esc_attr( $sidebar_class ); ?>">
				<aside id="secondary" class="widget-area">
					<?php dynamic_sidebar( 'ohio-sidebar-blog' ); ?>
				</aside>
			</div>
		<?php endif; ?>
		
	</div>
</div>
<?php

	// - - - page layout output
	OhioBuffer::stop_content_bufferization();

	get_header();
	OhioBuffer::get_content_buffer();
	get_footer();
