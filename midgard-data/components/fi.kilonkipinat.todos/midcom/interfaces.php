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
        define('FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_PENDING', 1100);
        define('FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_ACKNOWLEDGED', 1200);
        define('FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_RESOLVED', 1400);

        define('FI_KILONKIPINAT_TODOS_TODOITEM_RELATED_LINKTYPE_PENDING', 1000);
        define('FI_KILONKIPINAT_TODOS_TODOITEM_RELATED_LINKTYPE_DUPLICATE', 1100);
        
        define('FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_ULTRALIGHT', 1000);
        define('FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_LIGHT', 1100);
        define('FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_MEDIUM', 1200);
        define('FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_HEAVY', 1300);
        define('FI_KILONKIPINAT_TODOS_TODOITEM_WEIGHT_SUPERHEAVY', 1400);
    }
    
    /**
     * Simple lookup method which tries to map the guid to an article of out topic.
     */
    function _on_resolve_permalink($topic, $config, $guid)
    {    
        $event = new fi_kilonkipinat_todos_todoitem_dba($guid);
        if (!$event)
        {
            return null;
        }
        
        if ($event->topic != $topic->id)
        {
            return null;
        }
        
        return "view_todo/{$event->guid}/";
    }
}
?>