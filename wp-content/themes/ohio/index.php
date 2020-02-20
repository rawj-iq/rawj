<?php
    OhioBuffer::start_content_bufferization();

    $published_posts = $GLOBALS['wp_query']->found_posts;

    if ( get_query_var( 'paged' ) ) {
        $pagination_page = get_query_var( 'paged' );
    } elseif ( get_query_var( 'page' ) ) {
        $pagination_page = get_query_var( 'page' );
    } else {
        $pagination_page = 1;
    }

    $posts_per_page = OhioSettings::posts_per_page();

    $posts_offset = ( $pagination_page - 1 ) * $posts_per_page;
    $paginator_all = ceil( $published_posts / (int) $posts_per_page );

    $pagination_type = OhioOptions::get( 'pagination_type', 'simple' );
    $pagination_position = OhioOptions::get( 'pagination_position', 'left' );

    $posts_show_from = $posts_offset + 1;
    $posts_show_to = $posts_offset + $posts_per_page;
    if ( $posts_show_to > $published_posts ) {
        $posts_show_to = $published_posts;
    }

    // Sidebar
    $sidebar_position = OhioOptions::get( 'page_sidebar_position', 'without' );
    $sidebar_page_class = '';
    if ( is_active_sidebar( 'Ohio-sidebar-blog' ) ) {
        if ( $sidebar_position == 'left' ) {
            $sidebar_page_class = ' with-left-sidebar';
        }
        if ( $sidebar_position == 'right' ) {
            $sidebar_page_class = ' with-right-sidebar';
        }
    }

    $sidebar_layout = OhioOptions::get( 'page_sidebar_layout', 'simple' );
    $sidebar_class = '';
    if ( $sidebar_layout ) {
        $sidebar_class .= ' sidebar-' . $sidebar_layout;
    }

    $page_wrapped = OhioOptions::get( 'page_add_wrapper', true );

    // Grid style
    $posts_grid = OhioOptions::get_global( 'blog_page_layout', 'masonry' );
    if ( $posts_grid == 'masonry' ) {
        OhioHelper::add_required_script( 'masonry' );
    }
    $grid_style_class = ( $posts_grid == 'masonry' ) ? 'ohio-masonry blog-posts-masonry' : 'blog-posts-classic';

    $posts_layout_item = OhioOptions::get_global( 'blog_item_layout_type', 'blog_grid_1' );

    // Columns
    $columns_num = OhioOptions::get_global( 'blog_columns_in_row', '2-2-1' );
    if ( $posts_grid == 'classic' ) {
        $columns_num = '2-2-1';
    }
    $columns_class = OhioHelper::parse_columns_to_css( $columns_num, false );
    $columns_double_class = OhioHelper::parse_columns_to_css( $columns_num, true );

    $grid_item_style_class = '';
    $posts_without_paddings = OhioOptions::get( 'grid_items_without_padding', false );
    if ( $posts_without_paddings ) {
        $grid_item_style_class .= ' post-offset';
    }

    $show_breadcrumbs = OhioOptions::get( 'page_breadcrumbs_visibility', true );

    $page_container_class = '';
    if ( !$show_breadcrumbs ) {
        $page_container_class .= ' top-offset';
    }
    if ( !$page_wrapped ) {
        $page_container_class .= ' full';
    }

    $metro_style = OhioOptions::get( 'blog_metro_style' );
    $boxed = OhioOptions::get( 'blog_items_boxed_style' );
    if ( !is_bool( $boxed ) ) {
        if ( $boxed == 'default' ) $boxed = false;
        else $boxed = true;
    }
    $alignment = OhioOptions::get( 'posts_text_alignment', 'global' );
    $hover_effect = OhioOptions::get( 'blog_item_hover_type', 'global' );
    $meta_visibility = array(
        'author_visibility' => OhioOptions::get( 'posts_author_visibility', true ),
        'category_visibility' =>  OhioOptions::get( 'posts_category_visibility', true ),
        'short_description_visibility' => OhioOptions::get( 'posts_short_description_visibility', true ),
        'read_more_visibility' => OhioOptions::get( 'posts_read_more_visibility', true ),
        'reading_time_visibility' => OhioOptions::get( 'posts_reading_time_visibility', true )
    );

    if ( have_posts() ) :
