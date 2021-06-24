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
 * Get logs files and view the content
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   moodle-local_externalmonitor
 * @copyright 24/06/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

require_once(__DIR__ . '/../../../config.php');
require_login();

$context = context_system::instance();
$action = optional_param('action', false, PARAM_TEXT);
$id = optional_param('id', false, PARAM_INT);

$PAGE->set_url('/local/externalmonitor/view/logs.php', [
    'action' => $action,
    'id' => $id,
]);

$PAGE->set_context($context);
$PAGE->set_title(get_string('heading:logs', 'local_externalmonitor'));
$PAGE->set_heading(get_string('heading:logs', 'local_externalmonitor'));

require_capability('local/externalmonitor:logs', $context);

// Get current params.

switch ($action){
    default:
        $contents = @file_get_contents(\local_externalmonitor\helper::get_logfile_from_today());

        header("Content-Type: text/plain");
        echo $contents;
        
        break;
}