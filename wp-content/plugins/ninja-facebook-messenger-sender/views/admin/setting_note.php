<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="njt-fb-mess-note-wrap">
    <h1><?php _e('Please make sure:', NJT_FB_MESS_I18N); ?></h1>
    <div class="njt-fb-mess-note">
        <ul>
            <li><?php _e('1. Your website need to use https. You can get <a href="https://letsencrypt.org/">Free SSL here</a> ', NJT_FB_MESS_I18N); ?></li>
            <br />
            <li>
                <?php _e('2. IMPORTANT: After inserting your App ID and App Secret, go to your <strong>App Setting</strong>, insert the URL bellow to <strong>Valid OAuth redirect URIs</strong>.', NJT_FB_MESS_I18N); ?>
                <?php echo sprintf(__('<a href="%s" target="_blank">See image</a>', NJT_FB_MESS_I18N), 'https://demo.ninjateam.org/njt-facebook-messenger/wp-content/plugins/njt-facebook-messenger/assets/img/oauth.jpg') ?>
                <br />
                <input type="text" name="" value="<?php echo $login_callback_url; ?>" class="regular-text" onclick="this.select()" />
            </li>
            <li class="njt-fb-mess-opa">
                <br />
                <?php _e('3. The app\'s Webhooks setting is inserted automatically. If not, go to your <strong>App setting</strong> =>  click on <strong>Webhooks</strong> => click <strong>New Subscription</strong> => click <strong>Page</strong>.' , NJT_FB_MESS_I18N); ?>
                <?php echo sprintf(__('<a href="%s" target="_blank">See image</a>', NJT_FB_MESS_I18N), 'https://demo.ninjateam.org/njt-facebook-messenger/wp-content/plugins/njt-facebook-messenger/assets/img/webhooks.jpg') ?>
                <br />
                <strong><?php _e('Callback URL:', NJT_FB_MESS_I18N); ?></strong><br />
                <input type="text" name="" value="<?php echo $webhook_callback_url; ?>" class="regular-text" onclick="this.select()" /><br />
                <strong><?php _e('Verify Token:', NJT_FB_MESS_I18N); ?></strong><br />
                <input type="text" name="" value="<?php echo get_option('njt_fb_mess_fb_verify_token'); ?>" class="regular-text" onclick="this.select()" /><br />
                <strong><?php _e('Subscription Fields:', NJT_FB_MESS_I18N); ?></strong><br />
                <span>message_deliveries, messages, messaging_optins, messaging_postbacks</span>
            </li>
        </ul>
    </div>
</div>