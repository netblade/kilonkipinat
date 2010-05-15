<?php
/**
 * @package fi.kilonkipinat.account
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * @package fi.kilonkipinat.account
 */
class fi_kilonkipinat_account_person_dba extends __fi_kilonkipinat_account_person_dba
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
    
    public function _on_updated()
    {
        // Invalidate topic in cache to refresh all views
        // TODO: Do this only on status changes
        $topic = midcom_db_topic::get_cached($this->topic);
        if ($topic->guid)
        {
            $_MIDCOM->cache->invalidate($topic->guid);
        }

        if (isset($GLOBALS['disable_activitystream']))
        {
            return true;
        }

        if ($_MIDCOM->auth->request_sudo('midcom'))
        {
            $actor = midcom_db_person::get_cached($_MIDGARD['user']);
            $activity = new midcom_helper_activitystream_activity_dba();
            $activity->target = $this->guid;
            $activity->application = 'fi.kilonkipinat.account';
            $activity->actor = $actor->id;
            $activity->verb = 'http://activitystrea.ms/schema/1.0/post';

            if ($this->id == $actor->id) {
                $activity->summary = sprintf('%s muokkasi omaa tunnustaan', $actor->name);
            } else {
                $tmp_name = $this->firstname . ' ' . $this->lastname;
                $activity->summary = sprintf('%s muokkasi %s:n tunnusta', $actor->name, $tmp_name);
            }
            

            $activity->create();

            $_MIDCOM->auth->drop_sudo();
        }

        return true;
    }
}