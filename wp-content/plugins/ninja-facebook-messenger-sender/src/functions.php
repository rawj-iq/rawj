<?php
if (!defined('ABSPATH')) {
    exit;
}
function njt_fb_mess_sender_proccess_array_tr($arr, &$result = array(), $submenu_prefix = '-', $parent_id = 0, $level = 1)
{
    foreach ($arr as $k => $v) {
        if ($v->parent_id == $parent_id) {
            $prefix = '';
            if ($level > 1) {
                for ($i = 0; $i < $level; $i++) {
                    $prefix .= $submenu_prefix;
                }
                $v->name = $prefix . $v->name;
            }
            $result[] = $v;
            $next_level = $level + 1;
            unset($arr[$k]);
            njt_fb_mess_sender_proccess_array_tr($arr, $result, $submenu_prefix, $v->id, $next_level);
        }
    }
}
/**
/* Returns a locale from a language code that is provided.
/*
/* @param $language_code ISO 639-1-alpha 2 language code
/* @returns  a locale, formatted like en_US, or null if not found
/**/
if (!function_exists('njt_language_code_to_locale')) {
    function njt_language_code_to_locale($language_code, $country_code = '')
    {
        // Locale list taken from:
        // http://stackoverflow.com/questions/3191664/
        // list-of-all-locales-and-their-short-codes
        $locales = array('af-ZA',
                        'am-ET',
                        'ar-AE',
                        'ar-BH',
                        'ar-DZ',
                        'ar-EG',
                        'ar-IQ',
                        'ar-JO',
                        'ar-KW',
                        'ar-LB',
                        'ar-LY',
                        'ar-MA',
                        'arn-CL',
                        'ar-OM',
                        'ar-QA',
                        'ar-SA',
                        'ar-SY',
                        'ar-TN',
                        'ar-YE',
                        'as-IN',
                        'az-Cyrl-AZ',
                        'az-Latn-AZ',
                        'ba-RU',
                        'be-BY',
                        'bg-BG',
                        'bn-BD',
                        'bn-IN',
                        'bo-CN',
                        'br-FR',
                        'bs-Cyrl-BA',
                        'bs-Latn-BA',
                        'ca-ES',
                        'co-FR',
                        'cs-CZ',
                        'cy-GB',
                        'da-DK',
                        'de-AT',
                        'de-CH',
                        'de-DE',
                        'de-LI',
                        'de-LU',
                        'dsb-DE',
                        'dv-MV',
                        'el-GR',
                        'en-029',
                        'en-AU',
                        'en-BZ',
                        'en-CA',
                        'en-GB',
                        'en-IE',
                        'en-IN',
                        'en-JM',
                        'en-MY',
                        'en-NZ',
                        'en-PH',
                        'en-SG',
                        'en-TT',
                        'en-US',
                        'en-ZA',
                        'en-ZW',
                        'es-AR',
                        'es-BO',
                        'es-CL',
                        'es-CO',
                        'es-CR',
                        'es-DO',
                        'es-EC',
                        'es-ES',
                        'es-GT',
                        'es-HN',
                        'es-MX',
                        'es-NI',
                        'es-PA',
                        'es-PE',
                        'es-PR',
                        'es-PY',
                        'es-SV',
                        'es-US',
                        'es-UY',
                        'es-VE',
                        'et-EE',
                        'eu-ES',
                        'fa-IR',
                        'fi-FI',
                        'fil-PH',
                        'fo-FO',
                        'fr-BE',
                        'fr-CA',
                        'fr-CH',
                        'fr-FR',
                        'fr-LU',
                        'fr-MC',
                        'fy-NL',
                        'ga-IE',
                        'gd-GB',
                        'gl-ES',
                        'gsw-FR',
                        'gu-IN',
                        'ha-Latn-NG',
                        'he-IL',
                        'hi-IN',
                        'hr-BA',
                        'hr-HR',
                        'hsb-DE',
                        'hu-HU',
                        'hy-AM',
                        'id-ID',
                        'ig-NG',
                        'ii-CN',
                        'is-IS',
                        'it-CH',
                        'it-IT',
                        'iu-Cans-CA',
                        'iu-Latn-CA',
                        'ja-JP',
                        'ka-GE',
                        'kk-KZ',
                        'kl-GL',
                        'km-KH',
                        'kn-IN',
                        'kok-IN',
                        'ko-KR',
                        'ky-KG',
                        'lb-LU',
                        'lo-LA',
                        'lt-LT',
                        'lv-LV',
                        'mi-NZ',
                        'mk-MK',
                        'ml-IN',
                        'mn-MN',
                        'mn-Mong-CN',
                        'moh-CA',
                        'mr-IN',
                        'ms-BN',
                        'ms-MY',
                        'mt-MT',
                        'nb-NO',
                        'ne-NP',
                        'nl-BE',
                        'nl-NL',
                        'nn-NO',
                        'nso-ZA',
                        'oc-FR',
                        'or-IN',
                        'pa-IN',
                        'pl-PL',
                        'prs-AF',
                        'ps-AF',
                        'pt-BR',
                        'pt-PT',
                        'qut-GT',
                        'quz-BO',
                        'quz-EC',
                        'quz-PE',
                        'rm-CH',
                        'ro-RO',
                        'ru-RU',
                        'rw-RW',
                        'sah-RU',
                        'sa-IN',
                        'se-FI',
                        'se-NO',
                        'se-SE',
                        'si-LK',
                        'sk-SK',
                        'sl-SI',
                        'sma-NO',
                        'sma-SE',
                        'smj-NO',
                        'smj-SE',
                        'smn-FI',
                        'sms-FI',
                        'sq-AL',
                        'sr-Cyrl-BA',
                        'sr-Cyrl-CS',
                        'sr-Cyrl-ME',
                        'sr-Cyrl-RS',
                        'sr-Latn-BA',
                        'sr-Latn-CS',
                        'sr-Latn-ME',
                        'sr-Latn-RS',
                        'sv-FI',
                        'sv-SE',
                        'sw-KE',
                        'syr-SY',
                        'ta-IN',
                        'te-IN',
                        'tg-Cyrl-TJ',
                        'th-TH',
                        'tk-TM',
                        'tn-ZA',
                        'tr-TR',
                        'tt-RU',
                        'tzm-Latn-DZ',
                        'ug-CN',
                        'uk-UA',
                        'ur-PK',
                        'uz-Cyrl-UZ',
                        'uz-Latn-UZ',
                        'vi-VN',
                        'wo-SN',
                        'xh-ZA',
                        'yo-NG',
                        'zh-CN',
                        'zh-HANS',
                        'zh-HK',
                        'zh-MO',
                        'zh-SG',
                        'zh-TW',
                        'zu-ZA',
                        );

        foreach ($locales as $locale) {
            $locale_region = locale_get_region($locale);
            $locale_language = locale_get_primary_language($locale);
            $locale_array = array('language' => $locale_language,
                                 'region' => $locale_region);
            var_dump(strtolower($language_code));
            var_dump($locale_language);
            exit();
            if ((strtolower($language_code) == $locale_language) && ($country_code == '')) {
                return locale_compose($locale_array);
            } elseif ((strtolower($language_code) == $locale_language) && (strtoupper($country_code) == $locale_region)) {
                return locale_compose($locale_array);
            }
        }

        return null;
    }
}
function njt_update_sender_meta($sender_id, $meta_key, $meta_value)
{
    global $wpdb;
    $meta_value = maybe_serialize($meta_value);

    $check = $wpdb->get_results("SELECT `meta_id` FROM " . $wpdb->prefix . "njt_fb_mess_sender_meta WHERE `meta_key` = '".$meta_key."' AND `sender_id` = '".$sender_id."'");

    if (count($check) > 0) {
        $wpdb->update(
            $wpdb->prefix . 'njt_fb_mess_sender_meta',
            array('meta_value' => $meta_value),
            array('sender_id' => $sender_id)
        );
    } else {
        $wpdb->insert(
            $wpdb->prefix . 'njt_fb_mess_sender_meta',
            array(
                'meta_key' => $meta_key,
                'meta_value' => $meta_value,
                'sender_id' => $sender_id
            )
        );
    }
}
function njt_get_sender_meta($sender_id, $meta_key, $default = null)
{
    global $wpdb;
    $check = $wpdb->get_results("SELECT `meta_value` FROM " . $wpdb->prefix . "njt_fb_mess_sender_meta WHERE `meta_key` = '".$meta_key."' AND `sender_id` = '".$sender_id."'");
    if (count($check) > 0) {
        return maybe_unserialize($check[0]->meta_value);
    } else {
        return $default;
    }
}
function njt_delete_sender_meta($sender_id, $meta_key)
{
    global $wpdb;
     $wpdb->delete($wpdb->prefix . 'njt_fb_mess_sender_meta', array('meta_key' => $meta_key, 'sender_id' => $sender_id));
}
function njt_bl_type()
{
    //1: manually
    //2: user unsubscribes
    //3: sent error
    return array(1, 2, 3);
}
function njt_senders_in_bl()
{
    global $wpdb;
    $ids_bl = array();
    $query = $wpdb->get_results("SELECT `sender_id` FROM ".$wpdb->prefix."njt_fb_mess_sender_meta WHERE `meta_key` = 'blacklist' AND `meta_value` IN (".implode(', ', njt_bl_type()).")");
    foreach ($query as $k => $v) {
        $ids_bl[] = $v->sender_id;
    }
    return $ids_bl;
}