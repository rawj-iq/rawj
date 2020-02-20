<?php

/* function remove_acf_menu() {
	remove_menu_page('edit.php?post_type=acf-field-group');
}
add_action( 'admin_menu', 'remove_acf_menu', 999 ); */

function ohio_acf_json_load_point( $paths ) {
	$paths = array( get_template_directory() . '/inc/tgmpa/acf-json' );
	if( is_child_theme() ) {
		$paths[] = get_stylesheet_directory() . '/inc/tgmpa/acf-json';
	}
	return $paths;
}

add_filter('acf/settings/load_json', 'ohio_acf_json_load_point');


if ( function_exists( 'acf_add_options_page' ) && function_exists( 'acf_add_options_sub_page' ) ) {

	acf_add_options_page(array(
		'page_title' => esc_html__( 'Ohio Theme Settings', 'ohio' ),
		'menu_title' => esc_html__( 'Theme Settings', 'ohio' ),
		'menu_slug' => 'theme-general',
		'capability' => 'edit_posts',
		'icon_url' => get_template_directory_uri().'/inc/tgmpa/theme_settings.png'
	));

	acf_add_options_sub_page(array(
		'page_title' => esc_html__( 'Theme Pages Settings', 'ohio' ),
		'menu_title' => esc_html__( 'Branding', 'ohio' ),
		'menu_slug' => 'theme-general-branding',
		'parent_slug' => 'theme-general'
	));

	acf_add_options_sub_page(array(
		'page_title' => esc_html__( 'Theme Pages Settings', 'ohio' ),
		'menu_title' => esc_html__( 'Theme Styling', 'ohio' ),
		'menu_slug' => 'theme-general-styling',
		'parent_slug' => 'theme-general'
	));

	acf_add_options_sub_page(array(
		'page_title' => esc_html__( 'Theme Pages Settings', 'ohio' ),
		'menu_title' => esc_html__( 'Typography', 'ohio' ),
		'menu_slug' => 'theme-general-typography',
		'parent_slug' => 'theme-general'
	));

	acf_add_options_sub_page(array(
		'page_title' => esc_html__( 'Theme Header Settings', 'ohio' ),
		'menu_title' => esc_html__( 'Header & Menu', 'ohio' ),
		'menu_slug' => 'theme-general-header',
		'parent_slug' => 'theme-general'
	));

	acf_add_options_sub_page(array(
		'page_title' => esc_html__( 'Theme Pages Settings', 'ohio' ),
		'menu_title' => esc_html__( 'Page Settings', 'ohio' ),
		'menu_slug' => 'theme-general-pages',
		'parent_slug' => 'theme-general'
	));

	acf_add_options_sub_page(array(
		'page_title' => esc_html__( 'Theme Portfolio Settings', 'ohio' ),
		'menu_title' => esc_html__( 'Portfolio', 'ohio' ),
		'menu_slug' => 'theme-general-portfolio',
		'parent_slug' => 'theme-general'
	));

	acf_add_options_sub_page(array(
		'page_title' => esc_html__( 'Theme Blog Settings', 'ohio' ),
		'menu_title' => esc_html__( 'Blog', 'ohio' ),
		'menu_slug' => 'theme-general-blog',
		'parent_slug' => 'theme-general'
	));

	acf_add_options_sub_page(array(
		'page_title' => esc_html__( 'Theme Post Settings', 'ohio' ),
		'menu_title' => esc_html__( 'Single Post', 'ohio' ),
		'menu_slug' => 'theme-general-post',
		'parent_slug' => 'theme-general'
	));

	acf_add_options_sub_page(array(
		'page_title' => esc_html__( 'Theme WooCommerce Settings', 'ohio' ),
		'menu_title' => esc_html__( 'Shop', 'ohio' ),
		'menu_slug' => 'theme-general-woocommerce',
		'parent_slug' => 'theme-general'
	));

	acf_add_options_sub_page(array(
		'page_title' => esc_html__( 'Theme WooCommerce Product Settings', 'ohio' ),
		'menu_title' => esc_html__( 'Single Product', 'ohio' ),
		'menu_slug' => 'theme-general-product',
		'parent_slug' => 'theme-general'
	));

	acf_add_options_sub_page(array(
		'page_title' => esc_html__( 'Subscribe Settings', 'ohio' ),
		'menu_title' => esc_html__( 'Subscribe', 'ohio' ),
		'menu_slug' => 'theme-general-subscribe',
		'parent_slug' => 'theme-general'
	));

	acf_add_options_sub_page(array(
		'page_title' => esc_html__( 'Theme Footer Settings', 'ohio' ),
		'menu_title' => esc_html__( 'Footer', 'ohio' ),
		'menu_slug' => 'theme-general-footer',
		'parent_slug' => 'theme-general'
	));

	acf_add_options_sub_page(array(
		'page_title' => esc_html__( 'Theme Blog Settings', 'ohio' ),
		'menu_title' => esc_html__( 'Custom CSS', 'ohio' ),
		'menu_slug' => 'theme-general-custom',
		'parent_slug' => 'theme-general'
	));

	acf_add_options_sub_page(array(
		'page_title' => esc_html__( 'Theme Plugins Settings', 'ohio' ),
		'menu_title' => esc_html__( 'Other Settings', 'ohio' ),
		'menu_slug' => 'theme-general-other',
		'parent_slug' => 'theme-general'
	));

	acf_add_options_sub_page(array(
		'page_title' => '',
		'menu_title' => esc_html__( 'Support', 'ohio' ),
		'menu_slug' => 'theme-general-support',
		'parent_slug' => 'theme-general'
	));

}

