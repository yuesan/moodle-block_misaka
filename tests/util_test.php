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
class block_misaka_quiz_testcase extends advanced_testcase
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
     * Test deleting a sharedpanel instance.
     */
    public function test_block_misaka_quiz()
    {
        require_once '../classes/quiz.php';

        global $DB, $SITE;
        $this->resetAfterTest(true);
        $this->setAdminUser();

        // Setup a quiz with 1 standard and 1 random question.
        $quizgenerator = $this->getDataGenerator()->get_plugin_generator('mod_quiz');
        $quiz = $quizgenerator->create_instance(array('course' => $SITE->id, 'questionsperpage' => 3, 'grade' => 100.0));

        $questiongenerator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $questiongenerator->create_question_category();
        $standardq = $questiongenerator->create_question('shortanswer', null, array('category' => $cat->id));

        quiz_add_quiz_question($standardq->id, $quiz);
        quiz_add_random_questions($quiz, 0, $cat->id, 1, false);

        $m_quiz = \block_misaka\quiz::quiz($quiz->id);

        $this->assertEquals($m_quiz->id, $quiz->id);
        $this->assertEquals($SITE->id, $m_quiz->course);
        $this->assertEquals(3, $m_quiz->questionsperpage);
        $this->assertEquals(100.0, $m_quiz->grade);
    }
}