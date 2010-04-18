<?php
/**
 * @package fi.kilonkipinat.accountregistration 
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is the interface class for fi.kilonkipinat.accountregistration
 * 
 * @package fi.kilonkipinat.accountregistration
 */
class fi_kilonkipinat_accountregistration_interface extends midcom_baseclasses_components_interface
{
    /**
     * Constructor, define component name
     */
    function __construct()
    {
        parent::__construct();
        $this->_component = 'fi.kilonkipinat.accountregistration';
    }
    
    function _on_initialize()
    {
        $this->define_constants();

        return true;
    }
    
    private function define_constants()
    {
        // Status definitions for password reset requests
        define('FI_KILONKIPINAT_ACCOUNTREGISTRATION_PASSWORDRESETREQUEST_STATUS_NEW', 1000);
        define('FI_KILONKIPINAT_ACCOUNTREGISTRATION_PASSWORDRESETREQUEST_STATUS_RESOLVED', 1010);
        define('FI_KILONKIPINAT_ACCOUNTREGISTRATION_PASSWORDRESETREQUEST_STATUS_INVALID', 1050);

        // Status definitions for new account registrations
        define('FI_KILONKIPINAT_ACCOUNTREGISTRATION_ACCOUNT_STATUS_NEW', 1100);
        define('FI_KILONKIPINAT_ACCOUNTREGISTRATION_ACCOUNT_STATUS_EMAILVALIDATED', 1110);
        define('FI_KILONKIPINAT_ACCOUNTREGISTRATION_ACCOUNT_STATUS_RESOLVED', 1120);
        define('FI_KILONKIPINAT_ACCOUNTREGISTRATION_ACCOUNT_STATUS_INVALID', 1150);
    }
}
?>