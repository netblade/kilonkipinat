<?php
/**
 * @package fi.kilonkipinat.todos
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is a URL handler class for fi.kilonkipinat.todos
 *
 * The midcom_baseclasses_components_handler class defines a bunch of helper vars
 *
 * @see midcom_baseclasses_components_handler
 * @see: http://www.midgard-project.org/api-docs/midcom/dev/midcom.baseclasses/midcom_baseclasses_components_handler/
 * 
 * @package fi.kilonkipinat.todos
 */
class fi_kilonkipinat_todos_handler_list extends midcom_baseclasses_components_handler
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
    function _handler_my($handler_id, $args, &$data)
    {
        $_MIDCOM->auth->require_valid_user();
        $this->_request_data['name']  = "fi.kilonkipinat.todos";
        $this->_component_data['active_leaf'] = "{$this->_topic->id}_LIST_MY";
        $this->_update_breadcrumb_line($handler_id);
        $title = 'Nakit';
        $_MIDCOM->set_pagetitle(":: {$title}");
        
        $qb = new org_openpsa_qbpager('fi_kilonkipinat_todos_todoitem_dba', 'fi_kilonkipinat_todos_list_my');
        $qb->add_constraint('person', '=', $_MIDGARD['user']);
        $qb->add_constraint('status', '<', FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_RESOLVED);
        $qb->add_order('deadline', 'ASC');
        if ($handler_id == 'list_my_count') {
            $qb->results_per_page = $args[0];
        } else {
            $qb->results_per_page = $this->_config->get('index_entries');
        }
        
        $data['todoitems'] = $qb->execute();
        $data['qb'] = $qb;
        $data['handler_id'] = $handler_id;
        
        return true;
    }

    /**
     * This function does the output.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param mixed &$data The local request data.
     */
    function _show_my($handler_id, &$data)
    {
        midcom_show_style('list-my');
    }
    
    /**
     * The handler for the index article.
     *
     * @param mixed $handler_id the array key from the request array
     * @param array $args the arguments given to the handler
     * @param Array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_myGroups($handler_id, $args, &$data)
    {
        $_MIDCOM->auth->require_valid_user();
        $this->_request_data['name']  = "fi.kilonkipinat.todos";
        $this->_component_data['active_leaf'] = "{$this->_topic->id}_LIST_MY_GROUPS";
        $this->_update_breadcrumb_line($handler_id);
        $title = 'Nakit';
        $_MIDCOM->set_pagetitle(":: {$title}");
        
        $my_groups = array();
        $mc_my_groups = midcom_db_member::new_collector('sitegroup', $_MIDGARD['sitegroup']);
        $mc_my_groups->add_constraint('uid', '=', $_MIDGARD['user']);
        $mc_my_groups->add_value_property('gid');
        $mc_my_groups->execute();
        $tmp_keys = $mc_my_groups->list_keys();

        foreach ($tmp_keys as $guid => $tmp_key)
        {
            $group_id = $mc_my_groups->get_subkey($guid, 'gid');
            $my_groups[$group_id] = $group_id;
        }
        
        $qb = new org_openpsa_qbpager('fi_kilonkipinat_todos_todoitem_dba', 'fi_kilonkipinat_todos_list_my');
        $qb->add_constraint('grp', 'IN', $my_groups);
        $qb->add_constraint('grp', '<>', 0);
        $qb->add_constraint('status', '<', FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_RESOLVED);
        $qb->add_order('deadline', 'ASC');
        if ($handler_id == 'list_mygroups_count') {
            $qb->results_per_page = $args[0];
        } else {
            $qb->results_per_page = $this->_config->get('index_entries');
        }
        
        $data['todoitems'] = $qb->execute();
        $data['qb'] = $qb;
        $data['handler_id'] = $handler_id;
        
        return true;
    }

    /**
     * This function does the output.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param mixed &$data The local request data.
     */
    function _show_myGroups($handler_id, &$data)
    {
        midcom_show_style('list-my-groups');
    }
    
    /**
     * The handler for the index article.
     *
     * @param mixed $handler_id the array key from the request array
     * @param array $args the arguments given to the handler
     * @param Array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_mySupervised($handler_id, $args, &$data)
    {
        $_MIDCOM->auth->require_valid_user();
        $this->_request_data['name']  = "fi.kilonkipinat.todos";
        $this->_component_data['active_leaf'] = "{$this->_topic->id}_LIST_MY_SUPERVISED";
        $this->_update_breadcrumb_line($handler_id);
        $title = 'Nakit';
        $_MIDCOM->set_pagetitle(":: {$title}");
        
        $qb = new org_openpsa_qbpager('fi_kilonkipinat_todos_todoitem_dba', 'fi_kilonkipinat_todos_list_my');
        $qb->add_constraint('supervisor', '=', $_MIDGARD['user']);
        $qb->add_constraint('status', '<', FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_RESOLVED);
        $qb->add_order('deadline', 'ASC');
        if ($handler_id == 'list_mysupervised_count') {
            $qb->results_per_page = $args[0];
        } else {
            $qb->results_per_page = $this->_config->get('index_entries');
        }
        
        $data['todoitems'] = $qb->execute();
        $data['qb'] = $qb;
        $data['handler_id'] = $handler_id;
        
        return true;
    }

    /**
     * This function does the output.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param mixed &$data The local request data.
     */
    function _show_mySupervised($handler_id, &$data)
    {
        midcom_show_style('list-my-supervised');
    }
    
    /**
     * The handler for the index article.
     *
     * @param mixed $handler_id the array key from the request array
     * @param array $args the arguments given to the handler
     * @param Array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_open($handler_id, $args, &$data)
    {
        $_MIDCOM->auth->require_valid_user();
        $this->_request_data['name']  = "fi.kilonkipinat.todos";
        $this->_component_data['active_leaf'] = "{$this->_topic->id}_LIST_OPEN";
        $this->_update_breadcrumb_line($handler_id);
        $title = 'Nakit';
        $_MIDCOM->set_pagetitle(":: {$title}");
        
        $qb = new org_openpsa_qbpager('fi_kilonkipinat_todos_todoitem_dba', 'fi_kilonkipinat_todos_list_my');
        $qb->add_constraint('person', '=', 0);
        $qb->add_constraint('grp', '=', 0);
        $qb->add_constraint('status', '<', FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_ACKNOWLEDGED);
        $qb->add_order('deadline', 'ASC');
        if ($handler_id == 'list_open_count') {
            $qb->results_per_page = $args[0];
        } else {
            $qb->results_per_page = $this->_config->get('index_entries');
        }
        
        $data['todoitems'] = $qb->execute();
        $data['qb'] = $qb;
        $data['handler_id'] = $handler_id;
        
        return true;
    }

    /**
     * This function does the output.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param mixed &$data The local request data.
     */
    function _show_open($handler_id, &$data)
    {
        midcom_show_style('list-open');
    }
    
    /**
     * The handler for the index article.
     *
     * @param mixed $handler_id the array key from the request array
     * @param array $args the arguments given to the handler
     * @param Array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_all($handler_id, $args, &$data)
    {
        $_MIDCOM->auth->require_valid_user();
        $this->_request_data['name']  = "fi.kilonkipinat.todos";
        $this->_component_data['active_leaf'] = "{$this->_topic->id}_LIST_ALL";
        $this->_update_breadcrumb_line($handler_id);
        $title = 'Nakit';
        $_MIDCOM->set_pagetitle(":: {$title}");
        
        $qb = new org_openpsa_qbpager('fi_kilonkipinat_todos_todoitem_dba', 'fi_kilonkipinat_todos_list_my');
        $data['qb'] = $qb;
        $data['filters'] = fi_kilonkipinat_todos_viewer::prepare_todoitem_qb($data, $this->_config);
        $data['qb']->begin_group('OR');
        $data['qb']->add_constraint('visibility', '=', FI_KILONKIPINAT_TODOS_TODOITEM_VISIBILITY_PUBLIC);
        $data['qb']->add_constraint('person', '=', $_MIDGARD['user']);
        $data['qb']->add_constraint('supervisor', '=', $_MIDGARD['user']);
        $data['qb']->end_group();
        $data['qb']->add_order('deadline');
        if ($handler_id == 'list_all_count') {
            $data['qb']->results_per_page = $args[0];
        } elseif (isset($data['filters']['filter_limit'])) {
            $data['qb']->results_per_page = (int) $data['filters']['filter_limit'];
        } else {
            $data['qb']->results_per_page = $this->_config->get('index_entries');
        }
        
        $data['todoitems'] = $data['qb']->execute();
        $data['handler_id'] = $handler_id;
        
        $persons = array();
        
        $root_group = new midcom_db_group($this->_config->get('root_group_to_show'));
        
        $person_ids = array();
        $mc_groups = midcom_db_member::new_collector('sitegroup', $_MIDGARD['sitegroup']);
        $mc_groups->add_constraint('gid', '=', $root_group->id);
        $mc_groups->add_value_property('uid');
        $mc_groups->execute();
        $tmp_keys = $mc_groups->list_keys();

        foreach ($tmp_keys as $guid => $tmp_key)
        {
            $person_id = $mc_groups->get_subkey($guid, 'uid');
            $person_ids[$person_id] = $person_id;
        }
                
        $mc_persons = fi_kilonkipinat_account_person_dba::new_collector('sitegroup', $_MIDGARD['sitegroup']);
        $mc_persons->add_constraint('id', 'IN', $person_ids);
        $mc_persons->add_value_property('id');
        $mc_persons->add_value_property('nickname');
        $mc_persons->add_value_property('firstname');
        $mc_persons->add_value_property('lastname');
        $mc_persons->execute();
        $tmp_persons = $mc_persons->list_keys();

        foreach ($tmp_persons as $guid => $tmp_key)
        {
            $persons[] = array(
                'id' => $mc_persons->get_subkey($guid, 'id'),
                'nickname' => $mc_persons->get_subkey($guid, 'nickname'),
                'firstname' => $mc_persons->get_subkey($guid, 'firstname'),
                'lastname' => $mc_persons->get_subkey($guid, 'lastname'),
            );
        }
        
        $data['persons'] = $persons;
        
        
        
        return true;
    }

    /**
     * This function does the output.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param mixed &$data The local request data.
     */
    function _show_all($handler_id, &$data)
    {
        midcom_show_style('list-all');
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