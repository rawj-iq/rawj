<?php
/*
	Typography custom style

	Table of contents: (you can use search)
	# 1. Variables
	# 2. Text typography
	# 2.1. Text responsive typography
	# 2.2. Post text typography
	# 3. Title typography
	# 3.1. Title responsive sizes
	# 3.2. Post title typography
	# 4. Subtitle typography
	# 4.1. Subtitle responsive typography
	# 5. View
	# 6. Subscribe popup
	# 6.1 Heading
	# 6.2 Description
	# 6.3 Background
*/


# 1. Variables

$title_typo = false;
$title_responsive_sizes = false;
$subtitle_typo = false;
$subtitle_responsive_sizes = false;
$text_typo = false;
$text_responsive_sizes = false;
$post_title_typo = false;
$post_text_typo = false;
$subcribe_popup_title_typo = false;
$subcribe_popup_description_typo = false;
$subscribe_background_color = false;



# 2. Text typography

OhioOptions::get( 'page_typography_settings' ); // trigger select chain
$typography_settings_select_type = OhioOptions::get_last_select_type();

$text_typo = OhioOptions::get_global( 'page_text_typo' );


# 2.1. Text responsive typography

$_text_font_sizes_raw = OhioOptions::get_global( 'page_paragraphs_font_sizes' );
$text_responsive_sizes = OhioHelper::parse_responsive_font_sizes( $_text_font_sizes_raw );


# 2.2. Post text typography

if ( OhioSettings::page_is( 'single' ) ) {
	if ( in_array( $typography_settings_select_type, array( 'local', 'post' ) ) ) {
		$post_text_typo = OhioOptions::get_by_type( 'page_text_typo', $typography_settings_select_type );
	}
}


# 3. Title typography

$title_typo = OhioOptions::get_global( 'page_headings_typo' );

/*
// todo: wtf?
if ( OhioSettings::page_is( 'single' ) ) {
	if ( OhioOptions::get_global( 'page_typography_settings' ) == 'custom' ) {
		$title_typo = OhioOptions::get_global( 'post_header_title_typo' );
	} else {
		$title_typo = OhioOptions::get_global( 'page_headings_typo' );
	}
}
*/


# 3.1. Title responsive sizes

$_title_font_sizes_raw = OhioOptions::get_global( 'page_titles_font_sizes' );
$title_responsive_sizes = OhioHelper::parse_responsive_font_sizes( $_title_font_sizes_raw );


# 3.2. Post title typography

if ( OhioSettings::page_is( 'single' ) ) {
	if ( in_array( $typography_settings_select_type, array( 'local', 'post' ) )  ) {
		$post_title_typo = OhioOptions::get_by_type( 'page_header_title_typo', $typography_settings_select_type );
	}
}


# 4. Subtitle typography

$subtitle_typo = OhioOptions::get_global( 'page_subtitles_typo' );


# 4.1. Subtitle responsive typography

$_subtitle_font_sizes_raw = OhioOptions::get_global( 'page_subtitles_font_sizes' );
$subtitle_responsive_sizes = OhioHelper::parse_responsive_font_sizes( $_subtitle_font_sizes_raw );

# 5. View

// Global settings
/* Texts */

$_selector = ['body'];
$_responsive_selector = $_selector;
$_css = OhioHelper::parse_acf_typo_to_css( $text_typo );
OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );

$_selector = [
	'input',
	'select',
	'textarea',
	'.accordion-box .buttons h5.title',
	'.woocommerce div.product accordion-box.outline h5'
];
$_responsive_selector = array_merge( $_responsive_selector, $_selector );
$_css = OhioHelper::parse_acf_typo_to_css( $title_typo, ['rule' => 'exclude', 'fields' => ['font-size', 'color']] );
OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );


if ( $text_responsive_sizes ) {
	$_responsive_selectors = implode( ',', $_responsive_selector );
	$_responsive_css = OhioHelper::get_all_responsive_font_css( $text_responsive_sizes, $_responsive_selectors );
	OhioBuffer::append_to_dynamic_css_buffer( $_responsive_css );
}


