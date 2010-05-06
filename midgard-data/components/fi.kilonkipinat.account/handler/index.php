<?php
/**
 * @package fi.kilonkipinat.account
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is a URL handler class for fi.kilonkipinat.account
 *
 * The midcom_baseclasses_components_handler class defines a bunch of helper vars
 *
 * @see midcom_baseclasses_components_handler
 * @see: http://www.midgard-project.org/api-docs/midcom/dev/midcom.baseclasses/midcom_baseclasses_components_handler/
 * 
 * @package fi.kilonkipinat.account
 */
class fi_kilonkipinat_account_handler_index extends midcom_baseclasses_components_handler
{

    /**
     * Simple default constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * _on_initialize is called by midcom on creation of the handler.
     */
    function _on_initialize()
    {
    }

    /**
     * The handler for the index article.
     *
     * @param mixed $handler_id the array key from the request array
     * @param array $args the arguments given to the handler
     * @param Array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_index($handler_id, $args, &$data)
    {
        $this->_request_data['name']  = "fi.kilonkipinat.account";
        $this->_update_breadcrumb_line($handler_id);
        $title = $this->_l10n_midcom->get('index');
        $_MIDCOM->set_pagetitle(":: {$title}");
        
        $root_group_guid = $this->_config->get('root_group_to_show');
        $persons = array();
        if (   isset($root_group_guid)
            && $root_group_guid != null
            && $root_group_guid != '') {
            $root_group = new midcom_db_group($root_group_guid);
            if (   $root_group
                && $root_group->guid == $root_group_guid) {
                $mc_members = midcom_db_member::new_collector('gid', $root_group->id);
                $mc_members->add_value_property('uid');
                $mc_members->execute();
                $member_guids = $mc_members->list_keys();
                $member_ids = array();
                foreach ($member_guids as $guid => $array)
                {
                    $member_ids[] = $mc_members->get_subkey($guid, 'uid');
                }
                
                $qb_persons = fi_kilonkipinat_account_person_dba::new_query_builder();
                $qb_persons->add_constraint('id', 'IN', $member_ids);
                $qb_persons->add_order('lastname', 'ASC');
                $qb_persons->add_order('nickname', 'ASC');
                $qb_persons->add_order('firstname', 'ASC');
                $persons = $qb_persons->execute();
                
            }
        }

        $this->_request_data['requests'] = '';
        
        if ($_MIDCOM->auth->admin) {
            $regs_topic = midcom_helper_find_node_by_component('fi.kilonkipinat.accountregistration');
            $regs_prefix = '';
            if ($regs_topic) {
                $regs_prefix = $regs_topic['18'];
            }
            
            $mc = fi_kilonkipinat_accountregistration_accountrequest_dba::new_collector('status', FI_KILONKIPINAT_ACCOUNTREGISTRATION_ACCOUNT_STATUS_EMAILVALIDATED);
//            $mc->add_constraint('status', '=', fi_kilonkipinat_accountregistration_interface::FI_KILONKIPINAT_ACCOUNTREGISTRATION_ACCOUNT_STATUS_EMAILVALIDATED);
            $requests_count = $mc->count();
            if (   $requests_count > 0
                && $regs_prefix != '') {
                $this->_request_data['requests'] = '<a href="'.$regs_prefix.'list_pending/">'.$requests_count.' tunnushakemusta</a>';
            }
        }
        
        $this->_request_data['persons'] = $persons;
        
        return true;
    }

    /**
     * This function does the output.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param mixed &$data The local request data.
     */
    function _show_index($handler_id, &$data)
    {
        midcom_show_style('index');
    }

    /**
     * Helper, updates the context so that we get a complete breadcrumb line towards the current
     * location.
     *
     */
    function _update_breadcrumb_line()
    {
        $tmp = Array();

        $tmp[] = Array
        (
            MIDCOM_NAV_URL => "/",
            MIDCOM_NAV_NAME => $this->_l10n->get('index'),
        );

        $_MIDCOM->set_custom_context_data('midcom.helper.nav.breadcrumb', $tmp);
    }
}
?>