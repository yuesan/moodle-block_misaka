<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * misaka block caps.
 *
 * @package    block_misaka
 * @copyright  Takayuki Fuwa <yue@misakalabs.jp>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_misaka extends block_base
{

    function init()
    {
        $this->title = get_string('pluginname', 'block_misaka');
    }

    function get_content()
    {
        global $USER, $CFG, $PAGE;

        if (empty($this->instance)) {
            $this->content = '';

            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->items = [];
        $this->content->icons = [];
        $this->content->footer = '';

        $courseid = $this->page->course->id;
        $context = context_course::instance($courseid);

        try {
            $message_obj = new \block_misaka\message($context);
            $message = $message_obj->generate();

            $html = html_writer::start_div('', ['style' => 'text-align:center;', 'id' => 'misaka_shiromu']);
            if ($message->score >= 1) {
                $html .= html_writer::empty_tag('img', ['src' => new moodle_url('blocks/misaka/images/srm02.jpg'), 'class' => 'img-circle', 'data-toggle' => 'modal']);
            }elseif($message->score == 0){
                $html .= html_writer::empty_tag('img', ['src' => new moodle_url('blocks/misaka/images/srm01.jpg'), 'class' => 'img-circle', 'data-toggle' => 'modal']);
            } else {
                $html .= html_writer::empty_tag('img', ['src' => new moodle_url('blocks/misaka/images/srm05.jpg'), 'class' => 'img-circle', 'data-toggle' => 'modal']);
            }
            $html .= html_writer::end_div();

            $html .= html_writer::start_div('popover bottom show', ['style' => 'position:relative; max-width:100%;']);

            $html .= html_writer::start_div('arrow');
            $html .= html_writer::end_div();

            if ($USER->id == 0) {
                $html .= html_writer::tag('h3', 'こんにちは！', ['class' => 'popover-title']);
                $html .= html_writer::start_div('popover-content');
                $html .= html_writer::tag('p', 'ログインすると、私があなたをサポートします！');
            } else {
                $html .= html_writer::tag('h3', '今日のアドバイス！', ['class' => 'popover-title']);
                $html .= html_writer::start_div('popover-content');
                $html .= html_writer::tag('p', $message->text);
                $html .= html_writer::start_tag('blockquote');
                $html .= html_writer::div('', '', ['id' => 'misaka_speech_area']);
                $html .= html_writer::end_tag('blockquote');

                $PAGE->requires->jquery();
                $PAGE->requires->js(new moodle_url($CFG->wwwroot . '/blocks/misaka/js/bootstrap.min.js'));
                $PAGE->requires->js(new moodle_url($CFG->wwwroot . '/blocks/misaka/js/speech.js'));
            }

            $html .= html_writer::end_div();
            $html .= html_writer::end_div();

            $html .= html_writer::start_div('modal hide fade', ['id' => 'speech_modal', 'tabindex' => '-1', 'role' => 'dialog', 'aria-hidden' => 'true', 'aria-labelledby' => 'speech_modal_header']);
            $html .= html_writer::start_div('modal-header', ['id' => 'speech_modal_header']);
            $html .= html_writer::tag('button', '&times;', ['class' => 'close', 'type' => 'button', 'data-dismiss' => 'modal', 'aria-hidden' => 'true']);
            $html .= html_writer::tag('h3', 'お話しください');
            $html .= html_writer::end_div();
            $html .= html_writer::start_div('modal-body', ['style' => 'text-align:center;']);
            $html .= html_writer::empty_tag('img', ['src' => new moodle_url('blocks/misaka/images/srm01.jpg'), 'class' => 'img-circle', 'data-toggle' => 'modal']);
            $html .= html_writer::tag('h5', 'ブラウザ上部の「許可」ボタンをクリックして、マイクに向かってお話しください。');
            $html .= html_writer::end_div();
            $html .= html_writer::start_div('modal-footer');
            $html .= html_writer::link(new moodle_url('#'), '終了', ['class' => 'btn', 'id' => 'speech_finish_btn']);
            $html .= html_writer::end_div();
            $html .= html_writer::end_div();

            return $this->content = (object)['text' => $html];

        } catch (Exception $e) {
            $html = "Misakaの起動に失敗しました。";
            return $this->content = (object)['text' => $html];
        }
    }

    // my moodle can only have SITEID and it's redundant here, so take it away
    public function applicable_formats()
    {
        return array('all' => false,
            'site' => true,
            'site-index' => true,
            'course-view' => true,
            'course-view-social' => false,
            'mod' => true,
            'mod-quiz' => false);
    }

    public function instance_allow_multiple()
    {
        return true;
    }

    function has_config()
    {
        return false;
    }

    public function cron()
    {
        mtrace("Hey, my cron script is running");

        // do something

        return true;
    }
}
