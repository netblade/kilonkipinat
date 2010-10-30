<?php
/**
 * @package fi.kilonkipinat.todos
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * @package fi.kilonkipinat.todos
 */
class fi_kilonkipinat_todos_todoitem_dba extends __fi_kilonkipinat_todos_todoitem_dba
{
    static function &get_cached($src)
    {
        return $_MIDCOM->dbfactory->get_cached(__CLASS__, $src);
    }

    function _construct_message()
    {
        // Construct the message
        $message = array();

        // Resolve parent title
        $object = $this;

        // Resolve commenting user
        if (!$_MIDCOM->auth->user)
        {
            return false;
        }

        $user_string = "{$_MIDCOM->auth->user->name} ({$_MIDCOM->auth->user->username})";
        if (isset($GLOBALS['fi.kilonkipinat.todos_commented'])) {
            $message['title'] = 'Nakkia ' . $object->title . ' kommentoitiin käyttäjän ' . $user_string . ' toimesta';
        } else {
            $message['title'] = 'Nakkia ' . $object->title . ' muokattiin käyttäjän ' . $user_string . ' toimesta';
        }

        $message['content']  = "Nakki: {$this->title}\n\n";
        if (isset($GLOBALS['fi.kilonkipinat.todos_update_message'])) {
            $message['content'] .= $GLOBALS['fi.kilonkipinat.todos_update_message'] . "\n\n";
        }
        $message['content'] .= $_MIDCOM->permalinks->create_permalink($object->guid);

        $message['abstract'] = $message['title'];
        
        return $message;
    }

    function _send_notifications()
    {
        $message = $this->_construct_message();
        $subscriptions = array();
        $tmp_subscriptions = $this->list_parameters('fi.kilonkipinat.todos:subscribe');
        if (!empty($subscriptions))
        {
            //Go through each subscription
            foreach ($tmp_subscriptions as $user_guid => $subscription_time)
            {
                $subscriptions[$user_guid] = true;
            }
        }
        
        if (   $this->person != 0
            && $this->person != '') {
            $person = new fi_kilonkipinat_account_person_dba($this->person);
            if ($this->person == $person->id) {
                $subscriptions[$person->guid] = true;
            }
        }
        
        if (   $this->supervisor != 0
            && $this->supervisor != '') {
            $person = new fi_kilonkipinat_account_person_dba($this->supervisor);
            if ($this->supervisor == $person->id) {
                $subscriptions[$person->guid] = true;
            }
        }
        
        if (   $this->grp != 0
            && $this->grp != '') {
            $grp = new midcom_db_group($this->grp);
            if ($this->grp == $grp->id) {
                $mc = midcom_db_member::new_collector('sitegroup', $_MIDGARD['sitegroup']);
                $mc->add_constraint('gid', '=', $this->grp);
                $mc->add_value_property('uid');
                $mc->execute();
                $tmp_keys = $mc->list_keys();
                foreach ($tmp_keys as $guid => $tmp_key)
                {
                    $person = new fi_kilonkipinat_account_person_dba($mc->get_subkey($guid, 'uid'));
                    if (   $person->id != ''
                        && $person->id != 0
                        && $person->guid != '') {
                        $subscriptions[$person->guid] = true;
                    }
                }
            }
        }
        
        if (isset($subscriptions[$_MIDCOM->auth->user->guid])) {
            $subscriptions[$_MIDCOM->auth->user->guid] = false;
        }
        
        if (count($subscriptions) > 0) {
            foreach ($subscriptions as $user_guid => $status)
            {
                if ($status) {
                    // Send notice
                    org_openpsa_notifications::notify('fi.kilonkipinat.todos:subscribe', $user_guid, $message);
                }
            }
        }
    }

    function _on_updated()
    {
        if (!isset($GLOBALS['fi.kilonkipinat.todos_dont_send_messages'])) {
            $this->_send_notifications();
        }
        return true;
    }
    
    public function _send_comment_notifications()
    {
        $this->_send_notifications();
        return true;
    }
}
?>