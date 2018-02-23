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
 * Online users block.
 *
 * @package    block_online_users
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use block_online_users\fetcher;

/**
 * This block needs to be reworked.
 * The new roles system does away with the concepts of rigid student and
 * teacher roles.
 */
class block_online_users extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_chat');
    }

    public function get_content() {
        global $PAGE, $CFG, $COURSE;
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = 'The content of our SimpleHTML block!';
        $this->content->footer = 'Footer here...';
        $this->chatPrintChat(true);
        $params = new stdClass();
        $params->chatAjaxUrl = "$CFG->wwwroot/local/chat/ajax.php";
        $params->chatTimer = 3000;	
        $params->chatCourseid = $COURSE->id;	
        $PAGE->requires->js_call_amd('local_chat/chat', 'init', array($params));
        return $this->content;
    }

    function chatPrintChat($display = false) {
        $output = '<div class="chat-btn" onclick="chat_open();"><i class="fa fa-comments-o"></i></div>';

        $output .= '<div class="chat-mainbox" style="display:none;">';
        $output .= '<div class="chat-inner">';
        $output .= '<div class="chat-header"><ul><li>' . get_string('chat_title', 'local_chat') . '</li></ul><i class="fa fa-times" onclick="chat_close();"></i></div>';
        $output .= '<div class="chat-content">';
        $output .= '<div class="chat-contacts open">';
        $output .= '<div class="nav-header-chat">';
        $output .= '<div class="user-name">' . get_string('chatlist', 'local_chat') . '</div>';
        $output .= '<span class="nav-header-type header-contacts">' . get_string('online_contacts', 'local_chat') . '</span>';
        $output .= '<i class="fa fa-ellipsis-h" onclick="chat_change_type();"></i>';
        $output .= '<div class="chat-types-box">';
        $output .= '<ul>';
        $output .= '<li onclick="chat_filter_users(\'online\');">' . get_string('online_contacts', 'local_chat') . '</li>';
        $output .= '<li onclick="chat_filter_users(\'resent\');">' . get_string('recently_contacted', 'local_chat') . '</li>';
        $output .= '</ul>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '<div class="chat-contacts-content">';
        $output .= '<ul class="chat-contacts-online active">';
        $output .= '<i class="fa fa-spin fa-spinner"></i>';
        $output .= '</ul>';
        $output .= '<ul class="chat-contacts-resent">';
        $output .= '<i class="fa fa-spin fa-spinner"></i>';
        $output .= '</ul>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '<div class="chat-messages">';
        $output .= '<div class="nav-header-chat">';
        $output .= '<i class="fa fa-angle-left" onclick="chat_close_conversation();" title="Back"></i>';
        $output .= '<div class="user-name"></div>';
        $output .= '<span class="nav-header-type header-conversation"></span>';
        $output .= '</div>';
        $output .= '<div class="chat-conversation" id="chat-conversation" user-id="0"></div>';
        $output .= '<div class="chat-form">';
        $output .= '<input type="text" name="message" value="" placeholder="' . get_string('say_something', 'local_chat') . '" id="message" />';
        $output .= '<i class="fa fa-paper-plane" title="Send message" onclick="chat_save_message();"></i>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';
        $output .= '</div>';

        if ($display) {
            echo $output;
        } else {
            return $output;
        }
    }

}
