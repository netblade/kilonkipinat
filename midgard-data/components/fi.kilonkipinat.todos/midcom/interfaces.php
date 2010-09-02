<?php
/**
 * @package fi.kilonkipinat.todos 
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is the interface class for fi.kilonkipinat.todos
 * 
 * @package fi.kilonkipinat.todos
 */
class fi_kilonkipinat_todos_interface extends midcom_baseclasses_components_interface
{
    /**
     * Constructor, define component name
     */
    function __construct()
    {
        parent::__construct();
        $this->_component = 'fi.kilonkipinat.todos';
    }

    function _on_initialize()
    {
        $this->define_constants();

        return true;
    }
    
    private function define_constants()
    {
        // Type definitions for events
        define('FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_NEW', 1000);
        define('FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_PENDING', 1010);
        define('FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_ACKNOWLEDGED', 1020);
        define('FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_RESOLVED', 1040);
    }
}
?>