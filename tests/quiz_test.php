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
 * @package    block_misaka
 * @category   test
 * @copyright  2017 Takayuki Fuwa
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License
 */

defined('MOODLE_INTERNAL') || die();

global $CFG;

/**
 * @package    block_misaka
 * @category   test
 * @copyright  2017 Takayuki Fuwa
 * @license    http://www.gnu.org/copyleft/gpl.html GNU Public License
 */
class block_misaka_util_test_testcase extends advanced_testcase
{

    /**
     * Set up for every test
     */
    public function setUp()
    {
        global $DB;
        $this->resetAfterTest();
        $this->setAdminUser();

        // Setup test data.
        $this->course = $this->getDataGenerator()->create_course();

        // Create users.
        $this->student = self::getDataGenerator()->create_user();
        $this->teacher = self::getDataGenerator()->create_user();

        // Users enrolments.
        $this->studentrole = $DB->get_record('role', array('shortname' => 'student'));
        $this->teacherrole = $DB->get_record('role', array('shortname' => 'editingteacher'));
        $this->getDataGenerator()->enrol_user($this->student->id, $this->course->id, $this->studentrole->id, 'manual');
        $this->getDataGenerator()->enrol_user($this->teacher->id, $this->course->id, $this->teacherrole->id, 'manual');
    }

    /**
     * Test deleting a misaka instance.
     */
    public function test_block_misaka_get_rule_classes()
    {
        require_once '../classes/util.php';

        global $DB;
        $this->resetAfterTest(true);
        $this->setAdminUser();

        $files = \block_misaka\util::get_rule_classes();

        $expect = [
            'forum', 'greeting', 'message', 'quiz'
        ];

        $this->assertArraySubset($expect, $files);
    }
}