<?php

/**
 * オープンソース版MISAKAルール
 */

namespace block_misaka\rules;

defined('MOODLE_INTERNAL') || die();

class forum
{
    public function get()
    {
        $message = new \stdClass();

        $message->title = "フォーラム";
        $message->text = "こんにちは！";

        $this->message_text = $message->text;

        $message->score = 1;

        return $message;
    }
}