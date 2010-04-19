<?php
/**
 * @package fi.kilonkipinat.account
 * @author The Midgard Project, http://www.midgard-project.org
 * @version $Id$
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * Emailmapper Cronjob Handler
 *
 * @package fi.kilonkipinat.account
 */
class fi_kilonkipinat_account_cron_emailmapper extends midcom_baseclasses_components_cron_handler
{
    function _on_initialize()
    {
        return true;
    }

    function _on_execute()
    {
        debug_push_class(__CLASS__, __FUNCTION__);

        if (!$_MIDCOM->auth->request_sudo('fi.kilonkipinat.account'))
        {
            $msg = "Could not get sudo, aborting operation, see error log for details";
            $this->print_error($msg);
            debug_add($msg, MIDCOM_LOG_ERROR);
            debug_pop();
            return;
        }

        $email_group_guid = $this->_config->get('group_for_emails');

        if ($email_group_guid == null) {
            // Email group not set in global config, we try to search for topic
            $nap_topic = midcom_helper_find_node_by_component('fi.kilonkipinat.account');
            $topic = new midcom_db_topic($nap_topic[MIDCOM_NAV_GUID]);
            if (   $topic
                && $topic->guid
                && $topic->guid != ''
                && $topic->guid == $nap_topic[MIDCOM_NAV_GUID]) {
                $real_config = new midcom_helper_configuration($topic, 'fi.kilonkipinat.account');
                $email_group_guid = $real_config->get('group_for_emails');
            } else {
                $msg = "Could not find topic for config, aborting operation, see error log for details";
                $this->print_error($msg);
                debug_add($msg, MIDCOM_LOG_ERROR);
                debug_pop();
                return;
            }
        }
        $file_content = '';
        if ($email_group_guid != null) {
            $email_group = new midcom_db_group($email_group_guid);
            if (   $email_group
                && $email_group->guid
                && $email_group->guid != ''
                && $email_group->guid == $email_group_guid) {

                $mc_members = midcom_db_member::new_collector('gid', $email_group->id);
                $mc_members->add_value_property('uid');
                $mc_members->execute();
                $member_keys = $mc_members->list_keys();
                $person_ids = array();
                foreach ($member_keys as $guid => $data) {
                    $person_id = $mc_members->get_subkey($guid, 'uid');
                    $person_ids[] = $person_id;
                    unset($person_id);
                }
                
                $mc_persons = fi_kilonkipinat_account_person_dba::new_collector('sitegroup', $_MIDGARD['sitegroup']);
                $mc_persons->add_constraint('id', 'IN', $person_ids);
                $mc_persons->add_constraint('username', '<>', '');
                $mc_persons->add_constraint('email', '<>', '');
                $mc_persons->add_constraint('email', 'LIKE', '%@%');
                $mc_persons->add_value_property('username');
                $mc_persons->add_value_property('email');
                $mc_persons->execute();
                $person_keys = $mc_persons->list_keys();
                
                $emails = array();
                $usernames = array();
                foreach ($person_keys as $guid => $data) {
                    $person_username = $mc_persons->get_subkey($guid, 'username');
                    $person_email = $mc_persons->get_subkey($guid, 'email');
                    if (   strstr($person_email, '@kilonkipinat.fi')
                        || strstr($person_email, '@lists.kilonkipinat.fi')) {
                        debug_add('illegal content in email-address for person guid '.$guid.', continuing to next person', MIDCOM_LOG_ERROR);
                        continue;
                    }

                    if(   isset($emails[$person_email])
                       || $usernames[$person_username])) {
                        continue;
                    }

                    $emails[$person_email] = 1;
                    $usernames[$person_username] = 1;
                    $file_content .= "\n" . $person_username . ': ' . $person_email;
                }
                
                
            } else {
                $msg = "Could not instantiate group for emailmapping, aborting operation, see error log for details";
                $this->print_error($msg);
                debug_add($msg, MIDCOM_LOG_ERROR);
                debug_pop();
                return;
            }
            
        } else {
            $msg = "Could not find group for emailmapping, aborting operation, see error log for details";
            $this->print_error($msg);
            debug_add($msg, MIDCOM_LOG_ERROR);
            debug_pop();
            return;
        }
        
        if ($file_content != '') {
            $filename = '/root/mailaliases/aliases';
            if (is_writable($filename)) {
                if (!file_put_contents($filename, $file_content)) {
                    $msg = "Tried to write aliases file, aborting operation, see error log for details";
                    $this->print_error($msg);
                    debug_add($msg, MIDCOM_LOG_ERROR);
                    debug_pop();
                    return;
                }
            } else {
                $msg = "Couldn't write to aliases file, aborting operation, see error log for details";
                $this->print_error($msg);
                debug_add($msg, MIDCOM_LOG_ERROR);
                debug_pop();
                return;
            }
        }
        
        $_MIDCOM->auth->drop_sudo();
        debug_pop();
    }
}