// Hide "inherit" option for global background types
add_filter('acf/load_field/name=background_type', function( $field ) {
	if ( ! function_exists( 'get_current_screen' ) ) return $field;

	$screen = get_current_screen();
	if ( isset( $screen->base ) ) {
		if ( in_array( $screen->base, [
			'theme-settings_page_theme-general-pages',
			'theme-settings_page_theme-general-header',
			'theme-settings_page_theme-general-footer',
			'theme-settings_page_theme-general-subscribe'
		] ) ) {
			unset($field['choices']['inherit']);
		}
	}

	return $field;
});

// Remove post options from Page settings if not post page
add_filter('acf/load_field/name=header_title_subtitle_type', function( $field ) {
	if ( ! function_exists( 'get_current_screen' ) ) return $field;
	$screen = get_current_screen();
	if ( isset( $screen->base ) ) {
		if ( $screen->post_type == 'post' ) {
			return $field;
		}
		if ( $screen->base == 'theme-settings_page_theme-general-post' ) {
			return $field;
		}
		return false;
	}

	return $field;
});

add_filter('acf/prepare_field/name=page_post_style_in_grid', function( $field ) {
	if ( ! function_exists( 'get_current_screen' ) ) return $field;
	$screen = get_current_screen();
	if ( isset( $screen->base ) ) {
		if ( $screen->post_type == 'post' ) {
			return $field;
		}
		return false;
	}

	return $field;
});

// Header title additional "Featured image" option
add_filter('acf/prepare_field/name=page_header_title', function( $field ) {
	$field['sub_fields'][0]['choices']['featured'] = 'Featured image';
	return $field;
});
// Global post header title additional "Featured image" option
add_filter('acf/prepare_field/name=global_post_page_header_title', function( $field ) {
	$field['sub_fields'][0]['choices']['featured'] = 'Featured image';
	return $field;
});

// Inherited slug field apply
add_filter('acf/prepare_field/type=clone', function( $field ) {
	$background_group_key = 'group_982e082a3bcfcf81b766eaa1ec2df4f11e0f5cd3';
	if ( $field['clone'] && $field['clone'][0] == $background_group_key ) {

		if ( isset( $field['inherited_slug'] ) && isset( $field['sub_fields'][0]['choices']['inherit'] ) ) {
			$field['sub_fields'][0]['choices']['inherit'] = $field['inherited_slug'];
		}
	}

	return $field;
});


