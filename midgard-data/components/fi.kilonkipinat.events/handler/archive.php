<?php
/**
 * @package net.nemein.calendar
 * @author The Midgard Project, http://www.midgard-project.org
 * @version $Id: archive.php 19707 2008-12-11 13:42:24Z bergie $
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/** @ignore */
require_once('Calendar/Year.php');
/** @ignore */
require_once('Calendar/Month.php');
/** @ignore */
require_once('Calendar/Factory.php');
/** @ignore */
require_once('Calendar/Decorator/Textual.php');

/**
 * Calendar Archive pages handler.
 *
 * Shows a monthly archive index using the between method to display the months.
 * Note, that the code is optimized to not use any TREE methods when querying
 * events (since there are plenty of queries run until the index is complete). Instead,
 * in case of a list_from_master topic, the immediate subevents of the master event
 * are queried once and then reused. This archive does <i>not</i> support event
 * hierarchies any deeper then this one level.
 *
 * <b>Requirements:</b>
 *
 * - PEAR Calendar
 *
 * @package net.nemein.calendar
 */
class fi_kilonkipinat_events_handler_archive extends midcom_baseclasses_components_handler
{
    /**
     * Simple helper which references all important members to the request data listing
     * for usage within the style listing.
     */
    function _prepare_request_data()
    {
    }

    /**
     * Simple default constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Shows the archive welcome page: A listing of years/months along with total post counts
     * and similar stuff.
     *
     * The handler computes all necessary data and populates the request array accordingly.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param Array $args The argument list.
     * @param Array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_welcome ($handler_id, $args, &$data)
    {
        setlocale(LC_ALL, 'fi_FI');
        $this->_compute_welcome_data();
        $_MIDCOM->set_26_request_metadata($this->get_last_modified(), $this->_topic->guid);

        $this->_component_data['active_leaf'] = "{$this->_topic->id}_ARCHIVE";

        return true;
    }

    /**
     * Loads the first event time from the DB. This is the base for all operations on the
     * resultset.
     *
     * This is done under sudo if possible, to avoid problems arising if the first posting
     * is hidden.
     *
     * This call will put the event on which the first month is based into the request key
     * 'first_event'.
     *
     * @return Calendar_Month The month of the first event or null on failure.
     * @access private
     */
    function _compute_first_month()
    {
        if ($this->_config->get('list_from_master'))
        {
            $result = fi_kilonkipinat_events_compute_first_event($this->_request_data['master_event_obj']);
        }
        else
        {
            $result = fi_kilonkipinat_events_compute_first_event($this->_request_data['content_topic']);
        }

        if ($result)
        {
            $this->_request_data['first_event'] = $result;
            return Calendar_Factory::createByTimestamp('Month', strtotime($result->start));
        }
        else
        {
            $this->_request_data['first_event'] = null;
            return null;
        }
    }


    /**
     * Loads the last event (end) time from the DB. This is the base for all operations on the
     * resultset.
     *
     * This is done under sudo if possible, to avoid problems arising if the last posting
     * is hidden. This keeps up performance, as an execute_unchecked() can be made in this case.
     * If sudo cannot be acquired, the system falls back to excute().
     *
     * This call will put the event on which the last month is based into the request key
     * 'last_event'.
     *
     * @return Calendar_Month The month of the last event or null on failure.
     * @access private
     */
    function _compute_last_month()
    {
        if ($this->_config->get('list_from_master'))
        {
            $result = fi_kilonkipinat_events_compute_last_event($this->_request_data['master_event_obj']);
        }
        else
        {
            $result = fi_kilonkipinat_events_compute_last_event($this->_request_data['content_topic']);
        }

        if ($result)
        {
            $this->_request_data['last_event'] = $result;
            return Calendar_Factory::createByTimestamp('Month', strtotime($result->end));
        }
        else
        {
            $this->_request_data['last_event'] = null;
            return Calendar_Factory::createByTimestamp('Month', time()+1);
        }
    }

