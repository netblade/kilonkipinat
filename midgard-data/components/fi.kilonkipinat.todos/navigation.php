<?php
/**
 * @package fi.kilonkipinat.todos 
 * @author The Midgard Project, http://www.midgard-project.org
 * @version $Id: navigation.php 21231 2009-03-17 18:49:59Z bergie $
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * fi.kilonkipinat.todos NAP interface class
 *
 * See the individual member documentations about special NAP options in use.
 *
 * @package fi.kilonkipinat.todos
 */
class fi_kilonkipinat_todos_navigation extends midcom_baseclasses_components_navigation
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
	    if ($this->_config->get('show_navigation_pseudo_leaves')) {
            $leaves["{$this->_topic->id}_LIST_MY"] = array
            (
                MIDCOM_NAV_URL => "list/my/",
                MIDCOM_NAV_NAME => 'Mulle nakitetut',
            );
            $leaves["{$this->_topic->id}_LIST_MY_GROUPS"] = array
            (
                MIDCOM_NAV_URL => "list/my_groups/",
                MIDCOM_NAV_NAME => 'Mun ryhmille nakitetut',
            );
            $leaves["{$this->_topic->id}_LIST_MY_SUPERVISED"] = array
            (
                MIDCOM_NAV_URL => "list/my_supervised/",
                MIDCOM_NAV_NAME => 'Mun valvomat',
            );
            $leaves["{$this->_topic->id}_LIST_OPEN"] = array
            (
                MIDCOM_NAV_URL => "list/open/",
                MIDCOM_NAV_NAME => 'Nakittamattomat',
            );
            $leaves["{$this->_topic->id}_LIST_ALL"] = array
            (
                MIDCOM_NAV_URL => "list/all/",
                MIDCOM_NAV_NAME => 'Kaikki',
            );
        }
        return $leaves;
	}
}

?>