?>

        <?php get_template_part( 'parts/elements/page_headline' ); ?>

        <?php get_template_part( 'parts/elements/breadcrumbs' ); ?>

        <div class="page-container bottom-offset<?php echo esc_attr( $page_container_class ); ?>">
            <?php if ( is_active_sidebar( 'Ohio-sidebar-blog' ) && $sidebar_position == 'left' ) : ?>
                <div class="page-sidebar sidebar-left<?php echo esc_attr( $sidebar_class ); ?>">
                    <aside id="secondary" class="widget-area">
                        <?php dynamic_sidebar( 'Ohio-sidebar-blog' ); ?>
                    </aside>
                </div>
            <?php endif; ?>

            <div id="primary" class="page-content content-area<?php echo esc_attr( $sidebar_page_class ); ?>">
                <main id="main" class="site-main">
                    <div class="vc_row <?php echo esc_attr( $grid_style_class ); ?>" data-lazy-container="true">
                        <?php
                        $_post_i = 0;
                        while ( have_posts() ) : the_post();

                            $post->metro = $metro_style;
                            $parsed_post = OhioObjectParser::parse_to_post_object( $post, 'index' );
                            $parsed_post['metro_style'] = $metro_style;
                            $parsed_post['boxed'] = $boxed;
                            $parsed_post['alignment'] = $alignment;
                            $parsed_post['hover_effect'] = $hover_effect;
                            $parsed_post['meta_visibility'] = $meta_visibility;

                            OhioHelper::set_storage_item_data( $parsed_post );
                            $col_class = $columns_class;
                            $grid_class = ' grid-item';

                            if ( $parsed_post['grid_style'] == '2col' ) {
                                $col_class = $columns_double_class;
                            }

                            // Animation calculating
                            $_anim_attrs = '';
                            if ( in_array( $parsed_post['animation_type'], array( 'sync', 'async' ) ) ) {
                                OhioHelper::add_required_script( 'aos' );

                                $_anim_attrs .= ' data-aos-once="true"';
                                $_anim_attrs .= ' data-aos="' . $parsed_post['animation_effect'] . '"';
                                if ( $parsed_post['animation_type'] == 'async' ) {
                                    $columns_num = (int) substr( $columns_num, 0, 1);
                                    $_delay = ( 400 / $columns_num ) * ( $_post_i % $columns_num );
                                    $_delay = (int) $_delay - ( $_delay % 50 );
                                    $_anim_attrs .= ' data-aos-delay="' . $_delay . '"';
                                }
                            }

                            $grid_class = (( $parsed_post['grid_style'] != '2col' ) ? ' grid-item' : '' );

                            echo '<div class="' . esc_attr( $col_class . $grid_class . $grid_item_style_class . ( ( $posts_grid == 'masonry' ) ? ' masonry-block' : '' ) ) . '" ' . $_anim_attrs . ' data-lazy-item="true">';
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
                        endwhile;
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
                </main>
            </div>

            <?php if ( is_active_sidebar( 'Ohio-sidebar-blog' ) && $sidebar_position == 'right' ) : ?>
                <div class="page-sidebar sidebar-right<?php echo esc_attr( $sidebar_class ); ?>">
                    <aside id="secondary" class="widget-area">
                        <?php dynamic_sidebar( 'Ohio-sidebar-blog' ); ?>
                    </aside>
                </div>
            <?php endif; ?>
            
        </div>

<?php else : ?>

        <?php get_template_part( 'parts/content', 'none' ); ?>

<?php endif;

    // - - - page layout
    OhioBuffer::stop_content_bufferization();

    get_header();
    OhioBuffer::get_content_buffer();
    get_footer();
