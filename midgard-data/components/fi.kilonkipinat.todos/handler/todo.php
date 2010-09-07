<?php
/**
 * @package org.maemo.brainstorm
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * @package org.maemo.brainstorm
 */
class fi_kilonkipinat_todos_handler_todo extends midcom_baseclasses_components_handler_crud
{
    var $_todo = null;

    function __construct()
    {
        parent::__construct();
    }
    
    public function _load_object($handler_id, $args, &$data)
    {
        $qb = fi_kilonkipinat_todos_todoitem_dba::new_query_builder();
        $qb->add_constraint('topic', '=', $this->_request_data['content_topic']->id);
        $qb->add_constraint('guid', '=', $args[0]);
        $qb->set_limit(1);
        $objects = $qb->execute();

        if (   is_array($objects)
            && count($objects) > 0)
        {
            $this->_object = $objects[0];
            $this->_todo = $this->_object;
        }
        else
        {
            debug_push_class(__CLASS__, __FUNCTION__);
            debug_pop();
            $_MIDCOM->generate_error(MIDCOM_ERRNOTFOUND,
                'Failed to load todo, cannot continue. Last Midgard error was: '. midcom_application::get_error_string());
            // This will exit.
        }

        return $this->_object;
    }
    
    public function _load_defaults()
    {
        $this->_defaults['supervisor'] = $_MIDGARD['user'];
        $this->_defaults['weight'] = FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_MEDIUM;
        $now = time(); 
        $two_weeks = 2 * 7 * 24 * 3600;
        $two_weeks_ahead = $now + $two_weeks;
        $this->_defaults['deadline'] = date('Y-m-d', $two_weeks_ahead);
    }
    
    public function _load_parent($handler_id, $args, &$data)
    {
        $this->_parent = $this->_request_data['content_topic'];
        return $this->_parent;
    }
    
    public function _load_schemadb()
    {
        $this->_schemadb =& $this->_request_data['schemadb'];
    }
    
    public function _get_object_url()
    {
        $prefix = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX);
        $url = $prefix . 'view_todo/' . $this->_todo->guid . '/';
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
            if ($handler_id == 'edit_todo') {
                $_MIDCOM->set_pagetitle("{$this->_topic->extra}: " . $this->_l10n_midcom->get('edit todo') . " {$this->_object->title}");
            } elseif ($handler_id == 'delete_todo') {
                $_MIDCOM->set_pagetitle("{$this->_topic->extra}: " . $this->_l10n_midcom->get('delete todo') . " {$this->_object->title}");
            } else {
                $_MIDCOM->set_pagetitle("{$this->_topic->extra}: {$this->_object->title}");
            }
        } elseif ($handler_id == 'create_todo') {
            $_MIDCOM->set_pagetitle("{$this->_topic->extra}: " . $this->_l10n_midcom->get('create todo'));
        }
        return;
    }
    
    function &dm2_create_callback(&$controller)
    {
        $this->_todo = new fi_kilonkipinat_todos_todoitem_dba();
        $this->_todo->topic = $this->_request_data['content_topic']->id;
        
        if (! $this->_todo->create())
        {
            debug_push_class(__CLASS__, __FUNCTION__);
            debug_print_r('We operated on this object:', $this->_todo);
            debug_pop();
            $_MIDCOM->generate_error(MIDCOM_ERRNOTFOUND,
                'Failed to create a new todo, cannot continue. Last Midgard error was: '. midcom_application::get_error_string());
            // This will exit.
        }

        return $this->_todo;
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
                    MIDCOM_TOOLBAR_URL => "edit_todo/{$this->_object->guid}/",
                    MIDCOM_TOOLBAR_LABEL => 'Muokkaa nakkia',
                    MIDCOM_TOOLBAR_ICON => 'stock-icons/16x16/edit.png',
                )
            );
        }
        if ($this->_object->can_do('midgard:delete'))
        {
            $this->_view_toolbar->add_item
            (
                array
                (
                    MIDCOM_TOOLBAR_URL => "delete_todo/{$this->_object->guid}/",
                    MIDCOM_TOOLBAR_LABEL => 'Poista nakki',
                    MIDCOM_TOOLBAR_ICON => 'stock-icons/16x16/trash.png',
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
        $status =  parent::_handler_create($handler_id, $args, $data);
        return $status;
    }

    public function _show_create($handler_id, &$data)
    {
        midcom_show_style('admin-todo-create');
    }
    
    public function _show_read($handler_id, &$data)
    {
        $this->_request_data['view_todo'] = $data['datamanager']->get_content_html();
        midcom_show_style('show-todo');
    }

    /**
     * Generates an object update view.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param array $args The argument list.
     * @param array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_update($handler_id, $args, &$data)
    {
        $status = parent::_handler_update($handler_id, $args, $data);
        $this->_request_data['todo_title'] = $this->_object->title;
        return $status;
    }

    public function _show_update($handler_id, &$data)
    {
        midcom_show_style('admin-todo-update');
    }
    
    public function _show_delete($handler_id, &$data)
    {
        midcom_show_style('admin-todo-delete');
    }
}

?>