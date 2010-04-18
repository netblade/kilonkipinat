<?php
/**
 * @package fi.kilonkipinat.accountregistration 
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * @package fi.kilonkipinat.accountregistration 
 */
class fi_kilonkipinat_accountregistration_resetrequest_dba extends __fi_kilonkipinat_accountregistration_resetrequest_dba
{    
    
    static function &get_cached($src)
    {
        return $_MIDCOM->dbfactory->get_cached(__CLASS__, $src);
    }

    public function _on_creating()
    {
        // Disable automatic activity stream entry, we use custom here
        $this->_use_activitystream = false;

        return true;
    }

    public function _on_updating()
    {
        // Disable automatic activity stream entry, we use custom here
        $this->_use_activitystream = false;

        return true;
    }
}