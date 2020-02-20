<?php
    $header_have_social = have_rows( 'global_header_menu_social_links', 'option' );
    $social_icons = OhioOptions::get_global( 'social_network_type', false );
    $social_classes = '';

    if ($social_icons == 'icons') {
        $social_classes = 'icons';
    }
?>

<?php if ( $header_have_social ) : ?>
    <div class="clb-social vc_hidden-xs">
        <ul class="clb-social-holder font-titles <?php echo esc_attr($social_classes); ?>"> 
            <li class="clb-social-holder-follow"><?php esc_html_e( 'Follow Us', 'ohio' ); ?></li>
            <li class="clb-social-holder-dash">&ndash;</li>
            <?php while( have_rows( 'global_header_menu_social_links', 'option' ) ): the_row(); ?>
                <?php switch ( get_sub_field( 'social_network' ) ) {
                    case 'facebook':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="facebook"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-facebook-f'></span> " : "Fb." ?></span></a></li>
                        <?php 
                        break;
                    case 'twitter':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="twitter"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-twitter'></span> " : "Tw." ?></span></a></li>
                        <?php 
                        break;
                    case 'instagram':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="instagram"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-instagram'></span> " : "Inst." ?></span></a></li>
                        <?php 
                        break;
                    case 'dribbble':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="dribbble"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-dribbble'></span> " : "Dr." ?></span></a></li>
                        <?php 
                        break;
                    case 'github':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="github"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-github'></span> " : "Gh." ?></span></a></li>
                        <?php 
                        break;
                    case 'linkedin':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="linkedin"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-linkedin'></span> " : "Lk." ?></span></a></li>
                        <?php 
                        break;
                    case 'vimeo':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="vimeo"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-vimeo'></span> " : "Vm." ?></span></a></li>
                        <?php 
                        break;
                    case 'youtube':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="youtube"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-youtube'></span> " : "Yt." ?></span></a></li>
                        <?php 
                        break;
                    case 'vk':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="vk"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-vk'></span> " : "Vk." ?></span></a></li>
                        <?php 
                        break;
                    case 'behance':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="behance"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-behance'></span> " : "Be." ?></span></a></li>
                        <?php 
                        break;
                    case 'tumblr':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="tumblr"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-tumblr'></span> " : "Tm." ?></span></a></li>
                        <?php 
                        break;
                    case 'flickr':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="flickr"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-flickr'></span> " : "Fl." ?></span></a></li>
                        <?php 
                        break;
                    case 'reddit':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="reddit"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-reddit'></span> " : "Re." ?></span></a></li>
                        <?php 
                        break;
                    case 'snapchat':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="snapchat"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-snapchat'></span> " : "Sn." ?></span></a></li>
                        <?php 
                        break;
                    case 'whatsapp':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="whatsapp"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-whatsapp'></span> " : "Wh." ?></span></a></li>
                        <?php 
                        break;
                    case 'quora':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="quora"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-quora'></span> " : "Qu." ?></span></a></li>
                        <?php 
                        break;
                    case 'vine':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="vine"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-vine'></span> " : "Vn." ?></span></a></li>
                        <?php 
                        break;
                    case 'digg':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="digg"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-digg'></span> " : "Dg." ?></span></a></li>
                        <?php 
                        break;
                    case 'foursquare':
                        ?>
                        <li><a target="_blank" href=" <?php esc_url( get_sub_field( 'url' ) ) ?>" class="foursqure"><?php echo esc_html($social_icons == 'icons') ? "<span class='icon fa fa-foursquare'></span> " : "Fs." ?></span></a></li>
                        <?php 
                        break;
                } ?>
            <?php endwhile; ?>
        </ul>
    </div>
<?php endif; ?>