<?php
/**
 * @package fi.kilonkipinat.events
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * @package fi.kilonkipinat.events
 */
class fi_kilonkipinat_events_event_dba extends __fi_kilonkipinat_events_event_dba
{
    static function &get_cached($src)
    {
        return $_MIDCOM->dbfactory->get_cached(__CLASS__, $src);
    }
}
?>