/* Headings */
$_selector = [
	'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
	'.box-count',
	'.mini_cart_item-desc .font-titles',
	'.woo-c_product .font-titles',
	'.tabNav_link.active',
	'.icon-box-headline',
	'.fullscreen-nav .menu-link',
	'.postNav_item_inner_heading'
];
$_responsive_selector = $_selector;
$_css = OhioHelper::parse_acf_typo_to_css( $title_typo );
OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );

$_selector = [
	'.countdown-box .box-time .box-count',
	'.chart-box-pie-content'
];
$_responsive_selector = array_merge( $_responsive_selector, $_selector );
$_css = OhioHelper::parse_acf_typo_to_css( $title_typo, ['rule' => 'exclude', 'fields' => ['line-height']] );
OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );

$_selector = [
	'.countdown-box .box-time .box-count',
	'.chart-box-pie-content'
];
$_responsive_selector = array_merge( $_responsive_selector, $_selector );
$_css = OhioHelper::parse_acf_typo_to_css( $title_typo, ['rule' => 'exclude', 'fields' => ['line-height']] );
OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );


$_selector = [
	'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
	'.box-count',
	'.font-titles',
	'.tabNav_link.active',
	'.icon-box-headline',
	'.fullscreen-nav .menu-link',
	'.postNav_item_inner_heading',
	'.btn',
	'.button',
	'a.button',
	'.main-nav .nav-item',
	'.heading .title',
	'.socialbar.inline a',
	'.vc_row .vc-bg-side-text',
	'.counter-box-count'
];
$_css = OhioHelper::parse_acf_typo_to_css( $title_typo, ['rule' => 'include', 'fields' => ['font-family']] );
OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );

$_selector = [
	'.portfolio-item h4',
	'.portfolio-item h4.title',
	'.portfolio-item h4 a',
	'.portfolio-item-2 h4',
	'.portfolio-item-2 h4.title',
	'.portfolio-item-2 h4 a',
	'.woocommerce ul.products li.product a'
];
$_css = OhioHelper::parse_acf_typo_to_css( $title_typo, array( 'rule' => 'exclude', 'fields' => array( 'font-size', 'line-height' ) ) );
if ( $_css ) {
	$_css .= 'font-size:inherit;';
	$_css .= 'line-height:inherit;';
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );
}

$_selector = '.blog-item h3.title';
$_css = OhioHelper::parse_acf_typo_to_css( $title_typo, ['rule' => 'exclude', 'fields' => ['font-size', 'line-height']] );
if ( $_css ) {
	$_css .= 'line-height:initial;';
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );

	OhioBuffer::pack_dynamic_css_to_buffer( '.blog-item h3.title a', 'font-size:initial;' );
}

$_selector = '.portfolio-item-2 h4';
$_css = OhioHelper::parse_acf_typo_to_css( $title_typo, ['rule' => 'exclude', 'fields' => ['font-size', 'color']] );
OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );


if ( $title_responsive_sizes ) {
	$_responsive_selectors = implode( ',', $_responsive_selector );
	$_responsive_css = OhioHelper::get_all_responsive_font_css( $title_responsive_sizes, $_responsive_selectors );
	OhioBuffer::append_to_dynamic_css_buffer( $_responsive_css );
}


/* Subheadings */
$_selector = [
	'p.subtitle',
	'.subtitle-font',
	'.heading .subtitle',
	'a.category'
];
$_responsive_selector = $_selector;
$_css = OhioHelper::parse_acf_typo_to_css( $subtitle_typo );
OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );


$_selector = [
	'span.category > a',
	'div.category > a'
];
$_css = OhioHelper::parse_acf_typo_to_css( $subtitle_typo, ['rule' => 'exclude', 'fields' => ['font-size', 'line-height']] );
OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );


$_selector = [
	'.portfolio-item .subtitle-font',
	'.woocommerce ul.products li.product .subtitle-font.category',
	'.woocommerce ul.products li.product .subtitle-font.category > a'
];
$_css = OhioHelper::parse_acf_typo_to_css( $subtitle_typo, array( 'rule' => 'exclude', 'fields' => array( 'font-size', 'line-height' ) ) );
if ( $_css ) {
	$_css .= 'font-size:inherit;';
	$_css .= 'line-height:inherit;';
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );
}


