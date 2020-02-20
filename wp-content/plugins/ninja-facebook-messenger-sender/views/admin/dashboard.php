<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="wrap">
    <h1><?php echo __('Dashboard', NJT_FB_MESS_I18N); ?></h1>
    <form action="" method="post">
        <?php
        if (!$pluginHasSettings) {
            echo sprintf(__('Please go to <a href="%s">settings page</a> to complete required fields.', NJT_FB_MESS_I18N), $settings_page_url);
        } else {
            $user_token = get_option('njt_fb_mess_fb_user_token', false);
            if (!$user_token || empty($user_token)) {
                $data = array(
                    'login_facebook_url' => $njt_fb_mess_api->generateLoginUrl($login_callback_url),
                );
                echo NjtFbMessView::load('admin.generate-token', $data);
            } else {
                $pages_from_api = $njt_fb_mess_api->getAllPages();
                /*foreach ($pages_from_api as $k => $page) {
                    $njt_fb_mess_api->subscribeAppToPage($page['access_token']);
                }*/
                
                $pages = $pages_from_api;

                /*
                 * subscribe pages
                 */
                
                
                echo '<ul class="njt-fb-mess-list-pages">';
                foreach ($pages as $k => $page) {
                    echo '<li>
                        <h3><a href="'.esc_url($settings_page_url.'&page_id='.$page['id']).'">'.$page['name'].'</a></h3>                        
                    </li>';
                }
                echo '</ul>';
            }
        }
        ?>
    </form>
</div>