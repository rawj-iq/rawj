<?php
$logo = OhioSettings::get_logo(false);
switch ( OhioOptions::get_global( 'page_fullscreen_menu_style', 'default' ) ) {
    case 'centered':
        $logo = OhioSettings::get_logo(true);
        break;
    case 'split':
        $logo = OhioSettings::get_logo(true);
        break;
}
$logo_as_image = is_array($logo);
$have_wpml = function_exists('icl_get_languages');

$menu_class = '';
switch ( OhioOptions::get_global( 'page_fullscreen_menu_style', 'default' ) ) {
    case 'centered':
        $menu_class .= ' centered';
        break;
    case 'split':
        $menu_class .= ' split';
        break;
}
$header_have_social = have_rows( 'global_header_menu_social_links', 'option' );

$header_overlay_footer_has_left = have_rows( 'global_page_overlay_menu_footer_items_left', 'option' );

$menu_position = OhioOptions::get_global( 'page_header_menu_position', 'left', true );

?>

<div class="clb-popup clb-hamburger-nav<?php echo esc_attr( $menu_class ); ?>">
    <div class="close-bar text-<?php echo esc_attr($menu_position) ?>">
        <div class="btn-round clb-close" tabindex="0">
            <i class="ion ion-md-close"></i>
        </div>
    </div>

    <!-- Nav -->
    <div class="clb-hamburger-nav-holder">
        <?php
            $menu = OhioOptions::get_global( 'page_hamburger_menu' );

            if ( $menu ) {
                wp_nav_menu( array( 'menu' => $menu, 'menu_id' => 'secondary-menu' ) );
            } else {
                if ( has_nav_menu( 'primary' ) ) {
                    wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'secondary-menu' ) );
                } else {
                    echo '<span class="menu-blank">' . sprintf(esc_html__('Please, %1$sassign a menu%2$s', 'ohio'), '<a target="_blank" href="' . esc_url(home_url('/')) . 'wp-admin/nav-menus.php">', '</a>') . '</span>';
                }
            }
        ?>
    </div>

    <!-- Nav -->
    <div class="clb-hamburger-nav-details">
        <?php get_template_part('parts/elements/lang_dropdown'); ?>

        <?php if ($header_overlay_footer_has_left): ?>
            <div class="hamburger-nav-info">
                <?php while ( have_rows( 'global_page_overlay_menu_footer_items_left', 'option' ) ): the_row(); ?>
                    <p class="hamburger-nav-info-item">
                        <?php echo wp_kses(get_sub_field('items'), 'post'); ?>
                    </p>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        
        <?php if ( $header_have_social ) : ?>
            <div class="socialbar small outline inverse">
                <?php
                    while ( have_rows( 'global_header_menu_social_links', 'option' ) ) :
                        the_row();

                        $_network_field = get_sub_field( 'social_network' );
                        printf( '<a href="%s" class="%s">', esc_url( get_sub_field( 'url' ) ), esc_attr( $_network_field ) );

                        switch ( $_network_field ) {
                            case 'facebook':    echo '<i class="icon fa fa-facebook-f"></i>';   break;
                            case 'twitter':     echo '<i class="icon fa fa-twitter"></i>';      break;
                            case 'instagram':   echo '<i class="icon fa fa-instagram"></i>';    break;
                            case 'dribbble':    echo '<i class="icon fa fa-dribbble"></i>';     break;
                            case 'github':      echo '<i class="icon fa fa-github-alt"></i>';   break;
                            case 'linkedin':    echo '<i class="icon fa fa-linkedin"></i>';     break;
                            case 'vimeo':       echo '<i class="icon fa fa-vimeo"></i>';        break;
                            case 'youtube':     echo '<i class="icon fa fa-youtube"></i>';      break;
                            case 'vk':          echo '<i class="icon fa fa-vk"></i>';           break;
                            case 'behance':     echo '<i class="icon fa fa-behance"></i>';      break;
                            case 'flickr':      echo '<i class="icon fa fa-flickr"></i>';       break;
                            case 'reddit':      echo '<i class="icon fa fa-reddit-alien"></i>'; break;
                            case 'snapchat':    echo '<i class="icon fa fa-snapchat"></i>';     break;
                            case 'whatsapp':    echo '<i class="icon fa fa-whatsapp"></i>';     break;
                            case 'quora':       echo '<i class="icon fa fa-quora"></i>';        break;
                            case 'vine':        echo '<i class="icon fa fa-vine"></i>';         break;
                            case 'periscope':   echo '<i class="icon fa fa-periscope"></i>';    break;
                            case 'digg':        echo '<i class="icon fa fa-digg"></i>';         break;
                            case 'viber':       echo '<i class="icon fa fa-viber"></i>';        break;
                            case 'foursqure':   echo '<i class="icon fa fa-foursquare"></i>';   break;
                        }

                        echo '</a>';
                    endwhile;
                ?>
            </div>
        <?php endif; ?>
    </div>
</div>
