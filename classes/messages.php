<?php
namespace block_misaka;

defined('MOODLE_INTERNAL') || die();

class messages
{
    public $message_text;

    function __construct($context)
    {
        $this->context = $context;
    }

    function gets()
    {
        global $USER;
        $messages = [];

        if ($USER->id == 0) {
            $message = new \stdClass();
            $message->score = 0;
            $message_text = null;

            return $message;
        }

        $rules = util::get_rule_classes();
        foreach ($rules as $rule) {
            $rule_classname = "\\block_misaka\\rules\\" . $rule;
            $rule_obj = new $rule_classname($this->context);
            $messages[] = $rule_obj->get();
        }

        return $messages;
    }

}