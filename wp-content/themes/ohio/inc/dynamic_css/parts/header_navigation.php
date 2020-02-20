<?php
/*
	Header navigation custom style
	
	Table of contents: (you can use search)
	# 1. Variables
	# 2. Background color
	# 3. Header menu typography
	# 4. Border state
	# 4.1. Border type
	# 4.2. Border color
	# 5. Header height
	# 6. Site name typography
	# 7. Overlay background color and image
	# 8. Custom header button color
	# 9. View
*/


# 1. Variables

$background_color 	= false;
$fixed_background_color = false;
$mobile_background_color = false;
$header_typo 		   = false;
$fixed_typo 		   = false;
$mobile_typo 		   = false;
$mobile_color 		   = false;
$border_type 		   = false;
$border_color 		   = false;
$menu_color 		   = false;
$back_link 				= false;
$fixed_border_type   = false;
$fixed_border_color  = false;
$header_height = false;
$fixed_height        = false;
$sitename_typo = false;
$background_color_css = '';
$background_image_css = '';
$fixed_background_color_css = '';
$fixed_background_image_css = '';

$mobile_header_menu_color_css = '';
$fixed_search_color_css = '';

$mobile_background_color_css = '';
$mobile_background_image_css = '';
$overlay_background_color_css = '';
$overlay_background_image_css = '';
$background_color_css_border = '';
$header_typo_css 		   = '';
$fixed_typo_css 		   = '';
$mobile_typo_css 		   = '';
$mobile_color_css 		= '';
$border_css 			   = '';
$fixed_border_css 	   = '';
$header_height_css = '';
$fixed_height_css 		= '';
$sitename_typo_css = '';
$custom_button_color_css = '';

OhioOptions::get( 'page_header_menu_style_settings' ); // trigger selection chain
$style_settings_type = OhioOptions::get_last_select_type();

# 2. Background color and image
$background_type = OhioOptions::get_by_type( 'page_header_menu_background_type', $style_settings_type );
if ( !$background_type ) $background_type = 'color';

$background_color = OhioOptions::get_by_type( 'page_header_menu_background_color', $style_settings_type );

if ( $background_color ) {
	$background_color_css = 'background-color:' . $background_color . ';';
}
if ( $background_type == 'image' ) {
	$background_image_css = OhioHelper::get_background_image_css_by_type( 'page_header_menu', $style_settings_type );
}

# --- Fixed header
$fixed_background_type = OhioOptions::get_by_type( 'page_header_fixed_background_type', 'global' );
if ( !$fixed_background_type ) $fixed_background_type = 'color';

$fixed_background_color = OhioOptions::get_by_type( 'page_header_fixed_background_color', 'global' );

if ( $fixed_background_color ) {
	$fixed_background_color_css = 'background-color:' . $fixed_background_color . ';';
}
if ( $fixed_background_type == 'image' ) {
	$fixed_background_image_css = OhioHelper::get_background_image_css_by_type( 'page_header_fixed', 'global' );
}

# --- Mobile header
$mobile_background_type = OhioOptions::get_by_type( 'page_mobile_header_menu_background_type', 'global' );
if ( !$mobile_background_type ) $mobile_background_type = 'color';

$mobile_background_color = OhioOptions::get_by_type( 'page_mobile_header_menu_background_color', 'global' );

if ( $mobile_background_color ) {
	$mobile_background_color_css = 'background-color:' . $mobile_background_color . ';';
}

if ( $mobile_background_type == 'image' ) {
	$mobile_background_image_css = OhioHelper::get_background_image_css_by_type( 'page_mobile_header_menu', 'global' );
}


$mobile_header_menu_color = OhioOptions::get_global( 'page_mobile_header_menu_color', 'global' );
if ( $mobile_header_menu_color && $mobile_header_menu_color != 'global' ) {
	$mobile_header_menu_color_css .= 'color:' . $mobile_header_menu_color . ';';
}

$fixed_search_color = OhioOptions::get( 'page_header_search_color', null, null, true );
if ( $fixed_search_color ) {
	$fixed_search_color_css .= 'color:' . $fixed_search_color . ';';
}


# --- Mobile fixed header
$mobile_background_color = OhioOptions::get_global( 'page_mobile_header_menu_background' );
if ( $mobile_background_color ) {
	$mobile_background_color_css = 'background-color:' . $mobile_background_color . ';';
}


# 3. Header menu typography

$header_typo = OhioOptions::get_by_type( 'page_header_menu_text_typo', $style_settings_type );
$header_typo_css = OhioHelper::parse_acf_typo_to_css( $header_typo );

$fixed_typo = OhioOptions::get_global( 'page_header_fixed_text_typo' );
$fixed_typo_css = OhioHelper::parse_acf_typo_to_css( $fixed_typo );

$mobile_typo = OhioOptions::get_global( 'mobile_header_menu_typo' );
$mobile_typo_css = OhioHelper::parse_acf_typo_to_css( $mobile_typo );

if ( $mobile_color ) {
	$mobile_color_css = 'color:' . $mobile_color . ';';
}

