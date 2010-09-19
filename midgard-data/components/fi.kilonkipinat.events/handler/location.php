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
class fi_kilonkipinat_events_handler_location extends midcom_baseclasses_components_handler_crud
{

    function __construct()
    {
        parent::__construct();
    }
    
    public function _load_object($handler_id, $args, &$data)
    {
        if (is_numeric($args[0])) {
            $object = new fi_kilonkipinat_events_location_dba((int)$args[0]);
        } else {
            $object = new fi_kilonkipinat_events_location_dba($args[0]);
        }

        if (   isset($object)
            && isset($object->guid)
            && (   $object->guid == $args[0]
                || $object->id == $args[0]))
        {
            $this->_object = $object;
            $this->_location = $this->_object;
        }
        else
        {
            debug_push_class(__CLASS__, __FUNCTION__);
            debug_pop();
            $_MIDCOM->generate_error(MIDCOM_ERRNOTFOUND,
                'Failed to load location, cannot continue. Last Midgard error was: '. midcom_application::get_error_string());
            // This will exit.
        }
        $this->_component_data['active_leaf'] = "{$this->_topic->id}_LOCATIONS";
        return $this->_object;
    }
    
    public function _load_defaults()
    {
        $this->_defaults['locationzoom'] = 14;
    }
    
    public function _load_parent($handler_id, $args, &$data)
    {        
        return true;
    }
    
    public function _load_schemadb()
    {
        $this->_request_data['schemadb_location'] = midcom_helper_datamanager2_schema::load_database($this->_config->get('schemadb_location'));

        $this->_schemadb =& $this->_request_data['schemadb_location'];
    }
    
    public function _get_object_url()
    {
        $prefix = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX);
        $url = $prefix . 'location/view/' . $this->_location->guid . '/';
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
            $_MIDCOM->set_pagetitle("{$this->_topic->extra}: Paikka: {$this->_object->title}");
        }
        return;
    }
    
    function &dm2_create_callback(&$controller)
    {
        $this->_location = new fi_kilonkipinat_events_location_dba();

        $this->_location->_use_activitystream = false;
        $this->_use_activitystream = false;

        if (! $this->_location->create())
        {
            debug_push_class(__CLASS__, __FUNCTION__);
            debug_print_r('We operated on this object:', $this->_location);
            debug_pop();
            $_MIDCOM->generate_error(MIDCOM_ERRNOTFOUND,
                'Failed to create a new location, cannot continue. Last Midgard error was: '. midcom_application::get_error_string());
            // This will exit.
        }

        return $this->_location;
    }
    
    public function _populate_toolbar($handler_id)
    {
        if ($this->_object)
        {
            if ($this->_object->can_do('midgard:update'))
            {
                $this->_view_toolbar->add_item
                (
                    array
                    (
                        MIDCOM_TOOLBAR_URL => "location/edit/{$this->_object->guid}/",
                        MIDCOM_TOOLBAR_LABEL => 'Muokkaa paikkaa',
                        MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.website/fam/map_edit.png',
                    )
                );
            }
            if ($this->_object->can_do('midgard:delete'))
            {
                $this->_view_toolbar->add_item
                (
                    array
                    (
                        MIDCOM_TOOLBAR_URL => "location/delete/{$this->_object->guid}/",
                        MIDCOM_TOOLBAR_LABEL => 'Poista paikka',
                        MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.website/fam/map_delete.png',
                    )
                );
            }
        }
        if ($this->_topic->can_do('midgard:create'))
        {
            foreach (array_keys($this->_request_data['schemadb_location']) as $name)
            {
                $this->_view_toolbar->add_item
                (
                    array
                    (
                        MIDCOM_TOOLBAR_URL => "location/create/{$name}/",
                        MIDCOM_TOOLBAR_LABEL => sprintf
                        (
                            $this->_l10n_midcom->get('create %s'),
                            $this->_request_data['schemadb_location'][$name]->description
                        ),
                        MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.website/fam/map_add.png',
                    )
                );
            }
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
        $_MIDCOM->auth->require_valid_user();
        return parent::_handler_create($handler_id, $args, $data);
    }

    public function _show_create($handler_id, &$data)
    {
        midcom_show_style('admin-location-create');
    }

    public function _show_read($handler_id, &$data)
    {
        $this->_request_data['view_location'] = $data['datamanager']->get_content_html();
        if ($handler_id == 'view_location_dl') {
            midcom_show_style('show-location-dl');
        } else {
            $_MIDCOM->auth->require_valid_user();
            midcom_show_style('show-location');
        }
    }

    public function _show_update($handler_id, &$data)
    {
        $_MIDCOM->auth->require_valid_user();
        midcom_show_style('admin-location-update');
    }

    public function _show_delete($handler_id, &$data)
    {
        $_MIDCOM->auth->require_valid_user();
        $this->_request_data['view_location'] = $data['datamanager']->get_content_html();
        midcom_show_style('admin-location-delete');
    }
    
    /**
     * The handler for the index event.
     *
     * @param mixed $handler_id the array key from the request array
     * @param array $args the arguments given to the handler
     * @param Array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_index($handler_id, $args, &$data)
    {
        $_MIDCOM->auth->require_valid_user();
        $this->_component_data['active_leaf'] = "{$this->_topic->id}_LOCATIONS";
        $this->_request_data['name']  = "fi.kilonkipinat.events";
        
        $_MIDCOM->set_pagetitle("{$this->_topic->extra}");
        
        $this->_populate_toolbar($handler_id);
        
        $qb_locations = fi_kilonkipinat_events_location_dba::new_query_builder();
        $locations = $qb_locations->execute();

        $this->_request_data['locations'] = $locations;

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
        midcom_show_style('locations-index');
    }
}

?>
