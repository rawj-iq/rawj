<?php
// Settings
$mobile_is_fixed = OhioOptions::get_global( 'page_header_mobile_menu_fixed' );
$fixed_initial_offset = OhioOptions::get_global( 'page_header_fixed_initial_offset' );
$show_subheader = OhioSettings::subheader_is_displayed();
$mobile_search_visibility = OhioOptions::get( 'page_mobile_search_visibility', true );
$mobile_hamburger_position = OhioOptions::get_global( 'page_header_mobile_menu_position', 'left' );

$header_classes = '';

if ( $show_subheader ) {
    $header_classes .= ' subheader_included';
}
if ( !$mobile_search_visibility ) {
    $header_classes .= ' without-mobile-search';
}

$header_classes .= ' mobile-hamburger-position-' . $mobile_hamburger_position .' hamburger-position-left'; 



$menu_type = OhioOptions::get( 'page_header_menu_type', 'full' );

if ( $menu_type == "both" ) {
    $header_classes .= ' both-types';
} else if ($menu_type == "full") {
    $header_classes .= ' extended-menu';
}
?>

<header id="masthead" class="site-header dark-text header-5<?php echo esc_attr($header_classes); ?>"
    <?php if ($mobile_is_fixed) {
        echo ' data-mobile-header-fixed="true"';
    } ?>
    <?php if ($fixed_initial_offset) {
        echo ' data-fixed-initial-offset="' . $fixed_initial_offset . '"';
    } ?>>
    <div class="header-wrap">
        <div class="header-wrap-inner vertical-inner">
            <div class="top-part">
                <?php get_template_part( 'parts/elements/menu_hamburger' );?>
                <?php get_template_part('parts/elements/menu_logo'); ?>
            </div>

            <div class="middle-part">
                <?php get_template_part('parts/elements/menu_nav'); ?>
                <?php get_template_part('parts/elements/lang_dropdown'); ?>
            </div>

            <div class="bottom-part">
                <?php get_template_part('parts/elements/menu_optional'); ?>
                <div class="close-menu"></div>
                <?php if ( $mobile_hamburger_position == 'right'): ?>
                    <?php get_template_part( 'parts/elements/menu_hamburger' );?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<?php get_template_part('parts/elements/menu_hamburger_fullscreen'); ?>