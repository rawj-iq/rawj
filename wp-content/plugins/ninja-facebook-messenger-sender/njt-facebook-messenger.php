<?php
/*
 * Plugin Name: NinjaTeam Facebook Messenger Sender
 * Plugin URI: http://ninjateam.org
 * Description: Send bulk messages to those who messaged your page
 * Version: 2.0.1
 * Author: NinjaTeam
 * Author URI: http://ninjateam.org
 */
if (!defined('ABSPATH')) {
    exit;
}

define('NJT_FB_MESS_FILE', __FILE__);

define('NJT_FB_MESS_DIR', realpath(plugin_dir_path(NJT_FB_MESS_FILE)));
define('NJT_FB_MESS_URL', plugins_url('', NJT_FB_MESS_FILE));
define('NJT_FB_MESS_I18N', 'njt_fc_messenger');
define('NJT_FB_MESS_VER', '1.7');

require_once NJT_FB_MESS_DIR . '/src/Facebook/autoload.php';

require_once NJT_FB_MESS_DIR . '/src/functions.php';
require_once NJT_FB_MESS_DIR . '/src/category.class.php';

require_once NJT_FB_MESS_DIR . '/src/NjtView.class.php';
require_once NJT_FB_MESS_DIR . '/src/NjtFbMessApi.class.php';
require_once NJT_FB_MESS_DIR . '/init.php';

$njt_fb_mess_api = new NjtFbMessApi();

NjtFbMessenger::instance();
