<?php
/**
 * @package fi.kilonkipinat.website 
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * @package fi.kilonkipinat.website
 */
class fi_kilonkipinat_website
{
    public function returnDate($date, $format = 'short')
    {
        $datetimes = array(
            'extraShort' => 'd.m.',
            'short' => 'd.m.Y',
            'medium' => 'd.m.Y H:i',
            'long' => 'd.m.Y H:i:s e',
            'timeShort' => 'H:i',
            'timeMedium' => 'H:i:s',
            'timeLong' => 'H:i:s e',
        );
        $value = date($datetimes[$format], $date);

        return $value;
    }
    
    
    public function returnDateLabel($label='start', $start, $end , $add_time = true, $add_year = false)
    {
        $daylabel = '';
        if ($label == 'start')
        {
            // We want to output the label for start time
            $daylabel .= fi_kilonkipinat_website::returnDate($start, 'extraShort');

            if (date('Y', $start) != date('Y', $end))
            {
                $daylabel .= date('.Y', $start);
            }

            if ($add_time)
            {
                $daylabel .= ' ' . fi_kilonkipinat_website::returnDate($start, 'timeShort');
            }
        }
        else
        {
            if (   $add_year
                || date('Y', $start) != date('Y', $end))
            {
                $daylabel .= fi_kilonkipinat_website::returnDate($end, 'short');
            }
            elseif (date('m', $start) != date('m', $end))
            {
                $daylabel .= fi_kilonkipinat_website::returnDate($end, 'extraShort');
            }
            elseif (date('d', $start) != date('d', $end))
            {
                $daylabel .= fi_kilonkipinat_website::returnDate($end, 'extraShort');
            }

            if ($add_time)
            {
                $daylabel .= ' ' . fi_kilonkipinat_website::returnDate($end, 'timeShort');
            }
        }
        return $daylabel;
    }
    
    function check_login()
    {
        if (   isset($GLOBALS['fi_kilonkipinat_website_login_detected'])
            && $GLOBALS['fi_kilonkipinat_website_login_detected'] == true) {
            if (!$_MIDCOM->auth->admin) {
                $person = new fi_kilonkipinat_account_person_dba($_MIDGARD['user']);
                if ($person->nickname == '') {
                    $account_topic = midcom_helper_find_node_by_component('fi.kilonkipinat.account');
                    $account_topic_prefix = '';
                    if ($account_topic) {
                        $account_topic_prefix = $account_topic[MIDCOM_NAV_ABSOLUTEURL];
                        $_MIDCOM->relocate($account_topic_prefix . 'own_details/');
                    }
                }
            }
        }
    }
}
?>