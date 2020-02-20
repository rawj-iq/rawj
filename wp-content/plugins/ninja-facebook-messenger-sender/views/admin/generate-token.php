<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<h3>
    <?php _e('Please click the button below to connect to Facebook.'); ?>
</h3>
<a href="<?php echo $login_facebook_url; ?>" class="button button-primary"><?php _e('Connect to Facebook', NJT_FB_MESS_I18N); ?></a>