<?php
/**
 * @package fi.kilonkipinat.forms
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is a URL handler class for fi.kilonkipinat.forms
 *
 * The midcom_baseclasses_components_handler class defines a bunch of helper vars
 *
 * @see midcom_baseclasses_components_handler
 * @see: http://www.midgard-project.org/api-docs/midcom/dev/midcom.baseclasses/midcom_baseclasses_components_handler/
 * 
 * @package fi.kilonkipinat.forms
 */
class fi_kilonkipinat_forms_handler_index extends midcom_baseclasses_components_handler
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
        $this->_request_data['name']  = "fi.kilonkipinat.forms";
        $this->_update_breadcrumb_line($handler_id);
        $title = $this->_l10n_midcom->get('index');
        $_MIDCOM->set_pagetitle(":: {$title}");
        
        $my_forms = array();
        
        if ($_MIDGARD['user']) {

            $current_person = new midcom_db_person($_MIDGARD['user']);

            $qb_expence_lpk = fi_kilonkipinat_forms_expense_lpk_dba::new_query_builder();
            $qb_expence_lpk->add_constraint('metadata.creator', '=', $current_person->guid);
            $forms_expence_lpk = $qb_expence_lpk->execute();
            if (count($forms_expence_lpk)>0) {
                $my_forms['expence_lpk'] = $forms_expence_lpk;
            }
            
            $qb_expence_group = fi_kilonkipinat_forms_expense_group_dba::new_query_builder();
            $qb_expence_group->add_constraint('metadata.creator', '=', $current_person->guid);
            $forms_expence_group = $qb_expence_group->execute();
            if (count($forms_expence_group)>0) {
                $my_forms['expence_group'] = $forms_expence_group;
            }
            
        }
        
        $this->_request_data['my_forms'] = $my_forms;

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
        // hint: look in the style/index.php file to see what happens here.
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