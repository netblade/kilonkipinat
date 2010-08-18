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
class fi_kilonkipinat_forms_handler_expense_lpk extends midcom_baseclasses_components_handler_crud
{
    var $_jobgroup = null;

    function __construct()
    {
        parent::__construct();
    }
    
    public function _load_object($handler_id, $args, &$data)
    {
        $object = new fi_kilonkipinat_forms_expense_lpk_dba($args[0]);

        if (   isset($object)
            && isset($object->guid)
            && $object->guid == $args[0])
        {
            $this->_object = $object;
            $this->_expensereport = $this->_object;
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
        $this->_parent = $this->_request_data['content_topic'];
        return $this->_parent;
    }
    public function _load_defaults()
    {
        $person = new fi_kilonkipinat_account_person_dba($_MIDGARD['user']);
        if ($person->guid != '') {
            $this->_defaults['person'] = $person->firstname . ' ' . $person->lastname;
            $this->_defaults['reporter'] = $person->firstname . ' ' . $person->lastname;
            $this->_defaults['accountNumber'] = $person->bankAccountNumber;
        }
        $this->_defaults['place'] = 'Espoo';
        $this->_defaults['date'] = date('Y-m-d', time());
    }
    
    
    public function _load_schemadb()
    {
        $this->_request_data['schemadb_expense_lpk'] = midcom_helper_datamanager2_schema::load_database($this->_config->get('schemadb_expense_lpk'));

        $this->_schemadb =& $this->_request_data['schemadb_expense_lpk'];
    }
    
    public function _get_object_url()
    {
        $prefix = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX);
        $url = $prefix . 'expense/lpk/view/' . $this->_expensereport->guid . '/';
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
        $this->_expensereport = new fi_kilonkipinat_forms_expense_lpk_dba();

        $this->_expensereport->_use_activitystream = false;
        $this->_use_activitystream = false;

        if (! $this->_expensereport->create())
        {
            debug_push_class(__CLASS__, __FUNCTION__);
            debug_print_r('We operated on this object:', $this->_expensereport);
            debug_pop();
            $_MIDCOM->generate_error(MIDCOM_ERRNOTFOUND,
                'Failed to create a new jobgroup, cannot continue. Last Midgard error was: '. midcom_application::get_error_string());
            // This will exit.
        }

        return $this->_expensereport;
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
                    MIDCOM_TOOLBAR_URL => "expense/lpk/edit/{$this->_object->guid}/",
                    MIDCOM_TOOLBAR_LABEL => 'Muokkaa kulukorvauslomaketta',
                    MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.website/fam/page_edit.png',
                )
            );
        }
        if ($this->_topic->can_do('midgard:create'))
        {
            foreach (array_keys($this->_request_data['schemadb_expense_lpk']) as $name)
            {
                $this->_view_toolbar->add_item
                (
                    array
                    (
                        MIDCOM_TOOLBAR_URL => "expense/lpk/create/{$name}/",
                        MIDCOM_TOOLBAR_LABEL => sprintf
                        (
                            $this->_l10n_midcom->get('create %s'),
                            $this->_request_data['schemadb_expense_lpk'][$name]->description
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
                    MIDCOM_TOOLBAR_URL => "expense/lpk/delete/{$this->_object->guid}/",
                    MIDCOM_TOOLBAR_LABEL => 'Poista kulukorvauslomake',
                    MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.website/fam/page_delete.png',
                )
            );
        }
    }

    public function _show_create($handler_id, &$data)
    {
        midcom_show_style('admin-expense-lpk-create');
    }

    public function _show_read($handler_id, &$data)
    {
        $this->_request_data['view_expensereport'] = $data['datamanager']->get_content_html();
        midcom_show_style('show-expense-lpk');
    }

    public function _show_update($handler_id, &$data)
    {
        midcom_show_style('admin-expense-lpk-update');
    }

    public function _show_delete($handler_id, &$data)
    {
        $this->_request_data['view_expensereport'] = $data['datamanager']->get_content_html();
        midcom_show_style('admin-expense-lpk-delete');
    }
}

?>