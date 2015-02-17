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
        global $USER, $CFG;

        $message = new \stdClass();

        $c = $this->count_action(COMPONENT, 'attempt');

        if($c != 0){
            $message->text = "<p>あなたは最近、小テストに" . $c . "回挑戦しています。</p>";
            $c = \block_misaka\quiz::count_finished($USER->id);
            if($c == 0){
                $message->text .= "<p>けど最近は小テストを受験していないようですね・・・</p>";

                $quiz = $this->get_finished();

                if($quiz){
                    $message->text .= "過去に受験した小テストをふりかえってみましょう！<br>";
                    $message->text .= \html_writer::link(new \moodle_url('mod/quiz/view.php', ['id' => $quiz->id]), '小テストをふりかえり', ['btn btn-success']);
                    $message->score = 0;
                }else{
                    $message->text .= "";
                    $message->score = 0;
                }
            }else{
                $message->text .= "そしてあなたは今まで" . $c . "回小テストを終わらせました！<br>";
                $message->text .= "その調子です！<br>";
                $message->text .= \html_writer::empty_tag('image', ['src' => new \moodle_url($CFG->wwwroot . '/blocks/misaka/images/quiz/stump01-002.gif')]);
                $message->score = 1;
            }
        }else{
            $message->text = null;
            $message->score = 0;
        }

        return $message;
    }

    private function get_finished()
    {
        global $USER;

        $quiz_obj = new \block_misaka\quiz();

        $quiz = $quiz_obj->recent_finished($USER->id);

        return array_rand($quiz);
    }
}