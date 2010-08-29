<?php
/**
 * @package net.nemein.calendar
 * @author The Midgard Project, http://www.midgard-project.org
 * @version $Id: functions.php 18596 2008-11-05 00:57:14Z bergie $
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */


function fi_kilonkipinat_events_compute_first_event(&$parent)
{
    $qb = fi_kilonkipinat_events_event_dba::new_query_builder();
    if (is_a($parent, 'fi_kilonkipinat_events_event_dba'))
    {
        $qb->add_constraint('up', 'INTREE', $parent->id);
    }
    elseif (is_a($parent, 'midcom_baseclasses_database_topic'))
    {
        $qb->add_constraint('topic', '=', $parent->id);
    }
    else
    {
        return false;
    }
    // Avoid problems with events too close to the epoch (highly unlikely usage scenario in any case)
    $qb->add_constraint('start', '>', '1972-01-02 00:00:00');
    $qb->add_order('start');
    $qb->set_limit(1);

    if ($_MIDCOM->auth->request_sudo())
    {
        $result = $qb->execute();
        $_MIDCOM->auth->drop_sudo();
    }
    else
    {
        $result = $qb->execute();
    }
    unset($qb);
    if (empty($result))
    {
        return false;
    }
    return $result[0];
}

function fi_kilonkipinat_events_compute_last_event(&$parent)
{
    $qb = fi_kilonkipinat_events_event_dba::new_query_builder();
    if (is_a($parent, 'fi_kilonkipinat_events_event_dba'))
    {
        $qb->add_constraint('up', 'INTREE', $parent->id);
    }
    elseif (is_a($parent, 'midcom_baseclasses_database_topic'))
    {
        $qb->add_constraint('topic', '=', $parent->id);
    }
    else
    {
        return false;
    }
    // Avoid problems with events too close to the epoch (highly unlikely usage scenario in any case)
    $qb->add_constraint('start', '>', '1972-01-02 00:00:00');
    $qb->add_order('end', 'DESC');
    $qb->set_limit(1);

    if ($_MIDCOM->auth->request_sudo())
    {
        $result = $qb->execute();
        $_MIDCOM->auth->drop_sudo();
    }
    else
    {
        $result = $qb->execute();
    }
    unset($qb);
    if (empty($result))
    {
        return false;
    }
    return $result[0];
}


?>