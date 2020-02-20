<?php
/*
	Page custom style
	
	Table of contents: (you can use search)
	# 1. Variables
	# 2. Background type
	# 3. Background color
	# 4. Background image
	# 5. Links & border color
	# 6. Full width container margins
	# 7. View
*/


# 1. Variables

$links_color = false;
$borders_color = false;

$background_color_css = '';
$background_image_css = '';
$links_css = '';
$borders_css = '';
$full_width_margins_css = '';
$content_wrapper_width_css = '';

# 2. Background type
$background_type = OhioOptions::get( 'page_background_type' );
$background_select_type = OhioOptions::get_last_select_type();

if ( !$background_type ) {
	$background_type = 'color';
}

# 3. Background color
$background_color = OhioOptions::get_by_type( 'page_background_color', $background_select_type );

if ( $background_color ) {
	$background_color_css = 'background-color:' . $background_color . ';';
}

# 4. Background image
if ( $background_type == 'image' ) {
	$background_image_css = OhioHelper::get_background_image_css_by_type( 'page', $background_select_type );
}


# 5. Links color
$links_color = OhioOptions::get_global( 'page_links_color' );
if ( $links_color ) {
	$links_css = 'color:' . $links_color . ';';
}

$borders_color = OhioOptions::get_global( 'page_borders_color' );
if ( $borders_color ) {
	$borders_css = 'border-color:' . $borders_color . ';';
}


# 6. Full width container margins
$content_wrapper_width = OhioOptions::get( 'page_content_wrapper_width', null, false, true );

if ( $content_wrapper_width ) {
	$content_wrapper_width_css = 'max-width:' . $content_wrapper_width;
}


$full_width_margins = OhioOptions::get( 'page_full_width_margins_size', null, false, true );

if ( $full_width_margins ) {
	$full_width_margins_css = 'padding-left:' . $full_width_margins . '; padding-right:' . $full_width_margins . ';';
}


# 7. View

if ( $background_color_css || $background_image_css ) {
	$_selector = [
		'body .site-content',
		'.woo_c-product.single-product .woo_c-product-details'
	];
	$_css = $background_color_css . $background_image_css;
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );
}

if ( $links_css ) {
	$_selector = [
		'a',
		'.woo_c-product .sticky-product-desc .title .price:after'
	];
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $links_css );
}

if ( $links_css ) {
	$_selector = '.woo_c-product .sticky-product-desc .title .price:after';
	$_css = 'background-color:' . $links_color . ';';
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );
}

if ( $borders_css ) {
	$_selector = [
		'.site-header',
		'.site-footer .page-container + .site-info .wrap',
		'.woo_c-product .woo_c-product-details-variations',
		'.widget_shopping_cart_content .total',
		'.portfolio-project .project-meta li',
		'.widget_shopping_cart_content .mini_cart_item'
	];
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $borders_css );
}

if ( $full_width_margins_css ) {
	$_selector = '.page-container.full';
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $full_width_margins_css );
}

if ( $content_wrapper_width_css ) {
	$_selector = '.page-container';
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $content_wrapper_width_css );
}

$posts_card_background = OhioOptions::get( 'posts_card_background_color', null, false, true );
if ( $posts_card_background ) {

	$_selector = [
		'.blog-grid-type-4:not(.without-media)',
		'.blog-grid.boxed:not(.blog-grid-type-2) .blog-grid-content'
	];

	$_css = 'background-color:' . $posts_card_background . ';';
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );
}

$project_slider_overlay = OhioOptions::get( 'project_color_overlay', null, false, true );

if ( $project_slider_overlay && $project_slider_overlay != 1 ) {
	$_selector = [
		'.project-page.layout-type5 .project-image-overlay',
		'.project-page.layout-type6 .project-image-overlay',
		'.project-page.layout-type8 .project-image-overlay'
	];
	$_css = 'background-color:' . $project_slider_overlay . ';';
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );
}