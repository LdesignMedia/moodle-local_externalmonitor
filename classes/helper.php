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
 *
 *
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @package   moodle-local_externalmonitor
 * @copyright 24/06/2021 Mfreak.nl | LdesignMedia.nl - Luuk Verhoeven
 * @author    Luuk Verhoeven
 **/

namespace local_externalmonitor;

use DirectoryIterator;

defined('MOODLE_INTERNAL') || die;

/**
 * Class helper
 *
 * @package local_externalmonitor
 */
class  helper {

    /**
     * Replay request to get response.
     *
     * @param string $location
     * @param bool $rawdata
     *
     * @return array
     */
    public static function replay(string $location, $rawdata = false): array {

        if (!empty($_GET)) {
            $location .= '?' . http_build_query($_GET, '', '&');
        }

        $ch = curl_init($location);

        // Disable ssl check.
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_REFERER, 'local_externalmonitor');

        $contenttype = $_SERVER["CONTENT_TYPE"] ?? '';
        if ($contenttype) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: $contenttype"]);
        }

        if (!empty($rawdata)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $rawdata);
        }

        $output = curl_exec($ch);

        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        $curl_info = curl_getinfo($ch);

        curl_close($ch);

        return [
            'output' => $output,
            'http_status' => $http_status,
            'curl_errno' => $curl_errno,
            'curl_error' => $curl_error,
            'curl_info' => $curl_info,
        ];

    }

    /**
     * @return string
     */
    public static function get_logfile_from_today(): string {
        $dir = make_temp_directory('local_externalmonitor');

        return $dir . '/' . date('Y-m-d') . '.log';
    }

    /**
     * Log
     *
     * @param string $lines
     */
    public static function log(string $lines): void {
        $file = self::get_logfile_from_today();

        if (!file_exists($file)) {
            self::cleanup();
        }

        error_log(PHP_EOL . $lines, 3, $file);
    }

    /**
     * Remove old files in log directory
     */
    protected static function cleanup(): void {
        // New day remove previous other.
        $dir = make_temp_directory('local_externalmonitor');
        foreach (new DirectoryIterator($dir) as $fileInfo) {
            if (!$fileInfo->isDot()) {
                unlink($fileInfo->getPathname());
            }
        }
    }

}