<?php

/**
 * オープンソース版MISAKAルール
 */

namespace block_misaka\rules;

defined('MOODLE_INTERNAL') || die();

class message
{
    public function get()
    {
        $message = new \stdClass();

        $message->title = "メッセージ";
        $message->text = "こんにちは！";

        $this->message_text = $message->text;

        $message->score = 1;

        return $message;
    }
}