<?php
namespace block_misaka;

defined('MOODLE_INTERNAL') || die();

class util
{
    public static function get_rule_classes()
    {
        global $CFG;

        $files = [];
        foreach (glob(__DIR__ . '/rules/{*.php}', GLOB_BRACE) as $file) {
            if (is_file($file)) {
                $tmp_array = explode("/", $file);
                $tmp_num =  count($tmp_array) - 1;
                $files[] = str_replace(".php", "", $tmp_array[$tmp_num]);
            }
        }
        return $files;
    }
}