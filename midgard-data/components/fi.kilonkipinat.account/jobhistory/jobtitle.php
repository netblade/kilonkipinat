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
class fi_kilonkipinat_account_jobhistory_jobtitle_dba extends __fi_kilonkipinat_account_jobhistory_jobtitle_dba
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

        if (isset($GLOBALS['disable_activitystream']))
        {
            return true;
        }

        if ($_MIDCOM->auth->request_sudo('midcom'))
        {
            // This is here because creating an object calls create and update..... and we don't want duplicate entry's
            $qb = midcom_helper_activitystream_activity_dba::new_query_builder();
            $qb->set_limit(1);
            $qb->add_constraint('application', '=', 'fi.kilonkipinat.account');
            $qb->add_constraint('target', '=', $this->guid);
            $groups = $qb->execute();
            if (   $groups
                && is_array($groups)
                && count($groups) > 0)
            {
                $new_object = false;
            }
            else
            {
                $new_object = true;
            }

            $actor = midcom_db_person::get_cached($_MIDGARD['user']);
            $activity = new midcom_helper_activitystream_activity_dba();
            $activity->target = $this->guid;
            $activity->application = 'fi.kilonkipinat.account';
            $activity->actor = $actor->id;
            $activity->verb = 'http://activitystrea.ms/schema/1.0/post';

            if ($new_object)
            {
                $activity->summary = sprintf('%s loi pestinimikkeen %s', $actor->name, $this->title);
            }
            else
            {
                $activity->summary = sprintf('%s muokkasi pestinimikettä %s', $actor->name, $this->title);
            }
            

            $activity->create();

            $_MIDCOM->auth->drop_sudo();
        }

        return true;
    }
}