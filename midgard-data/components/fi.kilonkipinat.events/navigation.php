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
     * Simple constructor, calls base class.
     */
    function __construct()
    {
        parent::__construct();
    }

    function get_leaves()
    {
        $leaves = array();
        $leaves["archive"] = array
        (
            MIDCOM_NAV_URL => "archive/",
            MIDCOM_NAV_NAME => 'Arkisto',
        );

        return $leaves;
    }
}

?>