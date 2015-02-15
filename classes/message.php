<?php

namespace block_misaka;

use block_misaka\rules\greeting;
use block_misaka\rules\quiz;

defined('MOODLE_INTERNAL') || die();

class message
{
    function __construct($context){
        $this->context = $context;
    }

    function generate(){
        $message_text = "";
        $messages = [];

        $greeting_obj = new greeting();
        $messages[] = $greeting_obj->get();

        $quiz_obj = new quiz();
        $messages[] = $quiz_obj->get();

        foreach($messages as $message){
            $message_text .= $message->text . '<hr>';
        }

        return $message_text;
    }

    function count_action($component, $target)
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