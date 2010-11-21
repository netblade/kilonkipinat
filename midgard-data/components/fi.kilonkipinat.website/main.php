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

    public function returnDateLabels($start, $end , $add_time = true, $add_end_time = true, $add_year = false)
    {
        $ret_str = '';
        
        if (   date('d.m.Y', $start) == date('d.m.Y', $end)
            && (   $add_time == false
                || $add_end_time == false)) {
            $ret_str .= '<abbr class="dtstart" title="' . gmdate('Y-m-d\TH:i:s\Z', $start) . '">' . fi_kilonkipinat_website::returnDateLabel('start', $start, $end, $add_time, $add_year) .'</abbr>';
            $ret_str .= '<abbr class="dtend" title="' . gmdate('Y-m-d\TH:i:s\Z', $end) . '"></abbr>';
        } elseif ($start > $end) {
            $ret_str .= '<abbr class="dtstart" title="' . gmdate('Y-m-d\TH:i:s\Z', $start) . '">' . fi_kilonkipinat_website::returnDateLabel('start', $start, $end, $add_time, $add_year) .'</abbr>';
        } else {
            $ret_str .= '<abbr class="dtstart" title="' . gmdate('Y-m-d\TH:i:s\Z', $start) . '">' . fi_kilonkipinat_website::returnDateLabel('start', $start, $end, $add_time, $add_year) .'</abbr>';
            $ret_str .= ' - ';
            $ret_str .= '<abbr class="dtend" title="' . gmdate('Y-m-d\TH:i:s\Z', $end) . '">' . fi_kilonkipinat_website::returnDateLabel('end', $start, $end, $add_end_time, $add_year) .'</abbr>';
        }
        
        return $ret_str;
    }
    
    public function check_login()
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
    
    public function getDownloads($types, $fieldname, $title)
    {
        $ret_str = '';
        if(isset($types[$fieldname]))
        {
            $tmp_downloads = $types[$fieldname]->attachments_info;
        }
        if (   isset($tmp_downloads)
            && count($tmp_downloads)>0)
        {
            $ret_str .= '<div class="downloads">' . "\n";
            $ret_str .= "\t".'<h3>' . $title . '</h3>' . "\n";
            $ret_str .= "\t".'<ul>' . "\n";
            foreach($tmp_downloads as $tmp_download)
            {
                $filesize = round(($tmp_download['filesize'] / 1024), 0);
                if($filesize > 1000)
                {
                    $filesize = round(($filesize / 1024), 2) . ' MB';
                }
                else
                {
                    $filesize = $filesize . ' kb';
                }
                $filetype = str_replace('application/', '', $tmp_download['mimetype']);
                $filetype = str_replace('image/', '', $filetype);
                if ($filetype != '')
                {
                    $filetype .= ', ';
                }
                if($tmp_download['description'] != '')
                {
                    $ret_str .= "\t\t<li><a href=\"" . $tmp_download['url'] . "\">" . $tmp_download['description'] . "</a> (" . $filetype . $filesize . ")</li>\n";
                }
                else
                {
                    $ret_str .= "\t\t<li><a href=\"" . $tmp_download['url'] . "\">" . $tmp_download['filename'] . "</a> (" . $filetype . $filesize . ")</li>\n";
                }
            }
            $ret_str .= "\t".'</ul>' . "\n";
            $ret_str .= '</div>' . "\n";
        }
        return $ret_str;
    }
    
    /**
     * Try to find a comments node (cache results)
     *
     * @access public
     */
    public function seek_comments(&$data)
    {
        if ($data['config']->get('comments_topic'))
        {
            // We have a specified photostream here
            $comments_topic = new midcom_db_topic($data['config']->get('comments_topic'));
            if (   !is_object($comments_topic)
                || !isset($comments_topic->guid)
                || empty($comments_topic->guid))
            {
                return false;
            }

            // We got a topic. Make it a NAP node
            $nap = new midcom_helper_nav();
            $comments_node = $nap->get_node($comments_topic->id);

            return $comments_node;
        }

        // No comments topic specified, autoprobe
        $comments_node = midcom_helper_find_node_by_component('net.nehmer.comments');

        // Cache the data
        if ($_MIDCOM->auth->request_sudo($data['topic']->component))
        {
            $data['topic']->set_parameter($data['topic']->component, 'comments_topic', $comments_node[MIDCOM_NAV_GUID]);
            $_MIDCOM->auth->drop_sudo();
        }

        return $comments_node;
    }

	/**
     * Try to find a comments node (cache results)
     *
     * @access public
     */
    public function return_chooser_date($value) {
		return date('d.m.Y H:i', strtotime($value));
	}
}
?>