/*
// Hard return values for ACF
function ohio_acf_return_default_when_null( $value = NULL, $post_id = NULL, $field = NULL ) {
	if ( ( $field['type'] == 'radio' || $field['type'] == 'select' || $field['type'] == 'true_false' ) && $field['default_value'] && $value == '' ) {
		if ( is_array( $field['default_value'] ) && count( $field['default_value'] ) == 1 ) {
			$field['default_value'] = $field['default_value'][0];
		}
		$value = $field['default_value'];
	}
	return $value;
}

add_filter( 'acf/load_value', 'ohio_acf_return_default_when_null', 10, 3 );
*/

// fallbacks
 if ( ! is_admin() ) {

 	if ( ! function_exists( 'have_rows' ) ) {
 		function have_rows() {
 			return false;
 		}
 	}

 	if ( ! function_exists( 'the_row' ) ) {
 		function the_row() {
 			return false;
 		}
 	}
 }



/* sync ACF options */
add_action('acf/save_post',  __NAMESPACE__ . '\\ohio_sync_custom_field', 11);
function ohio_sync_custom_field ( $current_post_id ) {
    $post_ids = [];

	if (function_exists('icl_get_languages')) {
		$langs = icl_get_languages('skip_missing=0&orderby=KEY&order=DIR&link_empty_to=str');
		$wpml_options = get_option( 'icl_sitepress_settings' );
		$default_lang = $wpml_options['default_language'];

		$option_pages = array();
		foreach ($langs as $language) {
			if($language['language_code'] === $default_lang){
				$post_ids[$default_lang] = 'option';
				$option_pages[] =  'options';
			} else {
				$post_ids[$language['language_code']] = 'options_'.$language['language_code'];
				$option_pages[] =  'options_'.$language['language_code'];;
			}
		}

		$options = get_field_objects('option');

		// Sync option page fields
		if (in_array($current_post_id,$option_pages)) {

			foreach ($options as $field) {
				foreach ($post_ids as $lang_id) {

					if ($field['type'] == 'file') {
						$value = get_field( $field['name'], 'option', false);
					} else {
						$value = get_field( $field['name'], 'option', false);
					}

					if ( 'option' != $lang_id ) { update_field( $field['name'], $value, $lang_id); }

				}
			}
		}
	}
}


if( function_exists('acf_add_local_field_group') && function_exists('wc_get_attribute_taxonomy_names') ):

	$attribute_terms = wc_get_attribute_taxonomy_names();

	if ($attribute_terms) {
		$group_filter = array();
		foreach( $attribute_terms as $attribute_term ) {
			$group_filter[] = array( array(
				'param'    => 'taxonomy',
				'operator' => '==',
				'value'    => $attribute_term,
				'order_no' => 0,
				'group_no' => 0,
			) );
		}

		acf_add_local_field_group(array (
			'key' => 'ohioattrsetting',
			'title' => esc_html__('Attribute setting', 'ohio'),
			'fields' => array (
				array (
					'key' => 'field_ohioattrsettingselect',
					'label' => 'Mod',
					'name' => 'attribute_mod',
					'type' => 'select',
					'choices' => array(
						'default' 	=> 'Default',
						'color'		=> 'Color'
					),
					'allow_null' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array(
					'key'	=> 'field_ohioattrsettingcolor',
					'label' => 'Choose color',
					'name' => 'color',
					'type' => 'color_picker',
					'conditional_logic'	=> array(
						array(
							array(
								'field' => 'field_ohioattrsettingselect',
								'operator' => '==',
								'value' => 'color')
							)
						)
				)
			),
			'location' => $group_filter,
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
		));
	}
endif;
