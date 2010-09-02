<?php
/**
 * @package fi.kilonkipinat.events 
 * @author The Midgard Project, http://www.midgard-project.org
 * @version $Id: navigation.php 21231 2009-03-17 18:49:59Z bergie $
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * fi.kilonkipinat.events NAP interface class
 *
 * See the individual member documentations about special NAP options in use.
 *
 * @package fi.kilonkipinat.events
 */
class fi_kilonkipinat_events_navigation extends midcom_baseclasses_components_navigation
{
    /**
     * The topic in which to look for articles. This defaults to the current content topic
     * unless overridden by the symlink topic feature.
     *
     * @var midcom_db_topic
     * @access private
     */
    var $_content_topic = null;

    /**
     * Simple constructor, calls base class.
     */
    function __construct()
    {
        parent::__construct();
    }

    function get_leaves()
    {
        if (   $this->_config->get('show_navigation_pseudo_leaves')
            && $_MIDGARD['user']) {
            $leaves["{$this->_topic->id}_LOCATIONS"] = array
            (
                MIDCOM_NAV_URL => "locations/",
                MIDCOM_NAV_NAME => 'Paikkatiedot',
            );
        }
        if (   $this->_config->get('archive_enable')
            && $this->_config->get('archive_in_navigation')
            && $this->_config->get('show_navigation_pseudo_leaves'))
        {
            $leaves["{$this->_topic->id}_ARCHIVE"] = array
            (
                MIDCOM_NAV_URL => "archive/",
                MIDCOM_NAV_NAME => 'Arkisto',
            );
        }
        
        if (   $this->_config->get('show_navigation_pseudo_leaves')
            && $this->_config->get('archive_years_in_navigation'))
        {
            // Check for symlink
            if (!$this->_content_topic)
            {
                $this->_determine_content_topic();
            }

            $fevent = fi_kilonkipinat_events_compute_first_event($this->_content_topic);
            if (!$fevent)
            {
                return $leaves;
            }
            $first_year = (int) date('Y', strtotime($fevent->start));
            $year = $first_year;

            $levent = fi_kilonkipinat_events_compute_last_event($this->_content_topic);
            if (!$levent)
            {
                $last_year = (int) date('Y', time());
            }
            else
            {
                $last_year = (int) date('Y', strtotime($levent->end));
            }   

            while ($year <= $last_year)
            {
                $next_year = $year + 1;
                $leaves["{$this->_topic->id}_ARCHIVE_{$year}"] = array
                (
                    MIDCOM_NAV_URL => "archive/between/{$year}-01-01/{$next_year}-01-01/",
                    MIDCOM_NAV_NAME => $year,
                );
                $year = $next_year;
            }
            $leaves = array_reverse($leaves);
        }

        return $leaves;
    }
    /**
     * Set the content topic to use. This will check against the configuration setting 'symlink_topic'.
     * We don't do sanity checking here for performance reasons, it is done when accessing the topic,
     * that should be enough.
     *
     * @access protected
     */
    function _determine_content_topic()
    {

        $guid = $this->_config->get('symlink_topic');
        if (   is_null($guid)
            || $guid == false)
        {
            // No symlink topic
            // Workaround, we should talk to a DBA object automatically here in fact.
            $this->_content_topic = new midcom_db_topic($this->_topic->id);
            debug_pop();
            return;
        }

        $this->_content_topic = new midcom_db_topic($guid);

        if (! $this->_content_topic)
        {
            debug_push_class(__CLASS__, __FUNCTION__);
            debug_add('Failed to open symlink content topic, (might also be an invalid object) last Midgard Error: ' . midcom_application::get_error_string(),
                MIDCOM_LOG_ERROR);
            debug_pop();
            $_MIDCOM->generate_error(MIDCOM_ERRCRIT, 'Failed to open symlink content topic.');
            // This will exit.
        }

    }
}

?>