    /**
     * Computes the last modified timestamp of the entire event tree.
     *
     * This is done under sudo if possible, to avoid problems arising if the last posting
     * is hidden. This keeps up performance, as an execute_unchecked() can be made in this case.
     * If sudo cannot be acquired, the system falls back to excute().
     *
     * @return int Last Modified timestamp
     */
    function get_last_modified()
    {
        // Get the pre-filtered QB
        $qb = fi_kilonkipinat_events_viewer::prepare_event_qb($this->_request_data, $this->_config);

        $qb->add_order('metadata.revised', 'DESC');
        $qb->set_limit(1);

        if ($_MIDCOM->auth->request_sudo())
        {
            $result = $qb->execute_unchecked();
            $_MIDCOM->auth->drop_sudo();
        }
        else
        {
            $result = $qb->execute();
        }

        if (! $result)
        {
            return time();
        }
        else
        {
            return strtotime($result[0]->metadata->revised);
        }
    }

    /**
     * Computes the number of events active in a given timeframe.
     *
     * Note, that active not starting events are counted here, thus it is quite possible
     * that the same event is listed more then once in case it spans several months.
     *
     * @param int $start Start of the interval (timestamp)
     * @param int $end End of the interval (timestamp)
     * @return int Event count
     */
    function _compute_events_count_between($start, $end)
    {
        // Get the pre-filtered QB
        $qb = fi_kilonkipinat_events_viewer::prepare_event_qb($this->_request_data, $this->_config);

        $kisa_config = $this->_config->get('kisa');

        $qb->add_constraint('start', '<', date('Y-m-d H:i:s', $end));
        if ($kisa_config == 0) {
            $qb->add_constraint('kisa', '<=', FI_KILONKIPINAT_EVENTS_EVENT_KISA_BOTH);
        }
        elseif ($kisa_config == 1) {
            $qb->add_constraint('kisa', '<', FI_KILONKIPINAT_EVENTS_EVENT_KISA_BOTH);
        }
        elseif ($kisa_config == 2) {
            $qb->add_constraint('kisa', '>=', FI_KILONKIPINAT_EVENTS_EVENT_KISA_BOTH);
        }
        elseif ($kisa_config == 3) {
            $qb->add_constraint('kisa', '>', FI_KILONKIPINAT_EVENTS_EVENT_KISA_BOTH);
        }
        $qb->add_constraint('end', '>', date('Y-m-d H:i:s', $start));
        return $qb->count_unchecked();
    }

    /**
     * Computes the total number of events.
     *
     * @return int Event count
     */
    function _compute_events_count_total()
    {
        // Get the pre-filtered QB
        $qb = fi_kilonkipinat_events_viewer::prepare_event_qb($this->_request_data, $this->_config);

        return $qb->count_unchecked();
    }

