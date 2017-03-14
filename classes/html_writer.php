<?php
namespace block_misaka;

defined('MOODLE_INTERNAL') || die();

class html_writer extends \html_writer
{
    public static function emotion_smile()
    {
        global $CFG;
        return html_writer::empty_tag('img', ['src' => new \moodle_url($CFG->wwwroot . '/blocks/misaka/images/srm02.jpg'),
            'class' => 'img-circle', 'data-toggle' => 'modal']);
    }

    public static function emotion_normal()
    {
        global $CFG;
        return html_writer::empty_tag('img', ['src' => new \moodle_url($CFG->wwwroot . 'blocks/misaka/images/srm01.jpg'),
            'class' => 'img-circle', 'data-toggle' => 'modal']);
    }

    public static function emotion_sad()
    {
        global $CFG;
        return html_writer::empty_tag('img', ['src' => new \moodle_url($CFG->wwwroot . 'blocks/misaka/images/srm05.jpg'),
            'class' => 'img-circle', 'data-toggle' => 'modal']);
    }

    public static function card($message)
    {
        $html = html_writer::start_div('popover bottom show', ['style' => 'position:relative; max-width:100%;']);
        $html .= html_writer::tag('h3', $message->title, ['class' => 'popover-title']);
        $html .= html_writer::start_div('popover-content');
        $html .= html_writer::tag('p', $message->text);
        $html .= html_writer::end_div();
        $html .= html_writer::end_div();

        return $html;
    }
}