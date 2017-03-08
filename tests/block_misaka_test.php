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
 * Unit tests for (some of) mod/quiz/locallib.php.
 *
 * @package    mod_sharedpanel
 * @category   test
 * @copyright  2016 NAGAOKA Chikako, KITA Toshihiro
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->dirroot . '/mod/sharedpanel/lib.php');

/**
 * @copyright  2017 Takayuki Fuwa
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License
 */
class block_misaka_test_testcase extends advanced_testcase
{

    /**
     * Test deleting a sharedpanel instance.
     */
    public function test_block_misaka_delete_instance()
    {
        global $DB;
        $this->resetAfterTest(true);
        $this->setAdminUser();

        $beforeblocks = $DB->count_records('block_instances');

        $generator = $this->getDataGenerator()->get_plugin_generator('block_misaka');

        $this->assertInstanceOf('block_misaka_generator', $generator);
        $this->assertEquals('misaka', $generator->get_blockname());

        $generator->create_instance();
        $generator->create_instance();
        $this->assertEquals($beforeblocks + 3, $DB->count_records('block_instances'));
    }

    public function test_get_content()
    {

    }
}