# 4. Border state

$border_visibility = OhioOptions::get_by_type( 'page_header_menu_border_visibility', $style_settings_type, true );

$fixed_border_visibility = OhioOptions::get_global( 'page_fixed_header_menu_border_visibility', true );

if ( !$border_visibility ) {
	$border_css .= 'border:none;';
}
if ( !$fixed_border_visibility ) {
	$fixed_border_css .= 'border:none;';
}

# 4.1. Border type

if ( $border_visibility ) {
	$border_type = OhioOptions::get_by_type( 'page_header_menu_border_type', $style_settings_type, 'solid' );

	if ( $border_type ) {
		$border_css .= 'border-bottom-style:' . $border_type . ';';
	}
}

if ( $fixed_border_visibility ) {
	$fixed_border_type = OhioOptions::get_global( 'page_fixed_header_menu_border_type', 'solid' );

	if ( $fixed_border_type ) {
		$fixed_border_css .= 'border-bottom-style:' . $fixed_border_type . ';';
	}
}

# 4.2. Border color

if ( $border_visibility ) {
	$border_color = OhioOptions::get_by_type( 'page_header_menu_border_color', $style_settings_type );

	if ( $border_color ) {
		$border_css .= 'border-bottom-color:' . $border_color . ' !important;';
	}
}

if ( $fixed_border_visibility ) {
	$fixed_border_color = OhioOptions::get_global( 'page_fixed_header_menu_border_color' );

	if ( $fixed_border_color ) {
		$fixed_border_css .= 'border-bottom-color:' . $fixed_border_color . ';';
	}
}

# 5. Header height

$header_height = OhioOptions::get_by_type( 'page_header_menu_height', $style_settings_type );

if ( $header_height ) {
	$header_height_css .= 'height:${height}px;';
	$header_height_css = OhioHelper::parse_responsive_height_to_css( $header_height, $header_height_css );
}

$fixed_height = OhioOptions::get_global( 'page_header_fixed_height' );

if ( $fixed_height ) {
	$fixed_height_css .= 'height:${height}px;';
	$fixed_height_css = OhioHelper::parse_responsive_height_to_css( $fixed_height, $fixed_height_css );
}

# 6. Site name typography

$logo_style = OhioOptions::get( 'page_header_logo_style' );
$logo_style_select_type = OhioOptions::get_last_select_type();

if ( $logo_style == 'sitename' ) {
	$sitename_typo = OhioOptions::get_by_type( 'page_header_sitename_typo', $logo_style_select_type );
	$sitename_typo_css = OhioHelper::parse_acf_typo_to_css( $sitename_typo );
}

# 7. Overlay background color and image

$overlay_background_type = OhioOptions::get_global( 'page_header_overlay_menu_background_type' );
if ( !$overlay_background_type ) $overlay_background_type = 'color';

$overlay_background_color = OhioOptions::get_global( 'page_header_overlay_menu_background_color' );

if ( $overlay_background_color ) {
	$overlay_background_color_css = 'background-color:' . $overlay_background_color . ';';
}
if ( $overlay_background_type == 'image' ) {
	$overlay_background_image_css = OhioHelper::get_background_image_css_by_type( 'page_header_overlay_menu', 'global' );
}

# 8. View

if ( $header_typo_css ) {
	$_selector = [
		'.site-header:not(.header-fixed):not(.mobile-header) .menu > li > a',
		'.site-header:not(.header-fixed) .menu-optional .cart-total a',
		'.site-header:not(.header-fixed) .menu-optional > li > a',
		'.site-header:not(.header-fixed) .select-styled',
		'.site-header:not(.header-fixed) .menu-optional .btn-round-light:not(.clb-close) .ion',
		'.site-header:not(.header-fixed) .clb-hamburger.btn-round-light .ion',
		'.site-header:not(.header-fixed) .clb-hamburger .hamburger',
		'.site-header .menu-blank'
	];
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $header_typo_css );
}

$custom_button_background = OhioOptions::get_global('custom_button_for_header_background');
if ($custom_button_background) {
	$custom_button_color_css .= 'background-color:' . $custom_button_background . ';';
	$custom_button_color_css .= 'border-color:' . $custom_button_background . ';';
}

$custom_button_color = OhioOptions::get_global('custom_button_for_header_color');
if ($custom_button_color) {
	$custom_button_color_css .= 'color:' . $custom_button_color . ';';
}

# 9. Back link position

$previous_btn = OhioOptions::get_global( 'page_header_previous_button', true );
$subheader = OhioOptions::get_global( 'page_subheader_visibility', true );

if ( $previous_btn && $header_height) {
	function parseHeightArrays($height) {
		$height_array = explode( '-', $height );
		return $height_array[0];
	}
	
	$subheader_height = '';

	if ($subheader) {
		$subheader_height = OhioOptions::get_by_type( 'page_subheader_height', $style_select_type );
		$subheader_height = (int) parseHeightArrays($subheader_height);
	}
	if ($header_height) {
		$header_height = (int) parseHeightArrays($header_height);
	}
	
	$back_link = $header_height + $subheader_height + 20;
	$back_link_css .= 'top:'. $back_link .'px;';
}

