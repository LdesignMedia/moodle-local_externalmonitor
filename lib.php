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
 * Lib functions.
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   moodle-local_externalmonitor
 * @copyright 24/06/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

/**
 * Hook to monitor incoming on externallib.php.
 */
function local_externalmonitor_after_config() {
    global $PAGE, $CFG;

    if ($_SERVER['PHP_SELF'] !== '/webservice/rest/server.php' ||
        (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] === 'local_externalmonitor')) {
        return;
    }

    // Get input and log.
    $rawinput = file_get_contents("php://input");
    \local_externalmonitor\helper::log(
        date('H:i:s') . ' Request ' . PHP_EOL .
        PHP_EOL . 'Method: ' . $_SERVER['REQUEST_METHOD'] .
        PHP_EOL . 'User Agent: ' . $_SERVER['HTTP_USER_AGENT'] .
        PHP_EOL . 'Request: ' . $PAGE->url->get_path() .
        PHP_EOL . 'GET: ' .
        PHP_EOL . print_r($_GET, true) .
        PHP_EOL . 'BODY POST/RAW:' .
        PHP_EOL . $rawinput .
        PHP_EOL . '-----' .
        PHP_EOL
    );

    // Resend the request to capture the output.
    $response = \local_externalmonitor\helper::replay($CFG->wwwroot . $PAGE->url->get_path(), $rawinput);

    $info = $response['curl_info'];
    \local_externalmonitor\helper::log(

        date('H:i:s') . ' Response ' . PHP_EOL .
        PHP_EOL .
        'Response code: ' . $response['http_status'] .
        PHP_EOL . 'Total time: ' . $info['total_time'] .
        PHP_EOL . 'Primary ip: ' . $info['primary_ip'] .
        PHP_EOL . 'Header size: ' . $info['header_size'] .
        PHP_EOL . 'Request size: ' . $info['request_size'] .
        PHP_EOL .
        PHP_EOL . 'Response body: ' .
        PHP_EOL . print_r($response['output'], true) .
        PHP_EOL .
        PHP_EOL . str_repeat('--', 30)
    );

    die($response['output']);
}
