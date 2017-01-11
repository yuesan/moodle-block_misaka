<?php
namespace block_misaka;

defined('MOODLE_INTERNAL') || die();

class html_writer extends \html_writer
{
    public static function emotion_smile()
    {
        return html_writer::empty_tag('img', ['src' => new \moodle_url('blocks/misaka/images/srm02.jpg'),
            'class' => 'img-circle', 'data-toggle' => 'modal']);
    }

    public static function emotion_normal()
    {
        return html_writer::empty_tag('img', ['src' => new \moodle_url('blocks/misaka/images/srm01.jpg'),
            'class' => 'img-circle', 'data-toggle' => 'modal']);
    }

    public static function emotion_sad()
    {
        return html_writer::empty_tag('img', ['src' => new \moodle_url('blocks/misaka/images/srm05.jpg'),
            'class' => 'img-circle', 'data-toggle' => 'modal']);
    }
}