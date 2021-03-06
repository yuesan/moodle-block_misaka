<?php

/**
 * オープンソース版MISAKAルール
 */

namespace block_misaka\rules;

defined('MOODLE_INTERNAL') || die();

class greeting
{
    public function get()
    {
        global $DB, $USER;
        $message = new \stdClass();

        $message->title = "今日のアドバイス！";
        $count_login = $DB->count_records_sql(
            "SELECT COUNT('id') FROM {logstore_standard_log}
              WHERE userid = :userid AND timecreated > (UNIX_TIMESTAMP(NOW()) - 259200) AND action = 'loggedin';
             "
            , ['userid' => $USER->id]
        );

        if ($count_login == 0) {
            $message->text = "おひさしぶりです！最近お会いしていなかったので、うれしいです！";
        } else {
            $message->text = "こんにちは！" . "最近3日間で" . $count_login . '回お会いしましたね！';
        }

        $this->message_text = $message->text;

        $message->score = 1;

        return $message;
    }
}