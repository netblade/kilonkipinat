<?php
/**
 * @package fi.kilonkipinat.emailmappings
 * @author The Midgard Project, http://www.midgard-project.org
 * @version $Id$
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * Emailmapper Cronjob Handler
 *
 * @package fi.kilonkipinat.emailmappings
 */
class fi_kilonkipinat_emailmappings_cron_emailmapper extends midcom_baseclasses_components_cron_handler
{
    function _on_initialize()
    {
        return true;
    }

    function _on_execute()
    {
        debug_push_class(__CLASS__, __FUNCTION__);

        if (!$_MIDCOM->auth->request_sudo('fi.kilonkipinat.emailmappings'))
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
            $nap_topic = midcom_helper_find_node_by_component('fi.kilonkipinat.emailmappings');
            $topic = new midcom_db_topic($nap_topic[MIDCOM_NAV_GUID]);
            if (   $topic
                && $topic->guid
                && $topic->guid != ''
                && $topic->guid == $nap_topic[MIDCOM_NAV_GUID]) {
                $real_config = new midcom_helper_configuration($topic, 'fi.kilonkipinat.emailmappings');
                $email_group_guid = $real_config->get('group_for_emails');
            } else {
                $msg = "Could not find topic for config, aborting operation, see error log for details";
                $this->print_error($msg);
                debug_add($msg, MIDCOM_LOG_ERROR);
                debug_pop();
                return;
            }
        }

        $emails = array();
        $usernames = array();

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
                foreach ($member_keys as $guid => $content) {
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
                
                foreach ($person_keys as $guid => $content) {
                    $person_username = $mc_persons->get_subkey($guid, 'username');
                    $person_email = $mc_persons->get_subkey($guid, 'email');
                    if (   strstr($person_email, '@kilonkipinat.fi')
                        || strstr($person_email, '@lists.kilonkipinat.fi')) {
                        debug_add('illegal content in email-address for person guid '.$guid.', continuing to next person', MIDCOM_LOG_ERROR);
                        continue;
                    }

                    if (   isset($emails[$person_email])
                        || isset($usernames[$person_username])) {
                        continue;
                    }

                    $emails[$person_email] = $person_email;
                    $usernames[$person_username] = $person_username;
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
            $file_content .= "\n\n";
            $filename = '/root/mailaliases/aliases_automatic';
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

        $file2_content = '';

        $mc_mappings = fi_kilonkipinat_emailmappings_emailmapping_dba::new_collector('sitegroup', $_MIDGARD['sitegroup']);
        $mc_mappings->add_value_property('name');
        $mc_mappings->add_value_property('persons');
        if (count($usernames != 0)) {
            $mc_mappings->add_constraint('name', 'NOT IN', $usernames);
        }
        $mc_mappings->execute();
        $mapping_keys = $mc_mappings->list_keys();
        foreach ($mapping_keys as $guid => $content) {
            $key = $mc_mappings->get_subkey($guid, 'name');
            $person_guids = $mc_mappings->get_subkey($guid, 'persons');

            $tmp_guids = explode('|', $person_guids);
            $guids = array();
            foreach ($tmp_guids as $guid2) {
                $guids[] = trim(str_replace('|', '', $guid2));
            }

            $persons_mc = fi_kilonkipinat_account_person_dba::new_collector('sitegroup', $_MIDGARD['sitegroup']);
            $persons_mc->add_value_property('email');
            $persons_mc->add_constraint('guid', 'IN', $guids);
            $persons_mc->add_constraint('email', '<>', '');
            $persons_mc->execute();
            $persons_tmp = $persons_mc->list_keys();

            $emails = '';

            foreach ($persons_tmp as $guid3 => $content2) {
                $email = $persons_mc->get_subkey($guid3, 'email');
                if ($emails != '') {
                    $emails .= ', ';
                }

                $emails .=  $email;
            }
            if (   strlen($emails) > 3)
                && strstr($emails, '@'))
            {
                $file2_content .= "\n" . $key . ': ' . $emails;
            }
        }
        
        if ($file2_content != '') {
            $file2_content .= "\n\n";
            $filename2 = '/root/mailaliases/aliases_mappings';
            if (is_writable($filename2)) {
                if (!file_put_contents($filename2, $file2_content)) {
                    $msg = "Tried to write aliases file 2, aborting operation, see error log for details";
                    $this->print_error($msg);
                    debug_add($msg, MIDCOM_LOG_ERROR);
                    debug_pop();
                    return;
                }
            } else {
                $msg = "Couldn't write to aliases file 2, aborting operation, see error log for details";
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
