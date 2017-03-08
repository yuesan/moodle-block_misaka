<?php
namespace block_misaka;

defined('MOODLE_INTERNAL') || die();

class util
{
    public static function get_rule_classes()
    {
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


    public static function count_action($component, $target)
    {
        global $DB, $USER;
        $count_login = $DB->count_records_sql(
            "SELECT COUNT('id') FROM {logstore_standard_log}
              WHERE userid = :userid
                AND timecreated > (UNIX_TIMESTAMP(NOW()) - 259200)
                AND component = :component
                AND target = :target;
             "
            , ['userid' => $USER->id, 'component' => $component, 'target' => $target]
        );
        return $count_login;
    }
}