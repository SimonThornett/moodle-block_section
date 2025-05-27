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
 * Section block restore task
 *
 * @package   block_section
 * @author    Simon Thornett <simon.thornett@catalyst-eu.net>
 * @copyright Catalyst IT, 2025
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class restore_section_block_task extends restore_block_task {

    /**
     * Define (add) particular settings that each block can have
     */
    protected function define_my_settings(): void {}

    /**
     * Define (add) particular steps that each block can have
     */
    protected function define_my_steps(): void {}

    /**
     * Define one array() of fileareas that each block controls
     */
    public function get_fileareas(): array {
        return [];
    }

    /**
     * Define special handling of configdata.
     */
    public function get_configdata_encoded_attributes(): array {
        return [];
    }

    /**
     * After the restore is complete update the config courseid to the new id.
     */
    public function after_restore(): void {
        global $DB;

        // Get the blockid.
        $blockid = $this->get_blockid();

        if ($configdata = $DB->get_field('block_instances', 'configdata', ['id' => $blockid])) {
            $config = $this->decode_configdata($configdata);
            if (!empty($config->course)) {
                // Update the course id.
                $config->course = $this->get_courseid();

                // Encode and save the config.
                $configdata = base64_encode(serialize($config));
                $DB->set_field('block_instances', 'configdata', $configdata, ['id' => $blockid]);
            }
        }
    }

    /**
     * Define the contents in the activity that must be
     * processed by the link decoder
     */
    public static function define_decode_contents() {
        return array();
    }

    /**
     * Define the decoding rules for links belonging
     * to the activity to be executed by the link decoder
     */
    public static function define_decode_rules() {
        return array();
    }
}
