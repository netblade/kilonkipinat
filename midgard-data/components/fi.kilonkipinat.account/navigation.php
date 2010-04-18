<?php
/**
 * @package fi.kilonkipinat.account 
 * @author The Midgard Project, http://www.midgard-project.org
 * @version $Id: navigation.php 21231 2009-03-17 18:49:59Z bergie $
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * fi.kilonkipinat.account NAP interface class
 *
 * See the individual member documentations about special NAP options in use.
 *
 * @package fi.kilonkipinat.account
 */
class fi_kilonkipinat_account_navigation extends midcom_baseclasses_components_navigation
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
        $leaves["own_details"] = array
        (
            MIDCOM_NAV_URL => "own_details/",
            MIDCOM_NAV_NAME => 'Omat tiedot',
        );
        $leaves["change_password"] = array
        (
            MIDCOM_NAV_URL => "change_password/",
            MIDCOM_NAV_NAME => 'Vaihda salasana',
        );
        
        return $leaves;
    }
}

?>