if ( $background_color_css || $background_image_css ) {
	$_selector = '#masthead.site-header:not(.header-fixed)';
	$_css = $background_color_css . $background_image_css;
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );
}

if ( $fixed_typo_css ) {
	$_selector =[
		'.header-fixed .menu > li > a',
		'.header-fixed .menu-optional .cart-total a',
		'.header-fixed .menu-optional > li > a',
		'.clb-hamburger .hamburger'
	];
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $fixed_typo_css );
}

if ( $mobile_color_css ) {
	$_selector = 'header#masthead';
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $mobile_color_css, 'mobile' );
}

if ( $fixed_background_color_css || $fixed_background_image_css ) {
	$_selector = '#masthead.site-header.header-fixed';
	$_css = $fixed_background_color_css . $fixed_background_image_css;
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );
}

if ( $mobile_header_menu_color_css ) {
	$_selector = [
		'.site-header:not(.header-fixed) .menu > li > a',
		'.site-header:not(.header-fixed) .menu-optional .cart-total a',
		'.site-header:not(.header-fixed) .menu-optional .cart .ion',
		'.site-header:not(.header-fixed) .menu-optional > li > a',
		'.site-header:not(.header-fixed) .select-styled',
		'.site-header:not(.header-fixed) .clb-hamburger .clb-hamburger-holder ._shape'
	];
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $mobile_header_menu_color_css, 'mobile' );
}

if ( $fixed_search_color_css ) {
	$_selector = '.search-global.fixed .ion';
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $fixed_search_color_css );
}

if ( $mobile_typo_css ) {
	$_selector = [
		'.site-header .menu > li > a.menu-link',
		'.main-nav .nav-item a',
		'.main-nav .copyright',
		'.main-nav .copyright a',
		'.mbl-overlay .close-bar .ion'
	];
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $mobile_typo_css, 'mobile' );
}

if ( $mobile_background_color_css || $mobile_background_image_css ) {
	$_selector = [
		'.main-nav .mbl-overlay-container'
	];
	$_css = $mobile_background_color_css . $mobile_background_image_css;
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css, 'mobile' );
}

if ( $overlay_background_color_css || $overlay_background_image_css ) {
	$_selector = '.clb-popup.clb-hamburger-nav';
	$_css = $overlay_background_color_css . $overlay_background_image_css;
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $_css );
}

if ( $border_css ) {
	$_selector = '.site-header';
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $border_css );
}

if ( $fixed_border_css ) {
	$_selector = '.site-header.header-fixed';
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $fixed_border_css );
}

if ( $header_height_css ) {
	$header_height_classes = '.site-header .header-wrap, .header-cap';

	if ( $header_height_css['desktop'] ) {
		$_style_block = $header_height_classes . '{' . $header_height_css['desktop'] . '}';
		OhioBuffer::append_to_dynamic_css_buffer( $_style_block, 'desktop' );
	}
	if ( $header_height_css['tablet'] ) {
		$_style_block = $header_height_classes . '{' . $header_height_css['tablet'] . '}';
		OhioBuffer::append_to_dynamic_css_buffer( $_style_block, 'tablet' );
	}
	if ( $header_height_css['mobile'] ) {
		$_style_block = $header_height_classes . '{' . $header_height_css['mobile'] . '}';
		OhioBuffer::append_to_dynamic_css_buffer( $_style_block, 'mobile' );
	}
}

if ( $back_link ) {
	$back_link_classes = '.clb-back-link';

	$_style_block = $back_link_classes . '{' . $back_link_css . '}';
	OhioBuffer::append_to_dynamic_css_buffer( $_style_block);

}

if ( $fixed_height_css ) {
	$fixed_height_classes = '.site-header.header-fixed .header-wrap';

	if ( $fixed_height_css['desktop'] ) {
		$_style_block = $fixed_height_classes . '{' . $fixed_height_css['desktop'] . '}';
		OhioBuffer::append_to_dynamic_css_buffer( $_style_block, 'desktop' );
	}
	if ( $fixed_height_css['tablet'] ) {
		$_style_block = $fixed_height_classes . '{' . $fixed_height_css['tablet'] . '}';
		OhioBuffer::append_to_dynamic_css_buffer( $_style_block, 'tablet' );
	}
	if ( $fixed_height_css['mobile'] ) {
		$_style_block = $fixed_height_classes . '{' . $fixed_height_css['mobile'] . '}';
		OhioBuffer::append_to_dynamic_css_buffer( $_style_block, 'mobile' );
	}
}

if ( $sitename_typo_css ) {
	$_selector = [
		'#masthead.site-header .site-title a',
		'.fullscreen-nav .site-title',
		'.fullscreen-nav .site-title a'
	];
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $sitename_typo_css );
}

if ( $custom_button_color_css ) {
	$_selector = [
		'.btn-optional'
	];
	OhioBuffer::pack_dynamic_css_to_buffer( $_selector, $custom_button_color_css );
}