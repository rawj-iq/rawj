<?php
$check_active = -1;
if (get_option("njt_bulksender_active")) {
    $license_active = get_option("njt_bulksender_active");
    $day_current = date('Y-m-d H:i:s', time());
    $supported_until = $license_active["supported_until"];
    $check_active = strtotime($supported_until) - strtotime($day_current);
}
?>
<div class="wrap">
<h1>Enter your item purchase code to get Premium Support</h1>
<p><a href="https://ninjateam.org/can-find-item-purchase-code/" target="_blank">Where can I find my item purchase code?</a></p>
    <form action="" class="njt-check-purchase-frm" method="POST">
        <?php if ($check_active == -1) {?>
        <ul class="njt-check-purchase-wrap">
            <input type="hidden" name="nonce" value="<?php echo $nonce; ?>" />
            <li>
                <input type="text" name="njt-check-purchase-code" value="" id="njt-check-purchase-code" required="required" class="regular-text" placeholder="<?php _e('Enter your purchase code', NJT_FB_MESS_I18N);?>" />
            </li>
            <li>
                <?php submit_button(__('Submit', NJT_FB_MESS_I18N));?>
            </li>
        </ul>
        <div class="njt-check-purchase-result"></div>
    <?php } else {?>
        <div class="njt-check-purchase-result"><a target="_blank" class="button button-primary" href="https://m.me/ninjateam.org"><?php _e('Chat With Support', NJT_FB_MESS_I18N)?></a></div>

    <?php }?>
    </form>
</div>