<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="njt-fb-mess-list-pages-header">
    <h1><?php _e('Pages', NJT_FB_MESS_I18N);?></h1><br><br>
    <?php _e('By clicking On/Off, you allow that fan page to collect user database via Messenger.', NJT_FB_MESS_I18N)?>
    <a onclick="return confirm('<?php _e('Are you sure?', NJT_FB_MESS_I18N);?>');" class="button njt-button njt-fb-mess-reload-page-btn" href="<?php echo esc_url($reload_page_url); ?>">
    <?php echo __('Reload Pages', NJT_FB_MESS_I18N); ?>
    </a>
</div>
<div class="njt-fb-mess-list-pages">
    <?php
if ($errors) {
    echo '<div class="error"><p>' . $errors . ' Please click button <strong>Reload Pages</strong> to get again!!!</p></div>';
}
foreach ($pages as $k => $page) {
    $link_page = add_query_arg(array('page_id' => $page->page_id), $dashboard_url);
    ?>
        <div class="njt-page" data-fb_page_id="<?php echo esc_attr($page->page_id); ?>">
            <div class="njt-inner">
                <div class="njt-page-image">
                    <a data-link="<?php echo esc_url($link_page); ?>" href="<?php echo esc_url($link_page); ?>">
                        <img src="https://graph.facebook.com/<?php echo $page->page_id; ?>/picture/?type=large" alt="" />
                    </a>
                </div>
                <h3>
                    <a data-link="<?php echo esc_url($link_page); ?>" href="<?php echo esc_url($link_page); ?>"><?php echo $page->page_name; ?></a>
                </h3>
                <div class="njt-fb-mess-subscribe-btns">
                    <div class="toggle-group">
                        <input class="njt-fb-mess-on-off-switch" type="checkbox" name="on-off-switch-njt-page<?php echo $page->id; ?>" id="on-off-switch-njt-page<?php echo $page->id; ?>" tabindex="1" <?php echo (($page->is_subscribed == '1') ? 'checked="checked"' : ''); ?> />
                        <label for="on-off-switch-njt-page<?php echo $page->id; ?>">
                            <span class="aural">Show:</span>
                        </label>
                        <div class="onoffswitch" aria-hidden="true">
                            <div class="onoffswitch-label">
                                <div class="onoffswitch-inner"></div>
                                <div class="onoffswitch-switch"></div>
                            </div>
                        </div>
                    </div>
                    <?php /*
    <div class="njt-fb-mess-subscribe-wrap" style="display: none;<?php //echo (($page->is_subscribed == '0') ? 'block' : 'none'); ?>">
    <a href="javascript:void(0)" class="button njt-button njt-fb-mess-subscribe-btn">
    <?php echo __('Subscribe', NJT_FB_MESS_I18N); ?>
    </a>
    </div>
    <div class="njt-fb-mess-unsubscribe-wrap" style="display: none;<?php //echo (($page->is_subscribed == '0') ? 'none' : 'block'); ?>">
    <a href="javascript:void(0)" class="button njt-button njt-fb-mess-unsubscribe-btn">
    <?php echo __('Unsubscribe', NJT_FB_MESS_I18N); ?>
    </a>
    </div>
     */
    ?>
                </div>
                <?php do_action('njt_fb_mess_page_btns', $page);?>
            </div>
        </div>
    <?php
}
?>
</div>