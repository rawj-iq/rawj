<?php
if (!defined('ABSPATH')) {
    exit;
}
class NjtFbMessCategory
{
    public static function getCountSender($cat, $page_id = null)
    {
        global $wpdb;
        $cat = intval($cat);
        $count = 0;
        /*
         * If this is uncategorized
         */
        if ($cat == 0) {
            $count = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."njt_fb_mess_senders WHERE 1 = 1 ".((!is_null($page_id)) ? "AND `page_id` = '".$page_id."'" : "")." AND `id` NOT IN (SELECT `sender_id` FROM ".$wpdb->prefix."njt_fb_mess_category_sender)");
        } else {
            $where = array('1 = 1');
            $where[] = "`category_id` = ".$cat;

            if (is_null($page_id)) {
                $count = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."njt_fb_mess_category_sender WHERE ".implode(' AND ', $where)."");
            } else {
                $_senders_have_cat = $wpdb->get_results("SELECT `sender_id` FROM ".$wpdb->prefix."njt_fb_mess_category_sender WHERE `category_id` = " . $cat);

                $senders_have_cat = array();
                foreach ($_senders_have_cat as $k => $v) {
                    $senders_have_cat[] = $v->sender_id;
                }

                $count = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."njt_fb_mess_senders WHERE `page_id` = " . intval($page_id) . ((count($senders_have_cat) > 0)) ? " AND `id` IN (".implode(',', $senders_have_cat).")" : "");
            }
        }
        return $count;
    }
    public static function getCatsOfSender($sender_id)
    {
        global $wpdb;
        $return = array();
        $cats = $wpdb->get_results("SELECT `id`, `name` FROM ".$wpdb->prefix."njt_fb_mess_categories WHERE `id` IN (SELECT `category_id` FROM ".$wpdb->prefix."njt_fb_mess_category_sender WHERE `sender_id` = ".intval($sender_id).")");
        if (count($cats) == 0) {
            $return = array(
                '0' => __('Uncategorized', NJT_FB_MESS_I18N),
            );
        } else {
            foreach ($cats as $k => $v) {
                $return[$v->id] = $v->name;
            }
        }
        return $return;
    }
}
