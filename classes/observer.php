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
 * Event observers supported by this module
 *
 * @package    local_silabos
 * @copyright  2017 PUCP Virtual
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

/**
 * Event observers supported by this module
 *
 * @package    local_silabos
 * @copyright  2017 PUCP Virtual
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_chat_observer {

    public static function course_created(\core\event\course_created $event) {
        global $DB, $USER;
        //$course = get_course($event->courseid);
        $context_course = context_course::instance($event->courseid);
        $objBlockInstanceExist = $DB->get_record('block_instances', ['parentcontextid' => $context_course->id], '*', IGNORE_MULTIPLE);
        //validamos si tiene un registro de usuario
        $objBlockInstance = $DB->get_record('block_instances', ['blockname' => 'chat', 'parentcontextid' => $context_course->id]);
        if (!is_object($objBlockInstance)) {
            //registramos el blocke
            $objBlockChatBean = new stdClass();
            $objBlockChatBean->blockname = 'chat';
            $objBlockChatBean->parentcontextid = $context_course->id;
            $objBlockChatBean->showinsubcontexts = 0;
            $objBlockChatBean->requiredbytheme = 0;
            $objBlockChatBean->pagetypepattern = 'course-view-*';
            $objBlockChatBean->subpagepattern = isset($objBlockInstanceExist->subpagepattern) ? $objBlockInstanceExist->subpagepattern : NULL;
            $objBlockChatBean->defaultregion = 'side-pre';
            $objBlockChatBean->defaultweight = 5;
            $objBlockChatBean->configdata = '';
            $objBlockChatBean->timecreated = time();
            $objBlockChatBean->timemodified = time();
            $DB->insert_record('block_instances', $objBlockChatBean);
        }
    }

}
