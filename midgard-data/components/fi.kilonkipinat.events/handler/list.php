<?php
/**
 * @package net.nemein.calendar
 * @author The Midgard Project, http://www.midgard-project.org
 * @version $Id: list.php 26589 2010-08-06 07:34:16Z jval $
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * Calendar event lister
 *
 * @package net.nemein.calendar
 */
class fi_kilonkipinat_events_handler_list extends midcom_baseclasses_components_handler
{
    /**
     * Simple default constructor.
     */
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Internal helper, loads datamanager. Any error triggers a 500.
     *
     * @access private
     */
    function _load_datamanager()
    {
        $this->_datamanager = new midcom_helper_datamanager2_datamanager($this->_request_data['schemadb']);

        if (! $this->_datamanager)
        {
            $_MIDCOM->generate_error(MIDCOM_ERRCRIT, 'Failed to create a DM2 instance.');
            // This will exit.
        }
        $this->_request_data['datamanager'] =& $this->_datamanager;
    }


    /**
     * @param mixed $handler_id The ID of the handler.
     * @param Array $args The argument list.
     * @param Array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_between($handler_id, $args, &$data)
    {
        $this->_request_data['name']  = "fi.kilonkipinat.events";
        
        $_MIDCOM->set_pagetitle("{$this->_topic->extra}");

        $this->_load_datamanager();

        // Get the requested date range
        // TODO: Check format as YYYY-MM-DD via regexp
        $start = @strtotime($args[0]);
        $end = @strtotime($args[1]);
        if (   !$start
            || !$end)
        {
            // We couldn't generate the dates
            return false;
        }
        
        $qb_trips = fi_kilonkipinat_events_event_dba::new_query_builder();
        $qb_trips->add_constraint('topic', '=', $this->_topic->id);
        $qb_trips->add_constraint('type', '>=', FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GENERIC);
        $qb_trips->add_constraint('type', '<', FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_GENERIC);
        $qb_trips->add_constraint('start', '>=', date('Y-m-d H:i:s', $start));
        $qb_trips->add_constraint('start', '<', date('Y-m-d H:i:s', $end));
        if (!$_MIDGARD['user']) {
            $qb_trips->add_constraint('visibility', '=', FI_KILONKIPINAT_EVENTS_EVENT_VISIBILITY_PUBLIC);
        }
        $qb_trips->add_order('start');
        $trips = $qb_trips->execute();

        $qb_meetings = fi_kilonkipinat_events_event_dba::new_query_builder();
        $qb_meetings->add_constraint('topic', '=', $this->_topic->id);
        $qb_meetings->add_constraint('type', '>=', FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_GENERIC);
        $qb_meetings->add_constraint('type', '<', FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_ANNUAL);
        $qb_meetings->add_constraint('start', '>=', date('Y-m-d H:i:s', $start));
        $qb_meetings->add_constraint('start', '<', date('Y-m-d H:i:s', $end));
        if (!$_MIDGARD['user']) {
            $qb_meetings->add_constraint('visibility', '=', FI_KILONKIPINAT_EVENTS_EVENT_VISIBILITY_PUBLIC);
        }
        $qb_meetings->add_order('start');
        $meetings = $qb_meetings->execute();

        $this->_trips = $trips;
        $this->_meetings = $meetings;

        
        $breadcrumb[] = array
        (
            MIDCOM_NAV_URL => "/between/{$args[0]}/{$args[1]}/",
            MIDCOM_NAV_NAME => strftime('%x', $start) . ' - ' . strftime('%x', $end),
        );

        $_MIDCOM->set_custom_context_data('midcom.helper.nav.breadcrumb', $breadcrumb);

        return true;
    }

    /**
     *
     * @param mixed $handler_id The ID of the handler.
     * @param mixed &$data The local request data.
     */
    function _show_between($handler_id, &$data)
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
     * @param mixed $handler_id The ID of the handler.
     * @param Array $args The argument list.
     * @param Array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_upcoming($handler_id, $args, &$data)
    {
        $this->_request_data['name']  = "fi.kilonkipinat.events";
        $_MIDCOM->skip_page_style = true;
        
        $_MIDCOM->set_pagetitle("{$this->_topic->extra}");

        $this->_load_datamanager();
        
        $limit = 10;
        
        if (   isset($args[0])
            && (int)$args[0] > 0) {
            $limit = (int)$args[0];
        }

        // Get the requested date range
        // TODO: Check format as YYYY-MM-DD via regexp
        $start = time();
        
        $qb_events = fi_kilonkipinat_events_event_dba::new_query_builder();
        $qb_events->add_constraint('topic', '=', $this->_topic->id);
        if ($handler_id == 'upcoming_trips') {
            $qb_events->add_constraint('type', '>=', FI_KILONKIPINAT_EVENTS_EVENT_TYPE_GENERIC);
            $qb_events->add_constraint('type', '<', FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_GENERIC);
        } else {
            $qb_events->add_constraint('type', '>=', FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_GENERIC);
            $qb_events->add_constraint('type', '<', FI_KILONKIPINAT_EVENTS_EVENT_TYPE_MEETING_ANNUAL);
        }
        $qb_events->add_constraint('start', '>=', date('Y-m-d H:i:s', $start));
        if (!$_MIDGARD['user']) {
            $qb_events->add_constraint('visibility', '=', FI_KILONKIPINAT_EVENTS_EVENT_VISIBILITY_PUBLIC);
        }
        $qb_events->add_order('start');
        $qb_events->set_limit($limit);
        $events = $qb_events->execute();

        $this->_events = $events;

        return true;
    }

    /**
     *
     * @param mixed $handler_id The ID of the handler.
     * @param mixed &$data The local request data.
     */
    function _show_upcoming($handler_id, &$data)
    {
        if ($handler_id == 'upcoming_trips') {
            midcom_show_style('trips-header');
            foreach ($this->_events as $trip) {
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
        } else {
            midcom_show_style('meetings-header');
            foreach ($this->_events as $meeting) {
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
        }
    }
}
?>