    /**
     * Constructs a Link for a calendar to the given month.
     *
     * @param Calendar_Month $month The calendar month to link to.
     */
    function _get_calendar_monthlink($month)
    {
        $next_month = $month->nextMonth('object');
        return $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX) . 'archive/between/'
            . $month->thisYear() . '-' . $month->thisMonth() . '-01/'
            . $next_month->thisYear() . '-' . $next_month->thisMonth() . '-01/';
    }

    /**
     * Constructs a Link for a calendar to the given Year.
     *
     * @param Calendar_Year $year The calendar year to link to.
     */
    function _get_calendar_yearlink($year)
    {
        $next_year = $year->nextYear('object');
        return $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX) . 'archive/between/'
            . $year->thisYear() . '-01-01/' . $next_year->thisYear() . '-01-01/';
    }

    /**
     * Computes the data nececssary for the welcome screen. Automatically put into the request
     * data array.
     *
     * @access private
     */
    function _compute_welcome_data()
    {
        setlocale(LC_ALL, 'fi_FI@UTF-8');
        // First step of request data: Overall info
        $year_data = Array();
        $first_month = $this->_compute_first_month();
        $last_month = $this->_compute_last_month();
        $this->_request_data['first_month'] =& $first_month;
        $this->_request_data['last_month'] =& $last_month;
        $this->_request_data['total_count'] = $this->_compute_events_count_total();
        $this->_request_data['year_data'] =& $year_data;
        if (! $first_month)
        {
            return;
        }

        // Second step of request data: Years and months.
        $first_year = $first_month->thisYear();
        $last_year = $last_month->thisYear();

        for ($year_nr = $first_year; $year_nr <= $last_year; $year_nr++)
        {
            $year = new Calendar_Year($year_nr);
            $year->build();
            $year_url = $this->_get_calendar_yearlink($year);

            $year_count = $this->_compute_events_count_between(
                $year->thisYear('timestamp'), $year->nextYear('timestamp'));
            $month_data = Array();

            // Loop over the months, start month is either first posting month
            // or January in all other cases.
            $month = null;
            if ($year_nr == $first_year)
            {
                for ($i = 1; $i < $first_month->thisMonth(); $i++)
                {
                    $month = $year->fetch();
                }
            }

            while ($month = $year->fetch())
            {
                $month_textual = new Calendar_Decorator_Textual($month);
                $month_url = $this->_get_calendar_monthlink($month);
                $month_count = $this->_compute_events_count_between(
                    $month->thisMonth('timestamp'), $month->nextMonth('timestamp'));
                $month_data[$month->thisMonth()] = Array
                (
                    'month' => $month_textual,
                    'name' => $month_textual->thisMonthName(),
                    'url' => $month_url,
                    'count' => $month_count,
                );

                // Check for end month in end year
                if (   $year_nr == $last_year
                    && $month->thisMonth() >= $last_month->thisMonth())
                {
                    break;
                }
            }

            $year_data[$year_nr] = Array
            (
                'year' => $year_nr,
                'url' => $year_url,
                'count' => $year_count,
                'month_data' => $month_data,
            );
        }

    }

    /**
     * Displays the welcome page.
     *
     * Note that all counts are made without ACL restrictions.
     *
     * Element sequence:
     *
     * - archive-start (Start of the archive welcome page)
     * - archive-year (Display of a single year, may not be called when there are no events)
     * - archive-end (End of the archive welcome page)
     *
     * Context data for all elements:
     *
     * - int total_count (total number of events)
     * - fi_kilonkipinat_events_event_dba first_event (the event on which the first month is based, may be null)
     * - fi_kilonkipinat_events_event_dba last_event (the event on which the last month is based, may be null)
     * - CalendarMonth first_month (the first event month, may be null)
     * - CalendarMonth last_month (the last event month, may be null)
     * - Array year_data (the year data, contains the year context info as outlined below)
     *
     * Context data for year elements:
     *
     * - int year (the year displayed)
     * - string url (url to display the complete year)
     * - int count (Number of events in that year)
     * - array month_data (the monthly data)
     *
     * month_data will contain an associative array containing the following array of data
     * indexed by month number (1-12):
     *
     * - string 'url' => The URL to the month.
     * - string 'name' => The localized name of the month.
     * - int 'count' => The number of postings in that month.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param mixed &$data The local request data.
     */
    function _show_welcome($handler_id, &$data)
    {
        setlocale(LC_ALL, 'fi_FI');
        midcom_show_style('archive-start');

        //reversing array to get descenting order in view
        if ($this->_config->get('archive_year_order') == 'DESC')
        {
            $data['year_data'] = array_reverse($data['year_data']);
        }

        foreach ($data['year_data'] as $year => $year_data)
        {
            $data['year'] = $year_data['year'];
            $data['url'] = $year_data['url'];
            $data['count'] = $year_data['count'];
            $data['month_data'] = $year_data['month_data'];
            midcom_show_style('archive-year');
        }

        midcom_show_style('archive-end');
    }

}

?>