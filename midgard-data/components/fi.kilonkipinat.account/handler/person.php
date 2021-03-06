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
class fi_kilonkipinat_account_handler_person extends midcom_baseclasses_components_handler_crud
{
    var $_person = null;

    function __construct()
    {
        parent::__construct();
    }
    
    public function _load_object($handler_id, $args, &$data)
    {
        $object = new fi_kilonkipinat_account_person_dba($args[0]);

        if (   isset($object)
            && isset($object->guid)
            && $object->guid == $args[0])
        {
            $this->_object = $object;
            $this->_person = $this->_object;
        }
        else
        {
            debug_push_class(__CLASS__, __FUNCTION__);
            debug_pop();
            $_MIDCOM->generate_error(MIDCOM_ERRNOTFOUND,
                'Failed to load person, cannot continue. Last Midgard error was: '. midcom_application::get_error_string());
            // This will exit.
        }

        return $this->_object;
    }
    
    public function _load_parent($handler_id, $args, &$data)
    {
        $this->_parent = $this->_request_data['content_topic'];
        return $this->_parent;
    }
    
    public function _load_schemadb()
    {
        $this->_request_data['schemadb_person'] = midcom_helper_datamanager2_schema::load_database($this->_config->get('schemadb_person'));

        $this->_schemadb =& $this->_request_data['schemadb_person'];
    }
    
    public function _get_object_url()
    {
        $prefix = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX);
        $url = $prefix . 'person/view/' . $this->_person->guid . '/';
        return $url;
    }
    
    public function _update_breadcrumb($handler_id)
    {
        return;
    }
    
    public function _update_title($handler_id)
    {
        if (isset($this->_object))
        {
            $_MIDCOM->set_pagetitle("{$this->_topic->extra}: {$this->_object->firstname} {$this->_object->lastname}");
        }
        return;
    }
    
    function &dm2_create_callback(&$controller)
    {
        $this->_person = new fi_kilonkipinat_account_person_dba();

        $this->_person->_use_activitystream = false;
        $this->_use_activitystream = false;

        if (! $this->_person->create())
        {
            debug_push_class(__CLASS__, __FUNCTION__);
            debug_print_r('We operated on this object:', $this->_person);
            debug_pop();
            $_MIDCOM->generate_error(MIDCOM_ERRNOTFOUND,
                'Failed to create a new idea, cannot continue. Last Midgard error was: '. midcom_application::get_error_string());
            // This will exit.
        }

        return $this->_person;
    }
    
    public function _populate_toolbar($handler_id)
    {
        if (!$this->_object)
        {
            return;
        }
        if ($this->_object->can_do('midgard:update'))
        {
            $this->_view_toolbar->add_item
            (
                array
                (
                    MIDCOM_TOOLBAR_URL => "person/edit/{$this->_object->guid}/",
                    MIDCOM_TOOLBAR_LABEL => 'Muokkaa henkilöä',
                    MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.website/fam/user_edit.png',
                )
            );
        }
        if ($this->_topic->can_do('midgard:create'))
        {
            foreach (array_keys($this->_request_data['schemadb_person']) as $name)
            {
                $this->_view_toolbar->add_item
                (
                    array
                    (
                        MIDCOM_TOOLBAR_URL => "person/create/{$name}/",
                        MIDCOM_TOOLBAR_LABEL => sprintf
                        (
                            $this->_l10n_midcom->get('create %s'),
                            $this->_request_data['schemadb_person'][$name]->description
                        ),
                        MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.website/fam/user_add.png',
                    )
                );
            }
        }
        if ($this->_object->can_do('midgard:delete'))
        {
            $this->_view_toolbar->add_item
            (
                array
                (
                    MIDCOM_TOOLBAR_URL => "person/delete/{$this->_object->guid}/",
                    MIDCOM_TOOLBAR_LABEL => 'Poista käyttäjä',
                    MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.website/fam/user_delete.png',
                )
            );
        }
        if ($this->_object->can_do('midgard:update'))
        {
            foreach (array_keys($this->_request_data['schemadb_jobhistory_job']) as $name)
            {
                $this->_view_toolbar->add_item
                (
                    array
                    (
                        MIDCOM_TOOLBAR_URL => "jobhistory/job/create_for/{$name}/{$this->_object->guid}",
                        MIDCOM_TOOLBAR_LABEL => sprintf
                        (
                            $this->_l10n_midcom->get('create %s'),
                            $this->_request_data['schemadb_jobhistory_job'][$name]->description
                        ),
                        MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.website/fam/tag_blue_add.png',
                    )
                );
            }
        }
    }

    public function _show_create($handler_id, &$data)
    {
        midcom_show_style('admin-person-create');
    }
    
    public function _handler_read($handler_id, $args, &$data)
    {
        $status = parent::_handler_read($handler_id, $args, $data);
        if ($_MIDGARD['user'] == $this->_person->id) {
            $this->_component_data['active_leaf'] = "own_details";
        }
        return $status;
    }

    public function _show_read($handler_id, &$data)
    {
        $this->_request_data['view_person'] = $data['datamanager']->get_content_html();
        midcom_show_style('show-person');
    }

    public function _handler_update($handler_id, $args, &$data)
    {
        $status = parent::_handler_update($handler_id, $args, $data);
        if ($_MIDGARD['user'] == $this->_person->id) {
            $this->_component_data['active_leaf'] = "own_details";
        }
        return $status;
    }

    public function _show_update($handler_id, &$data)
    {
        midcom_show_style('admin-person-update');
    }

    public function _show_delete($handler_id, &$data)
    {
        $this->_request_data['view_person'] = $data['datamanager']->get_content_html();
        midcom_show_style('admin-person-delete');
    }
    
    public function _handler_viewActivity($handler_id, $args, &$data)
    {
        $status = parent::_handler_read($handler_id, $args, $data);
        if ($_MIDGARD['user'] == $this->_person->id) {
            $this->_component_data['active_leaf'] = "own_details";
        }
        
        $qb_latest = new org_openpsa_qbpager('midcom_helper_activitystream_activity_dba', 'activity');
        $qb_latest->add_order('metadata.revised', 'DESC');
        $qb_latest->add_constraint('actor', '=', $this->_object->id);
        $qb_latest->set_limit($this->_config->get('activity_results_per_page'));
        $qb_latest->results_per_page = $this->_config->get('activity_results_per_page');

        $latest = $qb_latest->execute();
        
        $this->_request_data['qb'] = $qb_latest;
        $this->_request_data['items'] = $latest;
        
        return $status;
    }

    public function _show_viewActivity($handler_id, &$data)
    {
        $this->_request_data['view_person'] = $data['datamanager']->get_content_html();
        midcom_show_style('show-person-activity');
    }
}

?>