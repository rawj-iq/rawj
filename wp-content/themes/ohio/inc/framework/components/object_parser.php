<?php

class OhioObjectParser {

	/**
	* Parse post data from object
	*/
	static function parse_to_post_object( $_post, $_context = 'index', $_index = false ) {
		$post_object = array( 'index' => $_index, 'media' => array() );

		$post_object['post_id'] = $_post->ID;
		$post_object['date'] = get_the_date( get_option( 'date_format' ), $_post->ID );
		$post_object['title'] = $_post->post_title;
		if ( ! $post_object['title'] ) { 
			$post_object['title'] = '[' . get_the_date( get_option( 'date_format' ), $_post->ID ) . ']';
		}
		$post_object['url'] = get_permalink( $_post->ID );
		$post_object['author'] = get_the_author_meta( 'display_name', $_post->post_author );
		
		$categories = wp_get_post_categories( $_post->ID );
		foreach ($categories as $_i => $_category) {
			$categories[$_i] = get_category( $_category );
		}
		$post_object['categories'] = $categories;

		$_raw_post = get_post( $_post->ID );

        $content_preview = '';
        $content_preview = get_the_excerpt( $_raw_post );
        if ( ! $content_preview ) {
            $content_preview = preg_replace( '/\[.+?\]/', '', $_post->post_content );
        }
        $post_object['preview'] = $content_preview;

        if( function_exists('get_field')){
            $post_object['overlay'] = get_field( 'post_overlay_color', $_post->ID );
        } else {
            $post_object['overlay'] = get_post_meta( $_post->ID, 'post_overlay_color' );
        }

		// formats
		$format = get_post_format( $_post->ID );

        $size = OhioOptions::get_global( 'blog_images_size', 'medium_large' );
		$image_url = get_the_post_thumbnail_url( $_post->ID, $size );
		if($image_url) {
            $post_object['media']['image'] = $image_url;
        } else {
		    $post_object['media']['image'] = false;
        }

		$post_object['media']['audio'] = false;
		if ( $format == 'audio' ) {
			preg_match( '/\[audio.+?\](\s)*(\[\/audio\])?/', $_post->post_content, $audio_matches);
			preg_match( '/\<iframe[^\>]*soundcloud\.com\/player[^\>]*>(\s)*(\<\/iframe\>)?/', $_post->post_content, $soundcloud_matches);
			if ( is_array( $audio_matches ) && $audio_matches ) {
				$post_object['media']['audio'] = do_shortcode( $audio_matches[0] );
			}
			if ( is_array( $soundcloud_matches ) && $soundcloud_matches ) {
				if ( is_array( $audio_matches ) && $audio_matches ) {
					if ( strpos( $_post->post_content, $soundcloud_matches[0] ) < strpos( $_post->post_content, $audio_matches[0] ) ) {
						$post_object['media']['audio'] = $soundcloud_matches[0];
					}
				} else {
					$post_object['media']['audio'] = $soundcloud_matches[0];
				}
			}
		}

		$post_object['media']['video'] = false;
		if ( $format == 'video' ) {
			preg_match( '/\[video.+?\](\s)*(\[\/video\])?/', $_post->post_content, $video_matches );
			preg_match( '/(http:|https:)?\/\/(www\.)?youtube\.com\/watch?[^\s\"\]]*/', $_post->post_content, $youtube_link_matches );
			preg_match( '/(http:|https:)?\/\/(www\.)?vimeo\.com\/[\d]+[^\s\"\]]*/', $_post->post_content, $vimeo_link_matches );
			preg_match( '/\<iframe[^\>]*youtube\.com\/embed[^\>]*>(\s)*(\<\/iframe\>)?/', $_post->post_content, $youtube_frame_matches );
			preg_match( '/\<iframe[^\>]*vimeo\.com\/video[^\>]*>(\s)*(\<\/iframe\>)?/', $_post->post_content, $vimeo_frame_matches );
			if ( is_array( $video_matches ) && $video_matches ) {
				$post_object['media']['video'] = do_shortcode( $video_matches[0] );
			}
			if ( is_array( $vimeo_link_matches ) && $vimeo_link_matches ) {
				$video_key = urlencode( substr( $vimeo_link_matches[0], strpos( $vimeo_link_matches[0], 'vimeo.com/' ) + 10 ) );
				$post_object['media']['video'] = '<iframe src="https://player.vimeo.com/video/' . $video_key . '" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" frameborder="0"></iframe>';
			}
			if ( is_array( $vimeo_frame_matches ) && $vimeo_frame_matches ) {
				$vimeo_frame_matches[0] = preg_replace( array( '/height\=\"[\d]+?\"/', '/width\=\"[\d]+?\"/' ), '', $vimeo_frame_matches[0] );
				$post_object['media']['video'] = do_shortcode( $vimeo_frame_matches[0] );
			}
			if ( is_array( $youtube_link_matches ) && $youtube_link_matches ) {
				$video_key = urlencode( substr( $youtube_link_matches[0], strpos( $youtube_link_matches[0], 'v=' ) + 2 ) );
				$post_object['media']['video'] = '<iframe src="https://www.youtube.com/embed/' . $video_key . '" frameborder="0" allowfullscreen></iframe>';
			}
			if ( is_array( $youtube_frame_matches ) && $youtube_frame_matches ) {
				$youtube_frame_matches[0] = preg_replace( array( '/height\=\"[\d]+?\"/', '/width\=\"[\d]+?\"/' ), '', $youtube_frame_matches[0] );
				$post_object['media']['video'] = do_shortcode( $youtube_frame_matches[0] );
			}
		}

		$post_object['media']['blockquote'] = false;
		if ( $format == 'quote' ) {
			preg_match( '/\<blockquote(.|\s)*?\>(.|\s)+?\<\/blockquote\>/', $_post->post_content, $blockquotes_matches );
			if ( is_array( $blockquotes_matches ) && $blockquotes_matches ) {
				$blockquote = $blockquotes_matches[0];
				$post_object['media']['blockquote'] = wp_kses( str_replace( '\<a.*?\>', '', $blockquote ), 'default' );
			}
		}

		/*
		* Gallery post format
		*/

		$post_object['media']['gallery'] = false;
		if ( $format == 'gallery' ) {
            preg_match('/ids="([^"]*)"/', $_post->post_content, $galleries_matches);
			if ( is_array( $galleries_matches ) && $galleries_matches ) {
                if(isset($galleries_matches[1])) {
					$galleries_matches = explode(',', $galleries_matches[1]);
					$post_object['media']['gallery'] = '<div data-cursor-class="cursor-link" class="slider blog-slider" data-ohio-slider-simple="true">';
					if ( $_post->metro ) {
						foreach ( $galleries_matches as $attachment_ID ) {
							$post_object['media']['gallery'] .= '<div data-cursor-class="cursor-link" class="slider clb-slider-item blog-metro-image" data-ohio-bg-image="' . wp_get_attachment_image_url( $attachment_ID, $size ) . '">' . '</div>';
						}
					} else {
						foreach ($galleries_matches as $attachment_ID) {
							$post_object['media']['gallery'] .= '<img data-cursor-class="cursor-link" class="full-width" src="'.wp_get_attachment_image_url($attachment_ID, $size).'" alt="'.get_post_meta( $attachment_ID, '_wp_attachment_image_alt', true ).'">';
						}
					}
					$post_object['media']['gallery'] .= '</div>';
                }
			}
		}

		// $layout = OhioOptions::get( 'blog_item_layout_type', 'blog_grid_1', $_post->ID );

		// if ( $layout == 'blog_grid_1' || $layout == 'blog_grid_2') {
		// 	$boxed = OhioOptions::get( 'items_boxed_style', null, $_post->ID );
		// 	$post_object['boxed'] = ( $boxed == 'default' );
		// }

		$post_object['grid_style'] = OhioOptions::get( 'page_post_style_in_grid', 'default', $_post->ID );

		$post_object['animation_type'] = false;
		$post_object['animation_effect'] = false;
		switch ( $_context ) {
			case 'index':
			default:
				$post_object['animation_type'] = OhioOptions::get( 'page_animation_type' );
				if ( in_array( $post_object['animation_type'], array( 'sync', 'async' ) ) ) {
					$post_object['animation_effect'] = OhioOptions::get( 'page_animation_effect', 'fade-up' );
				}
				break;
		}

		// reading estimate
		$post_object['reading_estimate'] = OhioHelper::get_reading_estimate( $_raw_post->post_content ?? '' );

		$post_object['metro_style'] = OhioOptions::get( 'blog_metro_style', false );
		$post_object['hover_effect'] = 'type1';
		$post_object['alignment'] = 'left';
		$post_object['boxed'] = false;

		return $post_object;
	}