$_selector = [
	'.contact-form.classic input::-webkit-input-placeholder',
	'.contact-form.classic textarea::-webkit-input-placeholder',
	'input.classic::-webkit-input-placeholder',
	'input.classic::-moz-placeholder'
];
$_responsive_selector = array_merge( $_responsive_selector, $_selector );
$_css = OhioHelper::parse_acf_typo_to_css( $subtitle_typo );
OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );

	// Moz placehoder
$_selector = [
	'.contact-form.classic input::-moz-placeholder',
	'.contact-form.classic textarea::-moz-placeholder'
];
$_css = OhioHelper::parse_acf_typo_to_css( $subtitle_typo );
OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );

	// MS placeholder
$_selector = [
	'input.classic:-ms-input-placeholder',
	'.contact-form.classic input:-ms-input-placeholder',
	'.contact-form.classic textarea:-ms-input-placeholder'
];
$_css = OhioHelper::parse_acf_typo_to_css( $subtitle_typo );
OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );


if ( $subtitle_responsive_sizes ) {
	$_responsive_selectors = implode( ',', $_responsive_selector );
	$_responsive_css = OhioHelper::get_all_responsive_font_css( $subtitle_responsive_sizes, $_responsive_selectors );
	OhioBuffer::append_to_dynamic_css_buffer( $_responsive_css );
}


// Post text
if ( OhioHelper::parse_acf_typo_to_css( $post_text_typo ) ) {
	$_selector = '.clb-page-headline .subtitle';
	$_css = OhioHelper::parse_acf_typo_to_css( $post_text_typo );
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );
}

// Post headings
if ( OhioHelper::parse_acf_typo_to_css( $post_title_typo ) ) {
	$_selector = [
		'#main .post .entry-content h1.page-title',
		'#main .post .entry-content h2.page-title',
		'#main .post .entry-content h3.page-title',
		'#main .post .entry-content h4.page-title',
		'#main .post .entry-content h5.page-title'
	];
	$_css = OhioHelper::parse_acf_typo_to_css( $post_title_typo );
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );
}


$subcribe_popup_title_typo = json_decode( OhioOptions::get_global( 'text_subcribe_popup_typo' ) );

if ( $subcribe_popup_title_typo ) {
	$subcribe_popup_title_typo_css = OhioHelper::parse_acf_typo_to_css( $subcribe_popup_title_typo );

	if ( $subcribe_popup_title_typo_css ) {
		$_selector = [
			'.clb-popup .clb-subscribe-content-headline',
			'.clb-popup .clb-subscribe .btn'
		];
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $subcribe_popup_title_typo_css );
	}
}

$subcribe_popup_description_typo = json_decode( OhioOptions::get_global( 'details_text_subcribe_popup_typo' ) );
if ( $subcribe_popup_description_typo ) {
	$subcribe_popup_description_typo_css = OhioHelper::parse_acf_typo_to_css( $subcribe_popup_description_typo );

	if ( $subcribe_popup_description_typo_css ) {
		$_selector = '.clb-popup .clb-subscribe .subscribe-content-subheader';
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $subcribe_popup_description_typo_css );
	}
}

$subscribe_background_color = OhioOptions::get_global( 'subcribe_popup_background_color' );
if ( $subscribe_background_color ) {
	$subscribe_background_color_css = 'background-color: ' . $subscribe_background_color;

	if ( $subscribe_background_color_css ) {
		$_selector = '.subscribe-popup .subscribe';
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $subscribe_background_color_css );
	}
}


// posts title typo
if( OhioOptions::get_global( 'posts_title_typo' ) ) {
    $posts_title_typo_css = OhioHelper::parse_acf_typo_to_css( OhioOptions::get_global( 'posts_title_typo' ) );

	if ( $posts_title_typo_css ) {
		$_selector = '.blog-grid-content .blog-grid-headline a';
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $posts_title_typo_css );
    }
}

// posts content typo
if( OhioOptions::get_global( 'posts_content_typo' ) ) {
    $posts_content_typo_css = OhioHelper::parse_acf_typo_to_css( OhioOptions::get_global( 'posts_content_typo' ) );
    if ( $posts_content_typo_css ) {
		$_selector = '.blog-grid-content p';
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $posts_content_typo_css );
    }
}

