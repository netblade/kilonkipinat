<?php
/**
 * @package fi.kilonkipinat.accountregistration
 * @author The Midgard Project, http://www.midgard-project.org
 * @version $Id$
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * Clearold Cronjob Handler
 *
 * - Checks if there is old resetrequests and marks those as invalid
 *
 * @package fi.kilonkipinat.accountregistration
 */
class fi_kilonkipinat_accountregistration_cron_clearold extends midcom_baseclasses_components_cron_handler
{
    function _on_initialize()
    {
        return true;
    }

    function _on_execute()
    {
        debug_push_class(__CLASS__, __FUNCTION__);

        if (!$_MIDCOM->auth->request_sudo('fi.kilonkipinat.accountregistration'))
        {
            $msg = "Could not get sudo, aborting operation, see error log for details";
            $this->print_error($msg);
            debug_add($msg, MIDCOM_LOG_ERROR);
            debug_pop();
            return;
        }
        
        $time_for_old = date('Y-m-d 00:00', time() - (3600*24));
        
        $qb_resetrequests = fi_kilonkipinat_accountregistration_resetrequest_dba::new_query_builder();
        $qb_resetrequests->add_constraint('metadata.revised', '<', $time_for_old);
        $qb_resetrequests->add_constraint('status', '=', FI_KILONKIPINAT_ACCOUNTREGISTRATION_PASSWORDRESETREQUEST_STATUS_NEW);
        $results = $qb_resetrequests->execute();
        
        foreach ($results as $result) {
            $result->status = FI_KILONKIPINAT_ACCOUNTREGISTRATION_PASSWORDRESETREQUEST_STATUS_INVALID;
            $result->update();
        }
        
        $time_for_old = date('Y-m-d 00:00', time() - (3600*24*31));
        
        $qb_accounts = fi_kilonkipinat_accountregistration_accountrequest_dba::new_query_builder();
        $qb_accounts->add_constraint('metadata.revised', '<', $time_for_old);
        $qb_accounts->add_constraint('status', '=', FI_KILONKIPINAT_ACCOUNTREGISTRATION_ACCOUNT_STATUS_NEW);
        $results2 = $qb_accounts->execute();
        
        foreach ($results2 as $result) {
            $result->status = FI_KILONKIPINAT_ACCOUNTREGISTRATION_ACCOUNT_STATUS_INVALID;
            $result->update();
        }

        $_MIDCOM->auth->drop_sudo();
        debug_pop();
    }
}