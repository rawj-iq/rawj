<?php
    // Settings
    $menu_type = OhioOptions::get( 'page_header_menu_type', 'full' );
    $have_woocomerce = function_exists( 'WC' );
    $have_woocomerce_wl = function_exists( 'YITH_WCWL' );
    $have_wpml = function_exists( 'icl_get_languages' );
    $wpml_show_in_header = OhioOptions::get_global( 'wpml_show_in_header', true );
    $header_have_social = have_rows( 'global_header_menu_social_links', 'option' );
    $mobile_social_position = OhioOptions::get_global( 'page_mobile_header_social_position', 'default' );
    $mobile_menu_position = OhioOptions::get_global( 'page_mobile_header_menu_position', 'left' );
    $dropdown_carets_visibility = OhioOptions::get_global( 'page_header_counters_visibility', true );

    $site_navigation_class = '';
    if ( $menu_type == 'hamburger' ) {
        $site_navigation_class .= ' hidden';
    }

    if ( $mobile_menu_position == 'right' ) {
        $site_navigation_class .= ' slide-right';
    }

    if ( $dropdown_carets_visibility ) {
        $site_navigation_class .= ' with-counters';
    }
?>

<nav id="site-navigation" class="main-nav<?php echo esc_attr( $site_navigation_class ); ?>">

    <!-- Mobile overlay -->
    <div class="mbl-overlay menu-mbl-overlay">
        <div class="mbl-overlay-bg"></div>

        <!-- Close bar -->
        <div class="close-bar text-left">
            <div class="btn-round btn-round-light clb-close" tabindex="0">
                <i class="ion ion-md-close"></i>
            </div>

            <!-- Search -->
            <?php get_template_part( 'parts/elements/search' ); ?>
        </div>
        <div class="mbl-overlay-container">

            <!-- Navigation -->
            <div id="mega-menu-wrap" class="main-nav-container">

                <?php
                    $menu = OhioOptions::get_global( 'page_extended_menu' );

                    if ( $menu ) {
                        $menu_exists = false;
                        $available_menus = wp_get_nav_menus();
                        foreach ($available_menus as $available_menu) {
                            if ($menu == $available_menu->term_id) {
                                $menu_exists = true;
                                break;
                            }
                        }
                        if (!$menu_exists) $menu = false;
                    }

                    if ( $menu ) {
                        wp_nav_menu( array( 'menu' => $menu, 'menu_id' => 'primary-menu' ) );
                    } else {
                        if ( has_nav_menu( 'primary' ) ) {
                            wp_nav_menu( array( 'theme_location' => 'primary') );
                        } else {
                            echo '<span class="menu-blank">' . sprintf( esc_html__( 'Please, %1$s assign a menu %2$s', 'ohio' ), '<a target="_blank" href="' . esc_url( home_url( '/' ) ) . 'wp-admin/nav-menus.php">', '</a>' ) . '</span>';
                        }
                    }
                ?>
            </div>

            <!-- Copyright -->
            <div class="copyright">
                <?php echo wp_kses( OhioOptions::get_global( 'footer_copyright_left' ), 'post' ); ?>
                <br>
                <?php echo wp_kses( OhioOptions::get_global( 'footer_copyright_right' ), 'post' ); ?>
            </div>
            <?php get_template_part( 'parts/elements/social_networks' ); ?>
            <!-- Social links -->
            <?php if ( $header_have_social && $mobile_social_position == 'inside' ) : ?>
                <div class="socialbar small">
                <?php
                    while ( have_rows( 'global_header_menu_social_links', 'option' ) ) :
                        the_row();

                        $_network_field = get_sub_field( 'social_network' );
                        printf( '<a href="%s" class="%s">', esc_url( get_sub_field( 'url' ) ), esc_attr( $_network_field ) );

                        switch ( $_network_field ) {
                            case 'facebook':    echo '<i class="icon fa fa-facebook-f"></i>';     break;
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
</nav>