// posts read more button typo
if( OhioOptions::get_global( 'posts_readmore_typo' ) ) {
    $posts_readmore_typo_css = OhioHelper::parse_acf_typo_to_css( OhioOptions::get_global( 'posts_readmore_typo' ) );

	if ( $posts_readmore_typo_css ) {
		$_selector = '.blog-grid-content .btn-link';
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $posts_readmore_typo_css );
    }
}

// posts category typo
if( OhioOptions::get_global( 'posts_category_typo' ) ) {
    $posts_category_typo_css = OhioHelper::parse_acf_typo_to_css( OhioOptions::get_global( 'posts_category_typo' ) );

	if ( $posts_category_typo_css ) {
		$_selector = '.blog-grid .post-details a.category';
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $posts_category_typo_css );
    }
}

// posts author typo
if( OhioOptions::get_global( 'posts_author_typo' ) ) {
    $posts_author_typo_css = OhioHelper::parse_acf_typo_to_css( OhioOptions::get_global( 'posts_author_typo' ) );

	if ( $posts_author_typo_css ) {
		$_selector = '.blog-grid .author';
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $posts_author_typo_css );
    }
}

// posts date typo
if( OhioOptions::get_global( 'posts_date_typo' ) ) {
    $posts_date_typo_css = OhioHelper::parse_acf_typo_to_css( OhioOptions::get_global( 'posts_date_typo' ) );

	if ( $posts_date_typo_css ) {
		$_selector = '.blog-grid .date';
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $posts_date_typo_css );
    }
}

// reading time typo
if ( $reading_time_typo = OhioOptions::get_global( 'posts_reading_time_typo' ) ) {
	$reading_time_css = OhioHelper::parse_acf_typo_to_css( $reading_time_typo );
	if ( $reading_time_css ) {
		$_selector = '.blog-grid-content .post-meta-estimate';
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $reading_time_css );
	}
}

if ( $social_networks_typo = OhioOptions::get( 'page_social_networks_typo' ) ) {
	$social_networks_css = OhioHelper::parse_acf_typo_to_css( $social_networks_typo );
	if ( $social_networks_css ) {
		$_selector = '.clb-social';
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $social_networks_css );	
	}
}

if ( $project_title_typo = OhioOptions::get( 'project_title_typography' ) ) {
	$project_title_css = OhioHelper::parse_acf_typo_to_css( $project_title_typo );
	if ( $project_title_css ) {
		$_selector = '.project-page .project-page-content .project-title .headline';
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $project_title_css );
	}
}

if ( $project_category_typo = OhioOptions::get( 'project_category_typography' ) ) {
	$project_category_css = OhioHelper::parse_acf_typo_to_css( $project_category_typo );
	if ( $project_category_css ) {
		$_selector = '.project-page .category-holder .category';
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $project_category_css );
	}
}

if ( $project_date_typo = OhioOptions::get( 'project_date_typography' ) ) {
	$project_date_css = OhioHelper::parse_acf_typo_to_css( $project_date_typo );
	if ( $project_date_css ) {
		$_selector = '.project-page span.date';
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $project_date_css );
	}
}

if ( $project_details_typo = OhioOptions::get( 'project_details_typography' ) ) {
	$project_details_css = OhioHelper::parse_acf_typo_to_css( $project_details_typo );
	if ( $project_details_css ) {
		$_selector = [
			'.project-page .project-page-content .project-meta li',
			'.project-page .project-page-content .project-meta .project-meta-title'
		];
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $project_details_css );
	}
}

if ( $project_link_typo = OhioOptions::get( 'project_link_typography' ) ) {
	$project_link_css = OhioHelper::parse_acf_typo_to_css( $project_link_typo );
	if ( $project_link_css ) {
		$_selector = '.single .project-page .project-page-content .btn-link';
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $project_link_css );
	}
}

if ( $project_description_typo = OhioOptions::get( 'project_description_typography' ) ) {
	$project_description_css = OhioHelper::parse_acf_typo_to_css( $project_description_typo );
	if ( $project_description_css ) {
		$_selector = '.project-page-content .project-description';
		OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $project_description_css );
	}
}