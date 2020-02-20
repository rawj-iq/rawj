<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php echo __('Settings', NJT_FB_MESS_I18N); ?></h1>
    <form action="options.php" method="post">
        <?php settings_fields('njt_fb_mess'); ?>
        <?php do_settings_sections('njt_fb_mess'); ?>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="njt_fb_mess_fb_app_id"><?php _e('Facebook App ID:', NJT_FB_MESS_I18N); ?></label>
                </th>
                <td>
                    <input type="text" name="njt_fb_mess_fb_app_id" id="njt_fb_mess_fb_app_id" class="regular-text" value="<?php echo get_option('njt_fb_mess_fb_app_id'); ?>" />
                    <p class="description"><?php _e('Go to <a href="https://developers.facebook.com" target="_blank">Facebook Developer</a>. If you don\'t know how to get it, view this <a href="https://ninjateam.org/how-to-setup-facebook-messenger-bulksender-plugin/" target="_blank">video tutorial<a>', NJT_FB_MESS_I18N); ?></p>
                </td>                
            </tr>
            <tr>
                <th scope="row">
                    <label for="njt_fb_mess_fb_app_secret"><?php _e('Facebook App Secret:', NJT_FB_MESS_I18N); ?></label>
                </th>
                <td>
                    <input type="text" name="njt_fb_mess_fb_app_secret" id="njt_fb_mess_fb_app_secret" class="regular-text" value="<?php echo get_option('njt_fb_mess_fb_app_secret'); ?>" />
                </td>
            </tr>
        </table>
        <?php
            $data = array(
                'login_callback_url' => $login_callback_url,
                'webhook_callback_url' => $webhook_callback_url
            );
            echo NjtFbMessView::load('admin.setting_note', $data);
        ?>
        <input type="hidden" name="njt_fb_mess_fb_verify_token" value="<?php echo get_option('njt_fb_mess_fb_verify_token'); ?>">
        <input type="hidden" name="njt_fb_mess_fb_user_token" value="<?php echo get_option('njt_fb_mess_fb_user_token'); ?>">
        <?php submit_button(); ?>
    </form>
</div>