	/*
	* Project post
	*/
	static function parse_to_project_object( $_post ) {
		$project_object = array();
		// title
		$project_object['title'] = get_the_title( $_post->ID );
		if ( ! $project_object['title'] ) {
			$project_object['title'] = '[' . get_the_date( get_option( 'date_format' ), $_post->ID ) . ']';
		}
		$show_description = OhioOptions::get( 'project_show_description', true );
		// description
		if ( $show_description ) {
			$project_object['description'] = trim( get_field( 'project_description', $_post->ID ) );
			$project_object['short_description'] = '';
			if ( ! get_field( 'project_description', $_post->ID ) ) {
				$project_object['short_description'] = '';
			} else  {
				$_desc_first_space_arr = explode(' ', strip_tags( trim( get_field( 'project_description', $_post->ID ) ) ));
				$length = 24;
				if (OhioSettings::get('portfolio_descr_length', 'global')) {
					$length = OhioSettings::get('portfolio_descr_length', 'global');
				}
				for ($i = 0; $i < count($_desc_first_space_arr); $i++){
					$project_object['short_description'] .= ' ' . $_desc_first_space_arr[$i];
					if ($i > $length) break;
				}
				$project_object['short_description'] = trim($project_object['short_description']);
				$project_object['short_description'] .= '.';
	
			}
		} else {
			$project_object['description'] = '';
		}

		// Visible
		$project_object['category_visible'] = OhioOptions::get( 'portfolio_page_category_visibility', true );
		$project_object['more_visible'] = OhioOptions::get( 'portfolio_page_more_visibility', true );

		// Images
		$gallery = get_field( 'project_content', $_post->ID );
		$project_object['images'] = array();
		$project_object['images_full'] = array();
		if ( is_array( $gallery ) && count( $gallery ) > 0 ) {
			foreach ( $gallery as $key => $value ) {
				if ( $value && is_string( $value ) ) {
					$project_object['images'][$key] = wp_get_attachment_url( $value );
					$project_object['images_full'][$key] = wp_get_attachment_url( $value, 'full' );
				} elseif ( is_array( $value ) && isset( $value['sizes'] ) && isset( $value['sizes']['large'] ) ) {
					$project_object['images'][$key] = $value['sizes']['large'];
					if ( isset( $value['sizes']['ohio_full'] ) ) {
						$project_object['images_full'][$key] = $value['sizes']['ohio_full'];
					} else {
						$project_object['images_full'][$key] = $value['sizes']['large'];
					}
				}
			}
		} else {
			$project_object['images'] = array();
			$project_object['images_full'] = array();
		}

		// Featured image
        $thumbnailSize = OhioOptions::get_global( 'portfolio_images_size', 'medium_large' );
		$project_object['featured_image'] = get_the_post_thumbnail_url( $_post->ID, $thumbnailSize );

		// Get ohio_full size for full image
		if ( get_the_post_thumbnail_url( $_post->ID, 'ohio_full' ) ) {
			$project_object['featured_image_full'] = get_the_post_thumbnail_url( $_post->ID, 'ohio_full' );
		} else {
			$project_object['featured_image_full'] = get_the_post_thumbnail_url( $_post->ID, 'full' );
		}

		// If .gif then get full size
		if( $project_object['featured_image'] && pathinfo( $project_object['featured_image'], PATHINFO_EXTENSION ) == 'gif' ){
			$project_object['featured_image'] = get_the_post_thumbnail_url( $_post->ID, 'full' );
		}

		// If thumbnail empty
		if( ! $project_object['featured_image'] && is_array( $project_object['images'] ) && count( $project_object['images'] ) > 0 ){

			// If .gif then get full size
			if( $project_object['images'][0] && pathinfo( $project_object['images'][0], PATHINFO_EXTENSION ) == 'gif' ){
				$project_object['featured_image'] = $project_object['images_full'][0];
			} else {
			    if ($thumbnailSize) {
			        if($thumbnailSize == 'full') {
                        $project_object['featured_image'] = $gallery[0]['url'];
                    } else {
                        $project_object['featured_image'] = $gallery[0]['sizes'][$thumbnailSize];
                    }
                } else {
                    $project_object['featured_image'] = $project_object['images'][0];
                }

			}

			$project_object['featured_image_full'] = $project_object['images_full'][0];
		}

		if(isset($project_object['featured_image_full']) && !empty($project_object['featured_image_full'])) {
            array_unshift($project_object['images_full'], $project_object['featured_image_full']);
        }

        $video_url = OhioOptions::get_local( 'project_video', $_post->ID );

		if ( $video_url ) {
            $url = parse_url( $video_url );

            $project_object['video'] = array();

            // YouTube
            if ( isset( $url['host'] ) ) {
                if ( $url['host'] == 'www.youtube.com' || $url['host'] == 'youtube.com' || $url['host'] == 'youtu.be' ) {
                    if ( isset( $url['query'] ) ) {
                        parse_str( $url['query'], $query );
                    }

                    if ( isset( $query['v'] ) && $query['v'] ) {
                        $project_object['video']['link'] = 'https://www.youtube.com/embed/' . $query['v'];
                    }
                }

                // Vimeo
                if ( isset( $url['host'] ) && ( $url['host'] == 'www.vimeo.com' || $url['host'] == 'vimeo.com' ) ) {
                    if ( isset( $url['path'] ) && $url['path'] ) {
                        $project_object['video']['link'] = 'https://player.vimeo.com/video' . $url['path'];
                    }
                }
            }
		}

		$project_object['featured_as_gallery_item'] = OhioOptions::get( 'project_add_featured_to_gallery', true );

		$show_details = OhioOptions::get( 'project_show_details', true );
		$show_link = OhioOptions::get( 'project_show_link', true );
		$show_date = OhioOptions::get( 'project_show_date', true );

		// info
		if ( $show_date ) $project_object['date'] = get_field( 'project_date', $_post->ID );
		if ( $show_details ) {
			$project_object['task'] = get_field( 'project_task', $_post->ID );
			$project_object['strategy'] = get_field( 'project_strategy', $_post->ID );
			$project_object['design'] = get_field( 'project_design', $_post->ID );
			$project_object['client'] = get_field( 'project_client', $_post->ID );
		}
		if ( $show_link ) $project_object['link'] = get_field( 'project_link', $_post->ID );

        $tags = wp_get_post_terms($_post->ID, 'ohio_portfolio_tags', array('fields' => 'names'));
        $project_object['tags'] = '';
        if ( $tags && isset( $tags->error ) && !$tags->error) {
            $project_object['tags'] = $tags;
        }

		// custom info
		if ( $show_details ) {
			$project_object['custom_fields'] = array();
			$_custom_fields = get_field( 'project_custom_fields', $_post->ID );
			if ( is_array( $_custom_fields ) && $_custom_fields ) {
				foreach ( $_custom_fields as $field ) {
					$project_object['custom_fields'][] = array(
						'title' => $field['project_custom_field_title'],
						'value' => $field['project_custom_field_value']
					);
				}
			}
		}

		// show navigation
		$nav = OhioOptions::get( 'project_show_navigation', true, $_post->ID );
		if ( !is_bool($nav) ) {
			$nav = $nav === 'none' ? false : true;
		}
		$project_object['show_navigation'] = $nav;

		// custom content position
		$project_object['custom_content_position'] = OhioOptions::get( 'project_custom_content_position', 'bottom', $_post->ID );

		// breadcrumbs
		$project_object['hide_breadcrumbs'] = OhioOptions::get( 'page_show_breadcrumbs', true, $_post->ID );

		// sharing
		$project_object['show_sharing'] = OhioOptions::get( 'project_sharing_buttons_visibility', true );
		$project_object['sharing_links'] = OhioOptions::get_global( 'project_social_sharing_buttons' );
		$project_object['sharing_links_html'] = '';

		// Build share links
		if ( $project_object['show_sharing'] && $project_object['sharing_links'] && count( $project_object['sharing_links'] ) > 0 ) {

			ob_start();

			foreach( $project_object['sharing_links'] as $share_link ) {

				if ( $share_link == 'twitter' ) : ?>
					<a href="https://twitter.com/intent/tweet?text=<?php echo urlencode( $project_object['title'] ); ?>,+<?php echo rawurlencode( get_permalink() ); ?>" class="twitter hover-underline">
						<span class="icon fa fa-twitter"></span>
						<span class="social-text"><?php esc_html_e( 'Twitter', 'ohio' ); ?></span>
					</a>
				<?php endif;

				if ( $share_link == 'facebook' ) : ?>
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( get_permalink() ); ?>" class="facebook hover-underline">
						<span class="icon fa fa-facebook-f"></span>
						<span class="social-text"><?php esc_html_e( 'Facebook', 'ohio' ); ?></span>
					</a>
				<?php endif;

				if ( $share_link == 'linkedin' ) : ?>
					<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo rawurlencode( get_permalink() ); ?>&title=<?php echo urlencode( $project_object['title'] ); ?>&source=<?php echo urlencode( get_bloginfo( 'name' ) ); ?>" class="linkedin hover-underline">
						<span class="icon fa fa-linkedin"></span>
						<span class="social-text"><?php esc_html_e( 'LinkedIn', 'ohio' ); ?></span>
					</a>
				<?php endif;

				if ( $share_link == 'pinterest' ) : ?>
					<a href="http://pinterest.com/pin/create/button/?url=<?php echo rawurlencode( get_permalink() ); ?>&description=<?php echo urlencode( $project_object['title'] ); ?>" class="pinterest hover-underline">
						<span class="icon fa fa-pinterest-p"></span>
						<span class="social-text"><?php esc_html_e( 'Pinterest', 'ohio' ); ?></span>
					</a>
				<?php endif;

				if ( $share_link == 'vk' ) : ?>
					<a href="http://vk.com/share.php?url=<?php echo rawurlencode( get_permalink() ); ?>" class="vk hover-underline">
						<span class="icon fa fa-vk"></span>
						<span class="social-text"><?php esc_html_e( 'Vkontakte', 'ohio' ); ?></span>
					</a>
				<?php endif;

			}

			$project_object['sharing_links_html'] = ob_get_clean();
		}

		// portfolio link
		$project_object['link_to_all'] = OhioOptions::get_global( 'portfolio_page', home_url( '/' ) );

		// custom info
		$project['custom_fields'] = array();
		$_custom_fields = get_field( 'project_custom_fields', $_post->ID );
		if ( is_array( $_custom_fields ) && $_custom_fields ) {
			foreach ( $_custom_fields as $field ) {
				$project['custom_fields'][] = array(
					'title' => $field['project_custom_field_title'],
					'value' => $field['project_custom_field_value']
				);
			}
		}

		// categories
		$show_categories = OhioOptions::get( 'project_show_categories', true );
		if ($show_categories) {
			$_categories = wp_get_post_terms( $_post->ID, 'ohio_portfolio_category' );
			$project_object['categories'] = $_categories;
			if ( $project_object['categories'] && is_array( $project_object['categories'] ) && count( $project_object['categories'] ) > 0 ) {
				$_project_categories = array();
				foreach ($project_object['categories'] as $category) {
					$_project_categories[] = '<span class="brand-color">' . $category->name . '</span>';
				}
				$project_object['categories'] = implode( ' ', $_project_categories );
			} else {
				$project_object['categories'] = '';
			}
			$project_object['categories_plain'] = $_categories;
			if ( $project_object['categories_plain'] && is_array( $project_object['categories_plain'] ) && count( $project_object['categories_plain'] ) > 0 ) {
				$_project_categories = array();
				foreach ($project_object['categories_plain'] as $category) {
					$_project_categories[] = $category->name;
				}
				$project_object['categories_plain'] = implode( ', ', $_project_categories );
			} else {
				$project_object['categories_plain'] = '';
			}
			$project_object['categories_group'] = $_categories;
			if ( $project_object['categories_group'] && is_array( $project_object['categories_group'] ) && count( $project_object['categories_group'] ) > 0 ) {
				$_project_categories = array();
				foreach ($project_object['categories_group'] as $category) {
					$_project_categories[] = 'ohio-filter-project-' . hash( 'md4', $category->slug, false );
				}
				$project_object['categories_group'] = implode( ' ', $_project_categories );
			} else {
				$project_object['categories_group'] = '';
			}
		}

		// next n prev
		$project_object['next'] = get_adjacent_post( false, '', false );
		if ( is_a( $project_object['next'], 'WP_Post' ) ) {
			$images = get_field( 'project_content', $project_object['next']->ID );
			$image = ( is_array( $images ) && count( $images ) > 0 ) ? $images[0] : false;
			if ( $image && is_string( $image ) ) {
				$image = wp_get_attachment_url( $image );
			} elseif ( is_array( $image ) && isset($image['sizes']['medium_large']) ) {
				$image = $image['sizes']['medium_large'];
			} elseif ( is_array( $image ) && isset($image['sizes']['thumbnail'])) {
				$image = $image['sizes']['thumbnail'];
			}
			if (!$image) {
				$image = get_the_post_thumbnail_url( $project_object['next']->ID, $thumbnailSize );
			}
			$project_object['next'] = array(
				'title' => $project_object['next']->post_title,
				'url' => get_permalink( $project_object['next']->ID ),
				'image' => $image
			);
		} else {
			$project_object['next'] = false;
		}
		$project_object['prev'] = get_adjacent_post( false, '', true );
		if ( is_a( $project_object['prev'], 'WP_Post' ) ) {
			$images = get_field( 'project_content', $project_object['prev']->ID );
			$image = ( is_array( $images ) && count( $images ) > 0 ) ? $images[0] : false;
			if ( $image && is_string( $image ) ) {
				$image = wp_get_attachment_url( $image );
			} elseif ( is_array( $image ) && isset($image['sizes']['medium_large']) ) {
				$image = $image['sizes']['medium_large'];
			} elseif ( is_array( $image ) && isset($image['sizes']['thumbnail'])) {
				$image = $image['sizes']['thumbnail'];
			}
			if (!$image) {
				$image = get_the_post_thumbnail_url( $project_object['prev']->ID, $thumbnailSize );
			}
			$project_object['prev'] = array(
				'title' => $project_object['prev']->post_title,
				'url' => get_permalink( $project_object['prev']->ID ),
				'image' => $image
			);
		} else {
			$project_object['prev'] = false;
		}

		if (!$project_object['next']) {
			$project_object['next'] = $project_object['prev'];
		}

		// overlay color
		$project_object['overlay'] = get_field( 'project_overlay_color', $_post->ID );
		if ( ! $project_object['overlay'] ) {
			$project_object['overlay'] = false;
		}

		// grid
		$project_object['grid_style'] = get_field( 'project_style_in_grid', $_post->ID );

		// animation
		$project['with_animation'] = get_field( 'global_portfolio_with_animation', 'option' );
		if ( $project['with_animation'] == NULL ) {
			$project['with_animation'] = true;
		}

		// project lightbox
		$project_object['in_popup'] = false;
		$project_object['popup_id'] = uniqid( 'ohio-lightbox-' );
		switch ( get_field( 'project_open_type', $_post->ID ) ) {
			case 'external_target':
				$project_object['url'] = $project_object['link'];
				$project_object['external'] = false;
				break;
			case 'external_blank':
				$project_object['url'] = $project_object['link'];
				$project_object['external'] = true;
				break;
			case 'project':
			default:
				$project_object['url'] = get_post_permalink( $_post->ID );
				$project_object['external'] = false;
				break;
		}
		return $project_object;
	}
}