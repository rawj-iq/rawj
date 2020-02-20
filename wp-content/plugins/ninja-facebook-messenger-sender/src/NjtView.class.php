<?php
if (!defined('ABSPATH')) {
    exit;
}
class NjtFbMessView
{
    protected static $dir = '';
    protected static $view_root_folder = '';

    public function __construct()
    {
        
    }
    public static function load($path, $args = array())
    {
        self::setDefaultValues();

        if (count($args) > 0) {
            extract($args);
        }
        $path = self::$dir . '/' . self::$view_root_folder . '/' . str_replace('.', '/', $path) . '.php';
        ob_start();
        require $path;
        return ob_get_clean();
    }
    protected static function setDefaultValues()
    {
        self::$dir = NJT_FB_MESS_DIR;
        self::$view_root_folder = 'views';
    }
}
