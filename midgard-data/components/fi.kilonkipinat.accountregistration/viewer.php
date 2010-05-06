<?php
/**
 * @package fi.kilonkipinat.accountregistration
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is the class that defines which URLs should be handled by this module.
 *
 * @package fi.kilonkipinat.accountregistration
 */
class fi_kilonkipinat_accountregistration_viewer extends midcom_baseclasses_components_request
{
    function __construct($topic, $config)
    {
        parent::__construct($topic, $config);
    }

    /**
     * Initialize the request switch and the content topic.
     *
     * @access protected
     */
    function _on_initialize()
    {
        $this->_request_data['content_topic'] = $this->_topic;
        /**
         * Prepare the request switch, which contains URL handlers for the component
         */

         // Handle /config/
         $this->_request_switch['config'] = array
         (
             'handler' => array('midcom_core_handler_configdm2', 'config'),
             'schema' => 'config',
             'fixed_args' => array('config'),
         );

        // Handle /
        $this->_request_switch['index'] = array
        (
            'handler' => array('fi_kilonkipinat_accountregistration_handler_index', 'index'),
        );
        
        // Handle /validate_email/<GUID>/
        $this->_request_switch['validate_email'] = array
        (
            'handler' => array('fi_kilonkipinat_accountregistration_handler_actions', 'validateEmail'),
            'fixed_args' => array('validate_email'),
            'variable_args' => 1,
        );

        // Handle /approve_reset/<GUID>/
        $this->_request_switch['approve_reset'] = array
        (
            'handler' => array('fi_kilonkipinat_accountregistration_handler_actions', 'approveReset'),
            'fixed_args' => array('approve_reset'),
            'variable_args' => 1,
        );

        // Handle /list_pending/
        $this->_request_switch['list_pending'] = array
        (
            'handler' => array('fi_kilonkipinat_accountregistration_handler_manage', 'listPending'),
            'fixed_args' => array('list_pending'),
            'variable_args' => 0,
        );

        // Handle /manage_request/<GUID>
        $this->_request_switch['manage_request'] = array
        (
            'handler' => array('fi_kilonkipinat_accountregistration_handler_manage', 'manageRequest'),
            'fixed_args' => array('manage_request'),
            'variable_args' => 1,
        );
    }

    /**
     * Populates the node toolbar depending on the user's rights.
     *
     * @access protected
     */
    function _populate_node_toolbar()
    {
        if (   $this->_topic->can_do('midgard:update')
            && $this->_topic->can_do('midcom:component_config'))
        {
            $this->_node_toolbar->add_item
            (
                array
                (
                    MIDCOM_TOOLBAR_URL => 'config/',
                    MIDCOM_TOOLBAR_LABEL => $this->_l10n_midcom->get('component configuration'),
                    MIDCOM_TOOLBAR_HELPTEXT => $this->_l10n_midcom->get('component configuration helptext'),
                    MIDCOM_TOOLBAR_ICON => 'stock-icons/16x16/stock_folder-properties.png',
                )
            );
        }
        
        if (   $this->_topic->can_do('midgard:update')
            && $this->_topic->can_do('midcom:component_config'))
        {
            $this->_node_toolbar->add_item
            (
                array
                (
                    MIDCOM_TOOLBAR_URL => 'list_pending/',
                    MIDCOM_TOOLBAR_LABEL => 'Listaa tunnuspyynnöt',
                    MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.accountregistration/user_add.png',
                )
            );
        }

    }

    function _on_handle($handler, $args)
    {
        $this->_request_data['prefix'] = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX);
        $this->_populate_node_toolbar();
        
        $_MIDCOM->add_link_head(array('rel' => 'stylesheet',  'type' => 'text/css', 'href' => MIDCOM_STATIC_URL . '/fi.kilonkipinat.accountregistration/fi_kilonkipinat_accountregistration.css', 'media' => 'all'));

        return true;
    }

    public function cleanUserNameStr($str = '')
    {
        $clean_str = str_replace(' ', '', $str);
        $clean_str = str_replace('ä', 'a', $str);
        $clean_str = str_replace('ö', 'o', $str);
        $clean_str = str_replace('Ä', 'a', $str);
        $clean_str = str_replace('Ö', 'o', $str);
        $clean_str = str_replace('Å', 'a', $str);
        $clean_str = str_replace('å', 'a', $str);
        $clean_str = ereg_replace("[^A-Za-z0-9 _]", "", $clean_str); 
        $clean_str = strtolower($clean_str);
        return $clean_str;
    }

    /**
     * Static method for generating one password
     *
     * @access public
     * @static
     * @param int $length
     */
    public function generatePassword($length = 8, $no_similars = true, $strong = true)
    {
        if (!is_int($length)
            || $length < 8) {
            $length = 8;
        }

        $similars = array
        (
            'I', 'l', '1', '0', 'O',
        );

        $string = '';
        for ($x = 0; $x < (int) $length; $x++)
        {
            $rand = (int) rand(48, 122);
            $char = chr($rand);

            $k = 0;

            while (   !preg_match('/[a-zA-Z0-9]/', $char)
                   || (   $strong
                       && strlen($string) > 0
                       && strstr($string, $char))
                   || (   $no_similars
                       && in_array($char, $similars)))
            {
                $rand = (int) rand(48, 122);
                $char = chr($rand);

                $k++;
            }
            $string .= $char;
        }

        return $string;
    }

}

?>