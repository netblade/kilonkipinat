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
        $this->_autoload_files = array
        (
            'functions.php',
        );
        $this->_autoload_libraries = array
        (
            'midcom.helper.datamanager2',
            'org.routamc.positioning',
        );
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
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GROUP_MEETING_KOLKKA', 1510);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GROUP_MEETING_VARTIO', 1520);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GROUP_MEETING_VAELTAJA', 1530);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GROUP_MEETING_SP_GENERIC', 1600);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GROUP_MEETING_SP_KOLKKA', 1610);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GROUP_MEETING_SP_SEIKKAILIJA', 1620);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GROUP_MEETING_SP_TARPOJA', 1630);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GROUP_MEETING_SP_SAMOAJA', 1640);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GROUP_MEETING_SP_VAELTAJA', 1650);
        define('FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GROUP_MEETING_SP_AIKUINEN', 1660);
        
        define('FI_KILONKIPINAT_EVENTS_EVENT_STATUS_DRAFT', 1000);
        define('FI_KILONKIPINAT_EVENTS_EVENT_STATUS_READY', 1100);
        
        define('FI_KILONKIPINAT_EVENTS_EVENT_VISIBILITY_PUBLIC', 1000);
        define('FI_KILONKIPINAT_EVENTS_EVENT_VISIBILITY_SECURE', 1100);
        
        define('FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_PUBLIC', 1000);
        define('FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_TEXT_PUBLIC', 1100);
        define('FI_KILONKIPINAT_EVENTS_EVENT_LOCATION_VISIBILITY_SECURE', 1200);
    }
    /**
     * Simple lookup method which tries to map the guid to an article of out topic.
     */
    function _on_resolve_permalink($topic, $config, $guid)
    {    
        $event = new fi_kilonkipinat_events_event_dba($guid);
        if (!$event)
        {
            return null;
        }
        
        if ($event->topic != $topic->id)
        {
            return null;
        }
        
        return "view_event/{$event->guid}/";
    }
}
?>