<?php

namespace block_misaka\rules;

use block_misaka\message;

class greeting extends message{
    function __construct()
    {

    }

    public function get()
    {
        global $DB, $USER;

        $message = new \stdClass();

        $count_login = $DB->count_records_sql(
            "SELECT COUNT('id') FROM {logstore_standard_log}
              WHERE userid = :userid AND timecreated > (UNIX_TIMESTAMP(NOW()) - 259200) AND action = 'loggedin';
             "
            , ['userid' => $USER->id]
        );

        if($count_login == 0){
            $message->text = "おひさしぶりです！<hr>";
        }else{
            $message->text = "こんにちは！" . "最近3日間で" . $count_login . '回お会いしましたね！';
        }

        $message->type = 1;

        return $message;
    }
}