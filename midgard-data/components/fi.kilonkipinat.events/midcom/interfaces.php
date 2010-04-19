<?php
/**
 * @package fi.kilonkipinat.events 
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is the interface class for fi.kilonkipinat.events
 * 
 * @package fi.kilonkipinat.events
 */
class fi_kilonkipinat_events_interface extends midcom_baseclasses_components_interface
{
    /**
     * Constructor, define component name
     */
    function __construct()
    {
        parent::__construct();
        $this->_component = 'fi.kilonkipinat.events';
    }

    function _on_initialize()
    {
        $this->define_constants();

        return true;
    }
    
    private function define_constants()
    {
        // Type definitions for events
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GENERIC', 1000);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_TRIP', 1010);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_CAMP', 1020);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_COURSE', 1030);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_CONTEST', 1040);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_EXAM', 1050);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_HIKE', 1060);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_GENERIC', 1200);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_JN', 1210);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_LH', 1220);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_BOARD', 1230);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_ANNUAL', 1240);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GROUP_MEETING_GENERIC', 1500);
    }
}
?>