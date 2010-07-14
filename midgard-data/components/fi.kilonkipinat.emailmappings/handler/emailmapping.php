<?php
/**
 * @package fi.kilonkipinat.emailmappings
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * @package fi.kilonkipinat.emailmappings
 */
class fi_kilonkipinat_emailmappings_handler_emailmapping extends midcom_baseclasses_components_handler_crud
{
    var $_emailmapping = null;

    function __construct()
    {
        parent::__construct();
    }
    
    public function _load_object($handler_id, $args, &$data)
    {
        $qb = fi_kilonkipinat_emailmappings_emailmapping_dba::new_query_builder();
        $qb->add_constraint('guid', '=', $args[0]);
        $qb->set_limit(1);
        $objects = $qb->execute();

        if (   is_array($objects)
            && count($objects)>0)
        {
            $this->_object = $objects[0];
            $this->_emailmapping = $this->_object;
        }
        else
        {
            debug_push_class(__CLASS__, __FUNCTION__);
            debug_pop();
            $_MIDCOM->generate_error(MIDCOM_ERRNOTFOUND,
                'Failed to load emailmapping, cannot continue. Last Midgard error was: '. midcom_application::get_error_string());
            // This will exit.
        }

        return $this->_object;
    }
    
    public function _load_parent($handler_id, $args, &$data)
    {
        return null;
    }
    
    public function _load_schemadb()
    {
        $this->_request_data['schemadb'] = midcom_helper_datamanager2_schema::load_database($this->_config->get('schemadb'));

        $this->_schemadb =& $this->_request_data['schemadb'];
    }
    
    public function _get_object_url()
    {
        $prefix = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX);
        $url = $prefix . 'emailmapping/view/' . $this->_emailmapping->guid . '/';
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
            $_MIDCOM->set_pagetitle("{$this->_topic->extra}: {$this->_object->name}");
        }
        return;
    }
    
    function &dm2_create_callback(&$controller)
    {
        $this->_emailmapping = new fi_kilonkipinat_emailmappings_emailmapping_dba();

/*        $this->_emailmapping->_use_activitystream = false;
        $this->_use_activitystream = false;*/

        if (! $this->_emailmapping->create())
        {
            debug_push_class(__CLASS__, __FUNCTION__);
            debug_print_r('We operated on this object:', $this->_emailmapping);
            debug_pop();
            $_MIDCOM->generate_error(MIDCOM_ERRNOTFOUND,
                'Failed to create a new idea, cannot continue. Last Midgard error was: '. midcom_application::get_error_string());
            // This will exit.
        }

        return $this->_emailmapping;
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
                    MIDCOM_TOOLBAR_URL => "emailmapping/edit/{$this->_object->guid}/",
                    MIDCOM_TOOLBAR_LABEL => 'Muokkaa sähköpostiohjausta',
                    MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.emailmappings/fam/email_edit.png',
                )
            );
        }
        if ($this->_object->can_do('midgard:delete'))
        {
            $this->_view_toolbar->add_item
            (
                array
                (
                    MIDCOM_TOOLBAR_URL => "emailmapping/delete/{$this->_object->guid}/",
                    MIDCOM_TOOLBAR_LABEL => 'Poista sähköpostiohjaus',
                    MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.emailmappings/fam/email_edit.png',
                )
            );
        }
        if ($this->_topic->can_do('midgard:create'))
        {
            foreach (array_keys($this->_request_data['schemadb']) as $name)
            {
                $this->_view_toolbar->add_item
                (
                    array
                    (
                        MIDCOM_TOOLBAR_URL => "emailmapping/create/{$name}/",
                        MIDCOM_TOOLBAR_LABEL => sprintf
                        (
                            $this->_l10n_midcom->get('create %s'),
                            $this->_request_data['schemadb'][$name]->description
                        ),
                        MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.emailmappings/fam/email_go.png',
                    )
                );
            }
        }
    }

    public function _show_create($handler_id, &$data)
    {
        midcom_show_style('admin-emailmapping-create');
    }
    
    public function _show_read($handler_id, &$data)
    {
        $this->_request_data['view_emailmapping'] = $data['datamanager']->get_content_html();
        midcom_show_style('show-emailmapping');
    }

    public function _show_update($handler_id, &$data)
    {
        midcom_show_style('admin-emailmapping-update');
    }

    public function _show_delete($handler_id, &$data)
    {
        $this->_request_data['view_emailmapping'] = $data['datamanager']->get_content_html();
        midcom_show_style('admin-emailmapping-delete');
    }
}

?>