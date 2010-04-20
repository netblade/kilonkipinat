<?php
/**
 * @package fi.kilonkipinat.emailmappings
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is a URL handler class for fi.kilonkipinat.emailmappings
 *
 * The midcom_baseclasses_components_handler class defines a bunch of helper vars
 *
 * @see midcom_baseclasses_components_handler
 * @see: http://www.midgard-project.org/api-docs/midcom/dev/midcom.baseclasses/midcom_baseclasses_components_handler/
 * 
 * @package fi.kilonkipinat.emailmappings
 */
class fi_kilonkipinat_emailmappings_handler_index extends midcom_baseclasses_components_handler
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
        $this->_request_data['name']  = "fi.kilonkipinat.emailmappings";
        $this->_update_breadcrumb_line($handler_id);
        $title = $this->_l10n_midcom->get('index');
        $_MIDCOM->set_pagetitle(":: {$title}");
        
        $last_update = exec('stat -c %Y /root/mailaliases/aliases.db');
        $this->_request_data['last_update'] = $last_update;
        
        $last_change = exec('stat -c %Y /root/mailaliases/aliases_automatic');
        $this->_request_data['last_change'] = $last_change;

        $row = 1;
        $filename = '/root/mailaliases/aliases_automatic';
        $file = fopen($filename, 'r');
        $automatic_mappings = array();
        while (($file_data = fgetcsv($file, 250, ":")) !== FALSE) {
            if (   !is_array($file_data)
                || !isset($file_data[0])
                || !isset($file_data[1])) {
                continue;
            }
            $automatic_mappings[] = array
            (
                'name' => trim($file_data[0]),
                'email' => trim($file_data[1]),
            );
        }
        fclose($file);
        $this->_request_data['automatic_mappings'] = $automatic_mappings;
        
        
        $row = 1;
        $filename = '/root/mailaliases/aliases_mappings';
        $file = fopen($filename, 'r');
        $additional_mappings = array();
        while (($file_data = fgetcsv($file, 250, ":")) !== FALSE) {
            if (   !is_array($file_data)
                || !isset($file_data[0])
                || !isset($file_data[1])) {
                continue;
            }
            $additional_mappings[] = array
            (
                'name' => trim($file_data[0]),
                'emails' => trim($file_data[1]),
            );
        }
        fclose($file);
        $this->_request_data['additional_mappings'] = $additional_mappings;

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