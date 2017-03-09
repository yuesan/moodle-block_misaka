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
class block_misaka_rules_forum_testcase extends advanced_testcase
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

    public function test_rules_forum_get_content()
    {
        require_once "../classes/rules/forum.php";

        global $SITE, $DB;
        $this->resetAfterTest(true);

        $this->setUser($this->student);

        $ruleObj = new \block_misaka\rules\forum();
        $message = $ruleObj->get();

        $this->assertNotEmpty($message->title);
        $this->assertEquals("フォーラム", $message->title);
        $this->assertNotEmpty($message->text);
    }
}