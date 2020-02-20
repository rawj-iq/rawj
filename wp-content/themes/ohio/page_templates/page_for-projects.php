<?php /* Template Name: Portfolio page */ ?>

<?php
	global $post;

	$GLOBALS['ohio_icon_fonts'][] = 'my-icon-arr-out';
	OhioHelper::add_required_script( 'masonry' );
	OhioHelper::add_required_script( 'isotope' );

	OhioBuffer::start_content_bufferization();

	$show_breadcrumbs = OhioOptions::get( 'page_breadcrumbs_visibility', true );
	$page_wrapped = OhioOptions::get( 'page_add_wrapper', true );
	$add_content_padding = OhioOptions::get( 'page_add_top_padding', true );

	// Projects count
	$count_projects = wp_count_posts( 'ohio_portfolio' );
	$published_projects = $count_projects->publish;

	if ( get_query_var( 'paged' ) ) {
		$pagination_page = get_query_var( 'paged' );
	} elseif ( get_query_var( 'page' ) ) {
		$pagination_page = get_query_var( 'page' );
	} else {
		$pagination_page = 1;
	}

	// Pagination settings
	$projects_per_page = (int) OhioOptions::get( 'portfolio_projects_per_page', 12, false, true );

	$projects_offset = ( $pagination_page - 1 ) * $projects_per_page;

	$paginator_current = $pagination_page;
	if ( ! $projects_per_page || $projects_per_page < 1 ) {
		$projects_per_page = 1;
	}
	$paginator_all = ceil( $published_projects / $projects_per_page );

	$pagination_type = OhioOptions::get( 'pagination_type', 'simple' );

	$pagination_position = OhioOptions::get( 'pagination_position', 'left' );

	// Filter
	$show_filter = OhioOptions::get( 'project_page_filter_visibility', true );
	$filter_align = OhioOptions::get( 'project_filter_align', 'center' );

	$filter_align_class = '';
	switch ( $filter_align ) {
		case 'left':
			$filter_align_class = ' text-left';
			break;
		case 'right':
			$filter_align_class = ' text-right';
			break;
	}

	// Popup
	$open_in_popup = OhioOptions::get_global( 'portfolio_projects_in_popup' );
	$show_view_link_in_popup = OhioOptions::get( 'portfolio_lightbox_link', true );
	$metro_style = OhioOptions::get( 'portfolio_metro_style', false );


	// Pagintaion results
	$projects_show_from = ( $projects_offset + 1 <= $published_projects ) ? $projects_offset + 1 : $published_projects ;
	$projects_show_to = $projects_offset + $projects_per_page;
	if ( $projects_show_to > $published_projects ) {
		$projects_show_to = $published_projects;
	}

	$allowed_categories = OhioOptions::get( 'portfolio_categories', [] );

	$args = array(
		'posts_per_page'	=> $projects_per_page,
		'offset'			=> $projects_offset,
		'category'			=> '',
		'category_name'		=> '',
		'orderby'			=> 'date',
		'order'				=> 'DESC',
		'include'			=> '',
		'exclude'			=> '',
		'post_type'			=> 'ohio_portfolio',
		'post_mime_type' 	=> '',
		'post_parent'		=> '',
		'author'			=> '',
		'author_name'		=> '',
		'post_status'		=> 'publish',
		'suppress_filters' 	=> false
	);

	if ( is_array( $allowed_categories ) && count( $allowed_categories ) > 0 ) {
		$args['tax_query'] = [[
			'taxonomy' => 'ohio_portfolio_category',
			'field' => 'id',
			'terms' => $allowed_categories
		]];
	}

	$projects_array = get_posts( $args );

	// Animation type & effect
	$animation_type = OhioOptions::get( 'page_animation_type' );
	$animation_effect = OhioOptions::get( 'page_animation_effect' );

	// Sidebar
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

	// Portfolio grid paddings
	$grid_item_style_class = '';
	$posts_without_paddings = OhioOptions::get( 'grid_items_without_padding', false );
	$hover_effect = OhioOptions::get( 'portfolio_grid_hover' );

	$boxed_classes = '';
	$boxed = OhioOptions::get( 'portfolio_items_boxed_style', true );
	if ( $boxed ) {
		$boxed_classes = 'boxed';
	}

	if ( $posts_without_paddings ) {
		$grid_item_style_class .= ' post-offset ';
	} else {
		$grid_item_style_class .= ' with-padding ';
	}

	// Page container class
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

	// Columns classes
	$columns_num = OhioOptions::get_local( 'portfolio_columns_in_row' );
 	
	if ( $columns_num == 'i-i-i') {
		$columns_num = OhioOptions::get_global( 'portfolio_columns_in_row' );
	}

	$columns_num_global = OhioOptions::get_global( 'portfolio_columns_in_row' );
	if ( ! $columns_num_global ) {
		$columns_num_global = '2-2-1';
	}

	$columns_class = OhioHelper::parse_columns_to_css( $columns_num, false, $columns_num_global );
	$columns_double_class = OhioHelper::parse_columns_to_css( $columns_num, true, $columns_num_global );

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

	// Portfolio layout type
	$projects_layout_item = OhioOptions::get( 'portfolio_item_layout_type', 'grid_1' );
    $content_location = OhioOptions::get_global( 'portfolio_content_position', 'top' );

    // Slider layouts
	$is_slider = false;

	switch ( $projects_layout_item ) {
		case 'grid_3':
		case 'grid_4':
		case 'grid_5':
		case 'grid_6':
		case 'grid_7':
		case 'grid_9':
		case 'grid_10':
			$is_slider = true;
			break;
	}

	if ( $is_slider ) {
		$navBtn = OhioOptions::get( 'portfolio_nav_visibility' );
		$loop = OhioOptions::get( 'portfolio_loop_mode' );
		$autoplay = OhioOptions::get( 'portfolio_autoplay_mode' );
		$autoplayTimeout = OhioOptions::get( 'portfolio_autoplay_interval', '', NULL, true );
		$mousewheel = OhioOptions::get( 'portfolio_mousewheel_mode' );
		$pagination = OhioOptions::get( 'portfolio_bullets_visibility', true );



		$slider_pagination_data = '';
		if ($pagination) {
			$slider_pagination_type = OhioOptions::get( 'portfolio_bullets_type' );

			if ($slider_pagination_type == 'bullets') {
				$slider_pagination_data = 'data-slider-dots="true"';
			} else {
				$slider_pagination_data = 'data-slider-pagination="true"';
			}
		}
		if ( $projects_layout_item === 'grid_6' ) {
			$slider_columns = OhioOptions::get( 'portfolio_columns_in_row' );
			$slider_columns_global = OhioOptions::get_global( 'portfolio_columns_in_row' );
			for ( $i = 0; $i < strlen( $slider_columns ); $i++ ) {
				if ( $slider_columns[$i] === 'i' ) $slider_columns[$i] = $slider_columns_global[$i];
			}
		}
	}
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
			<main id="main" class="site-main" data-ohio-portfolio-grid="true">

                <!-- Custom Content -->
                <?php
                if ($content_location == 'top'):
                    if(have_posts()) :
                        echo '<div class="page_content portfolio_page_content">';
                        while(have_posts()) : the_post();
                            the_content();
                        endwhile;
                        echo '</div>';
                    endif;
                endif;
                ?>

				<!-- Grid Layout -->
				<?php if ( ! $is_slider ) : ?>
					<div data-ohio-portfolio-grid="true">
						<?php if ( $show_filter ) : ?>
							<?php
								$cat_ids = get_terms( [
									'taxonomy' => 'ohio_portfolio_category',
									'include' => $allowed_categories
								] );
							?>
							<?php if ( is_array( $cat_ids ) && $cat_ids ) : ?>
								<div class="portfolio-sorting<?php echo esc_attr( $filter_align_class ); ?>" data-filter="portfolio">
									<ul class="unstyled">
										<li><?php esc_html_e( 'Filter by', 'ohio' ) ?></li>
										<li>
                                            <a class="active" href="#all" data-isotope-filter="*">
                                                <span class="name"><?php esc_html_e( 'All', 'ohio' ); ?></span>
                                                <span class="num"></span>
                                            </a>
		                                </li>
										<?php foreach ( $cat_ids as $cat_obj ) : ?>
											<li> /
												<a href="#<?php echo esc_attr( $cat_obj->slug ); ?>" data-isotope-filter=".ohio-filter-project-<?php echo hash( 'md4', $cat_obj->slug, false ); ?>">
													<span class="name"><?php echo esc_html( $cat_obj->name ); ?></span>
													<span class="num"></span>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>
						<?php endif; ?>

                        <div class="portfolio-grid vc_row<?php echo esc_attr( $grid_item_style_class ); ?>" data-isotope-grid="true" data-lazy-container="true" <?php echo esc_attr($asymmetric_atts); ?>>
                        <?php

						$_post_i = 0;
						foreach ( $projects_array as $_project_index => $_project_object ) {

							$ohio_project = OhioObjectParser::parse_to_project_object( $_project_object );
							$ohio_project['in_popup'] = $open_in_popup;
							if( $projects_layout_item == 'grid_1' || $projects_layout_item == 'grid_2'){
								$ohio_project['boxed'] = $boxed_classes;
								$ohio_project['hover_effect'] = $hover_effect;
								$ohio_project['metro_style'] = $metro_style;
							}
							OhioHelper::set_storage_item_data( $ohio_project );

							$col_class = $columns_class;
							if ( $ohio_project['grid_style'] == '2col' ) {
								$col_class = $columns_double_class;
								$col_class .= ' double-width';
							}
							// Animation calculating
							$_anim_attrs = '';
							if ( in_array( $animation_type, array( 'sync', 'async' ) ) ) {
								OhioHelper::add_required_script( 'aos' );
								$_anim_attrs .= ' data-aos-once="true"';
								$_anim_attrs .= ' data-aos="' . $animation_effect . '"';
								if ( $animation_type == 'async' && $columns_in_row ) {
									$columns_in_row = (int) substr( $columns_in_row, 0, 1);
									$_delay = ( 400 / $columns_in_row ) * ( $_post_i % $columns_in_row );
									$_delay = (int) $_delay - ( $_delay % 50 );
									$_anim_attrs .= ' data-aos-delay="' . $_delay . '"';
								}
							}
							echo '<div class="portfolio-item-wrap masonry-block' . esc_attr( $col_class ) . ' ohio-project-item ' . 'grid-item section ' . esc_attr( $ohio_project['categories_group'] ) . '" data-lazy-item="true">';
							if ( $_anim_attrs ) {
								echo '<div' . $_anim_attrs . '>';
							}

							switch ( $projects_layout_item ) {
								case 'grid_1':
									get_template_part( 'parts/portfolio_grid/portfolio_layout_type_1' );
									break;
								case 'grid_2':
									get_template_part( 'parts/portfolio_grid/portfolio_layout_type_2' );
									break;
								case 'grid_3':
									get_template_part( 'parts/portfolio_grid/portfolio_layout_type_3' );
									break;
								case 'grid_4':
									get_template_part( 'parts/portfolio_grid/portfolio_layout_type_4' );
									break;
								case 'grid_5':
									get_template_part( 'parts/portfolio_grid/portfolio_layout_type_5' );
									break;
								case 'grid_6':
									get_template_part( 'parts/portfolio_grid/portfolio_layout_type_6' );
									break;
								case 'grid_7':
									get_template_part( 'parts/portfolio_grid/portfolio_layout_type_7' );
									break;
								case 'grid_8':
									get_template_part( 'parts/portfolio_grid/portfolio_layout_type_8' );
									break;
								case 'grid_9':
									get_template_part( 'parts/portfolio_grid/portfolio_layout_type_9' );
									break;
								case 'grid_10':
									get_template_part( 'parts/portfolio_grid/portfolio_layout_type_10' );
									break;
								default:
									get_template_part(  'parts/portfolio_grid/portfolio_layout_type_1' );
									break;
							}
							echo '</div>';

							if ( $open_in_popup ) {
								$ohio_project['show_view_link_in_popup'] = $show_view_link_in_popup;
								
								ob_start();
								OhioHelper::set_storage_item_data( $ohio_project );
								get_template_part( 'parts/portfolio_grid/lightbox' );
								OhioLayout::append_to_footer_buffer_content( ob_get_clean() );
							}

							$_post_i++;

							if ( $_anim_attrs ) {
								echo '</div>';
							}
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
					</div>
				<?php endif; ?>

				<!-- Slider Layout -->

				<?php if ( $is_slider ) : ?>
					<?php 
						switch ( $projects_layout_item ) {
							
							case 'grid_6':
								$scroll_bar_push = 'vc_col-md-push-4';
								break;
							case 'grid_7':
								$scroll_bar_push = 'vc_col-md-push-4';
								break;
							default:
								$scroll_bar_push = 'vc_col-md-push-7';
								break;
						}
					?>

					<!-- Scroll label -->
					<div class="scroll-bar-container">
						<div class="page-container">
							<div class="vc_col-md-5 <?php echo esc_attr($scroll_bar_push) ?>">
								<div class="clb-scroll-top clb-slider-scroll-top vc_hidden-md vc_hidden-sm vc_hidden-xs">
									<div class="clb-scroll-top-bar">
										<div class="scroll-track"></div>
									</div>
									<div class="clb-scroll-top-holder font-titles">
										<?php esc_html_e( 'Scroll', 'ohio' ); ?>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="vc_row wpb_row vc_row-fluid vc_row-no-padding portfolio-onepage-slider clb-slider-scroll-bar <?php echo esc_attr($projects_layout_item); ?>" 
						data-portfolio-grid-slider="true" 
						data-vc-full-width="true" 
						data-vc-stretch-content="true" 
						data-slider-navigation="<?php echo esc_attr($navBtn);?>" 
						data-slider-loop="<?php echo esc_attr($loop);?>" 
						data-slider-mousescroll="<?php echo esc_attr($mousewheel);?>" 
						data-slider-autoplay="<?php echo esc_attr($autoplay);?>" 
						data-slider-autoplay-time="<?php echo esc_attr($autoplayTimeout);?>" 
						data-slider-autoplay-pause="<?php echo esc_attr($slider_pagination_data);?>" 
						data-slider-columns="<?php if ( $projects_layout_item === 'grid_6') echo esc_attr($slider_columns);?>"
						<?php echo esc_attr($slider_pagination_data);?>>

						<?php 
							$_post_i = 0;
							$_prev_item_featured_image = '';
							foreach ( $projects_array as $_project_index => $_project_object ) {
								$ohio_project = OhioObjectParser::parse_to_project_object( $_project_object );
								$ohio_project['in_popup'] = $open_in_popup;
								if ($_project_index == 0) {
									$_last_project = OhioObjectParser::parse_to_project_object( $projects_array[count($projects_array) - 1] );
									$ohio_project['prev_item_featured_image'] = $_last_project['featured_image'];
								} else {
									$ohio_project['prev_item_featured_image'] = $_prev_item_featured_image;
								}
								$_prev_item_featured_image = $ohio_project['featured_image'];
								OhioHelper::set_storage_item_data( $ohio_project );

								switch ( $projects_layout_item ) {
									case 'grid_3':
										get_template_part( 'parts/portfolio_grid/portfolio_layout_type_3' );
										break;
									case 'grid_4':
										get_template_part( 'parts/portfolio_grid/portfolio_layout_type_4' );
										break;
									case 'grid_5':
										get_template_part( 'parts/portfolio_grid/portfolio_layout_type_5' );
										break;
									case 'grid_6':
										get_template_part( 'parts/portfolio_grid/portfolio_layout_type_6' );
										break;
									case 'grid_7':
										get_template_part( 'parts/portfolio_grid/portfolio_layout_type_7' );
										break;
									case 'grid_9':
										get_template_part( 'parts/portfolio_grid/portfolio_layout_type_9' );
										break;
									case 'grid_10':
										get_template_part( 'parts/portfolio_grid/portfolio_layout_type_10' );
										break;
								}

								if ( $open_in_popup ) {
									$ohio_project['show_view_link_in_popup'] = $show_view_link_in_popup; 
									ob_start();
									OhioHelper::set_storage_item_data( $ohio_project );
									get_template_part( 'parts/portfolio_grid/lightbox' );
									OhioLayout::append_to_footer_buffer_content( ob_get_clean() );
								}
							}
						?>

					</div>
				<?php endif; ?>

				<!-- Custom content -->
				<?php if ($content_location == 'bottom'):
					if(have_posts()) :
						echo '<div class="page_content portfolio_page_content">';
						while(have_posts()) : the_post();
							the_content();
						endwhile;
						echo '</div>';
					endif;
				endif; ?>

			</main>
		</div>

		<?php if ( $sidebar_position == 'right' ) : ?>
		<div class="page-sidebar sidebar-right<?php echo esc_attr( $sidebar_class ); ?>">
			<aside id="secondary" class="widget-area">
				<?php dynamic_sidebar( 'ohio-sidebar-blog' ); ?>
			</aside>
		</div>
		<?php endif; ?>

	</div><!-- #primary -->
</div><!--.page-container-->

<?php

	// - - - page layout output
	OhioBuffer::stop_content_bufferization();

	get_header();
	OhioBuffer::get_content_buffer();
	get_footer();
