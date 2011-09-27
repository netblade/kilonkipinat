<?php
/**
 * @package fi.kilonkipinat.events
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is a URL handler class for fi.kilonkipinat.events
 *
 * The midcom_baseclasses_components_handler class defines a bunch of helper vars
 *
 * @see midcom_baseclasses_components_handler
 * @see: http://www.midgard-project.org/api-docs/midcom/dev/midcom.baseclasses/midcom_baseclasses_components_handler/
 * 
 * @package fi.kilonkipinat.events
 */
class fi_kilonkipinat_events_handler_index extends midcom_baseclasses_components_handler
{

    /**
     * Simple default constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * _on_initialize is called by midcom on creation of the handler.
     */
    function _on_initialize()
    {
    }

    /**
     * The handler for the index event.
     *
     * @param mixed $handler_id the array key from the request array
     * @param array $args the arguments given to the handler
     * @param Array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_index($handler_id, $args, &$data)
    {
        $this->_request_data['name']  = "fi.kilonkipinat.events";

        $this->_update_breadcrumb_line($handler_id);
        $kisa_config = 0;
        if (isset($this->_config->get('kisa')) && $this->_config->get('kisa') != 0) {
            
            $kisa_config = $this->_config->get('kisa');
        }
        
        $_MIDCOM->set_pagetitle("{$this->_topic->extra}");
        
        $qb_trips = fi_kilonkipinat_events_event_dba::new_query_builder();
        $qb_trips->add_constraint('topic', '=', $this->_topic->id);
        $qb_trips->add_constraint('type', '>=', FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GENERIC);
        $qb_trips->add_constraint('type', '<', FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_GENERIC);
        if ($kisa_config == 0) {
            $qb_trips->add_constraint('kisa', '<=', FI_KILONKIPINAT_EVENTS_EVENT_KISA_BOTH);
        }
        elseif ($kisa_config == 1) {
            $qb_trips->add_constraint('kisa', '<', FI_KILONKIPINAT_EVENTS_EVENT_KISA_BOTH);
        }
        elseif ($kisa_config == 2) {
            $qb_trips->add_constraint('kisa', '=>', FI_KILONKIPINAT_EVENTS_EVENT_KISA_BOTH);
        }
        elseif ($kisa_config == 3) {
            $qb_trips->add_constraint('kisa', '>', FI_KILONKIPINAT_EVENTS_EVENT_KISA_BOTH);
        }
        $qb_trips->add_constraint('end', '>', date('Y-m-d H:i:s', time()));
        $qb_trips->add_order('start');
        if (!$_MIDGARD['user']) {
            $qb_trips->add_constraint('visibility', '=', FI_KILONKIPINAT_EVENTS_EVENT_VISIBILITY_PUBLIC);
        }
        $trips = $qb_trips->execute();

        $qb_meetings = fi_kilonkipinat_events_event_dba::new_query_builder();
        $qb_meetings->add_constraint('topic', '=', $this->_topic->id);
        $qb_meetings->add_constraint('type', '>=', FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_GENERIC);
        $qb_meetings->add_constraint('type', '<=', FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_ANNUAL);
        if ($qb_meetings == 0) {
            $qb_trips->add_constraint('kisa', '<=', FI_KILONKIPINAT_EVENTS_EVENT_KISA_BOTH);
        }
        elseif ($qb_meetings == 1) {
            $qb_trips->add_constraint('kisa', '<', FI_KILONKIPINAT_EVENTS_EVENT_KISA_BOTH);
        }
        elseif ($qb_meetings == 2) {
            $qb_trips->add_constraint('kisa', '=>', FI_KILONKIPINAT_EVENTS_EVENT_KISA_BOTH);
        }
        elseif ($qb_meetings == 3) {
            $qb_trips->add_constraint('kisa', '>', FI_KILONKIPINAT_EVENTS_EVENT_KISA_BOTH);
        }
        $qb_meetings->add_constraint('end', '>', date('Y-m-d H:i:s', time()));
        $qb_meetings->add_order('start');
        if (!$_MIDGARD['user']) {
            $qb_meetings->add_constraint('visibility', '=', FI_KILONKIPINAT_EVENTS_EVENT_VISIBILITY_PUBLIC);
        }
        $meetings = $qb_meetings->execute();

        $this->_trips = $trips;
        $this->_meetings = $meetings;

        return true;
    }

    /**
     * This function does the output.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param mixed &$data The local request data.
     */
    function _show_index($handler_id, &$data)
    {
        midcom_show_style('events-header');
        midcom_show_style('index-header');
        midcom_show_style('trips-header');
        foreach ($this->_trips as $trip) {
            if (! $this->_request_data['datamanager']->autoset_storage($trip))
            {
                debug_push_class(__CLASS__, __FUNCTION__);
                debug_add("The datamanager for trip {$trip->id} could not be initialized, skipping it.");
                debug_print_r('Object was:', $trip);
                debug_pop();
                continue;
            }
            $this->_request_data['view_trip'] = $data['datamanager']->get_content_html();
            $this->_request_data['trip'] = $trip;
            midcom_show_style('trips-item');
        }
        midcom_show_style('trips-footer');
        midcom_show_style('meetings-header');
        foreach ($this->_meetings as $meeting) {
            if (! $this->_request_data['datamanager']->autoset_storage($meeting))
            {
                debug_push_class(__CLASS__, __FUNCTION__);
                debug_add("The datamanager for meeting {$meeting->id} could not be initialized, skipping it.");
                debug_print_r('Object was:', $trip);
                debug_pop();
                continue;
            }
            $this->_request_data['view_meeting'] = $data['datamanager']->get_content_html();
            $this->_request_data['meeting'] = $meeting;
            midcom_show_style('meetings-item');
        }
        midcom_show_style('meetings-footer');
        midcom_show_style('index-footer');
        midcom_show_style('events-footer');
    }

    /**
     * Helper, updates the context so that we get a complete breadcrumb line towards the current
     * location.
     *
     */
    function _update_breadcrumb_line()
    {
        $tmp = Array();

        $tmp[] = Array
        (
            MIDCOM_NAV_URL => "/",
            MIDCOM_NAV_NAME => $this->_l10n->get('index'),
        );

        $_MIDCOM->set_custom_context_data('midcom.helper.nav.breadcrumb', $tmp);
    }
}
?>