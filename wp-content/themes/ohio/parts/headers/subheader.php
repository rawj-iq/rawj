<?php
// Settings
$show_subheader = OhioSettings::subheader_is_displayed();
$use_wrapper = OhioOptions::get( 'page_header_menu_use_wrapper', true );

$is_fixed = OhioOptions::get( 'page_header_menu_fixed', true );

$header_menu_style = OhioOptions::get( 'page_header_menu_style', 'style1' );
if ( $header_menu_style == 'style2' ) $use_wrapper = true;
if ( $header_menu_style == 'style6' ) $use_wrapper = false;

$subheader_have_items_left = have_rows( 'global_page_subheader_items_left', 'option' );
$subheader_have_items_right = have_rows( 'global_page_subheader_items_right', 'option' );

$currency_switcher = OhioOptions::get_global( 'woocommerce_header_currency_switcher', false );
$language_switcher = OhioOptions::get_global( 'woocommerce_header_lanhuage_switcher', false );

$have_wpml = function_exists('icl_get_languages');
?>

<?php if ($show_subheader) : ?>

    <div class="subheader<?php if ($is_fixed) {
        echo esc_attr(' fixed');
    } ?>">
        <div class="content">

            <div class="page-container<?php if ( !$use_wrapper ) {
                echo esc_attr(' full');
            } ?>">

                <?php if ($subheader_have_items_left) : ?>
                    <ul class="left">
                        <?php while (have_rows('global_page_subheader_items_left', 'option')): the_row(); ?>
                            <li><?php echo get_sub_field('items'); ?></li>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>


                <ul class="right">
                    <?php if ($currency_switcher && shortcode_exists('woocs')): ?>
                        <li>
                            <div class="currency_switcher">
                                <?php echo do_shortcode('[woocs]'); ?>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ($have_wpml && $language_switcher) : ?>
                        <li>
                            <?php
                            $languages = icl_get_languages('skip_missing=1');
                            if (!empty($languages)) : ?>

                                <div class="select select-dropdown">
                                    <div class="select-styled">
                                        <?php
                                        // $languages = icl_get_languages('skip_missing=1');
                                        $curr_lang = array();
                                        if (!empty($languages)) {
                                            foreach ($languages as $language) {
                                                if (!empty($language['active'])) {
                                                    $curr_lang = $language; // This will contain current language info.
                                                    break;
                                                }
                                            }
                                            echo '<img src="' . $curr_lang['country_flag_url'] . '" alt="' . $curr_lang['code'] . '" class="icon">';
                                            echo esc_html($curr_lang['translated_name']);
                                        }
                                        ?>
                                    </div>
                                    <ul class="select-options">
                                        <?php
                                        $languages = icl_get_languages('orderby=name');
                                        foreach ($languages as $language) {
                                            $class = ($language['active']) ? ' class="active"' : '';
                                            printf('<li%s><a href="%s"><img src="%s" alt="%s"> %s</a></li>', $class, $language['url'],
                                                $language['country_flag_url'], $language['code'], $language['native_name']);
                                        }
                                        ?>
                                    </ul>
                                </div>

                            <?php endif; ?>
                        </li>
                    <?php endif; ?>

                    <?php if ($subheader_have_items_right) : ?>
                        <?php while ( have_rows( 'global_page_subheader_items_right', 'option' ) ): the_row(); ?>
                            <li><?php echo get_sub_field('items'); ?></li>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </ul>

            </div>
        </div>
    </div><!-- .subheader -->

<?php endif; ?>