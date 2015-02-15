<?php

namespace block_misaka\rules;

use block_misaka\message;

define('COMPONENT', 'mod_quiz');

class quiz extends message{
    function __construct()
    {

    }

    public function get()
    {
        global $USER;

        $message = new \stdClass();

        $c = $this->count_action(COMPONENT, 'attempt');

        if($c != 0){
            $message->text = "あなたは最近、小テストに" . $c . "回挑戦しています。<br>";
            $c = \block_misaka\quiz::count_finished($USER->id);
            $message->text .= "そしてあなたは今まで" . $c . "回小テストを終わらせました！<br>";
            $message->text .= "その調子です！";
            $message->score = 1;
        }else{
            $message->text = null;
            $message->score = 0;
        }


        return $message;
    }


}