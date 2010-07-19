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
class fi_kilonkipinat_account_handler_jobtitle extends midcom_baseclasses_components_handler_crud
{
    var $_jobtitle = null;
    var $_jobgroup = null;

    function __construct()
    {
        parent::__construct();
    }
    
    public function _load_object($handler_id, $args, &$data)
    {
        $object = new fi_kilonkipinat_account_jobhistory_jobtitle_dba($args[0]);

        if (   isset($object)
            && isset($object->guid)
            && $object->guid == $args[0])
        {
            $this->_object = $object;
            $this->_jobtitle = $this->_object;
            
            $this->_jobgroup = new fi_kilonkipinat_account_jobhistory_jobtitle_dba($this->_object->jobgroup);
        }
        else
        {
            debug_push_class(__CLASS__, __FUNCTION__);
            debug_pop();
            $_MIDCOM->generate_error(MIDCOM_ERRNOTFOUND,
                'Failed to load jobgroup, cannot continue. Last Midgard error was: '. midcom_application::get_error_string());
            // This will exit.
        }

        return $this->_object;
    }
    
    public function _load_parent($handler_id, $args, &$data)
    {
        $this->_parent = $this->_jobgroup;
        return $this->_parent;
    }
    
    public function _load_schemadb()
    {
        $this->_request_data['schemadb_jobhistory_jobtitle'] = midcom_helper_datamanager2_schema::load_database($this->_config->get('schemadb_jobhistory_jobtitle'));

        $this->_schemadb =& $this->_request_data['schemadb_jobhistory_jobtitle'];
    }
    
    public function _get_object_url()
    {
        $prefix = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX);
        $url = $prefix . 'jobhistory/jobtitle/view/' . $this->_jobtitle->guid . '/';
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
            $_MIDCOM->set_pagetitle("{$this->_topic->extra}: {$this->_object->title}");
        }
        return;
    }
    
    function &dm2_create_callback(&$controller)
    {
        $this->_jobtitle = new fi_kilonkipinat_account_jobhistory_jobtitle_dba();
        $this->_jobtitle->jobgroup = 0;

        $this->_jobtitle->_use_activitystream = false;
        $this->_use_activitystream = false;

        if (! $this->_jobtitle->create())
        {
            debug_push_class(__CLASS__, __FUNCTION__);
            debug_print_r('We operated on this object:', $this->_jobtitle);
            debug_pop();
            $_MIDCOM->generate_error(MIDCOM_ERRNOTFOUND,
                'Failed to create a new jobtitle, cannot continue. Last Midgard error was: '. midcom_application::get_error_string());
            // This will exit.
        }

        return $this->_jobtitle;
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
                    MIDCOM_TOOLBAR_URL => "jobhistory/jobtitle/edit/{$this->_object->guid}/",
                    MIDCOM_TOOLBAR_LABEL => 'Muokkaa pestinimikettä',
                    MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.website/fam/page_edit.png',
                )
            );
        }
        if ($this->_topic->can_do('midgard:create'))
        {
            foreach (array_keys($this->_request_data['schemadb_jobhistory_jobtitle']) as $name)
            {
                $this->_view_toolbar->add_item
                (
                    array
                    (
                        MIDCOM_TOOLBAR_URL => "jobhistory/jobtitle/create/{$name}/",
                        MIDCOM_TOOLBAR_LABEL => sprintf
                        (
                            $this->_l10n_midcom->get('create %s'),
                            $this->_request_data['schemadb_jobhistory_jobtitle'][$name]->description
                        ),
                        MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.website/fam/page_add.png',
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
                    MIDCOM_TOOLBAR_URL => "jobhistory/jobtitle/delete/{$this->_object->guid}/",
                    MIDCOM_TOOLBAR_LABEL => 'Poista pestinimike',
                    MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.website/fam/page_delete.png',
                )
            );
        }
    }

    /**
     * Generates an object creation view.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param array $args The argument list.
     * @param array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_create($handler_id, $args, &$data)
    {
		if ($handler_id == 'jobhistory_jobtitle_create_under') {
			$jobgroup = new fi_kilonkipinat_account_jobhistory_jobgroup_dba($args[1]);
			$this->_defaults['jobgroup'] = $jobgroup->id;
		}

        return parent::_handler_create($handler_id, $args, $data);
    }

    public function _show_create($handler_id, &$data)
    {
        midcom_show_style('admin-jobtitle-create');
    }

    public function _show_read($handler_id, &$data)
    {
        $this->_request_data['view_jobtitle'] = $data['datamanager']->get_content_html();
        midcom_show_style('show-jobtitle');
    }

    public function _show_update($handler_id, &$data)
    {
        midcom_show_style('admin-jobtitle-update');
    }

    public function _show_delete($handler_id, &$data)
    {
        $this->_request_data['view_jobtitle'] = $data['datamanager']->get_content_html();
        midcom_show_style('admin-jobtitle-delete');
    }
}

?>