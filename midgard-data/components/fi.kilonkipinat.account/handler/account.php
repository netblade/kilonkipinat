<?php
/**
 * @package fi.kilonkipinat.account
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is a URL handler class for fi.kilonkipinat.account
 *
 * The midcom_baseclasses_components_handler class defines a bunch of helper vars
 *
 * @see midcom_baseclasses_components_handler
 * @see: http://www.midgard-project.org/api-docs/midcom/dev/midcom.baseclasses/midcom_baseclasses_components_handler/
 * 
 * @package fi.kilonkipinat.account
 */
class fi_kilonkipinat_account_handler_account extends midcom_baseclasses_components_handler
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
     * The handler for the own details.
     *
     * @param mixed $handler_id the array key from the request array
     * @param array $args the arguments given to the handler
     * @param Array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_ownDetails($handler_id, $args, &$data)
    {
        $this->_request_data['name']  = "fi.kilonkipinat.account";
        $title = $this->_l10n_midcom->get('index');
        $_MIDCOM->set_pagetitle(":: {$title}");
        
        $person = new fi_kilonkipinat_account_person_dba($_MIDGARD['user']);
        if ($person) {
            $_MIDCOM->relocate($this->_request_data['prefix'] . 'person/view/' . $person->guid . '/');
        } else {
            $_MIDCOM->relocate($this->_request_data['prefix']);
        }
        
        return true;
    }

    /**
     * The handler for the own details.
     *
     * @param mixed $handler_id the array key from the request array
     * @param array $args the arguments given to the handler
     * @param Array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_changePassword($handler_id, $args, &$data)
    {
        $this->_request_data['name']  = "fi.kilonkipinat.account";
        $title = $this->_l10n_midcom->get('index');
        $_MIDCOM->set_pagetitle(":: {$title}");
        
        $this->_component_data['active_leaf'] = "change_password";
        $message = '';
        
        $person = new fi_kilonkipinat_account_person_dba($_MIDGARD['user']);
        if (   isset($_POST)
            && isset($_POST['old_pass'])
            && $_POST['old_pass'] != '') {

            $old_pass = trim($_POST['old_pass']);
            $auth_user = midgard_user::auth($person->username, $old_pass, self::sitegroup_for_auth(), false);
            
            if (!$auth_user) {
                $message = '<h3>Virhe</h3>Väärä vanha salasana!!!';
            } elseif (   isset($_POST['new_pass'])
                      && isset($_POST['new_pass2'])
                      && strlen(trim($_POST['new_pass'])) >= $this->_config->get('password_min_length')) {
                $new_pass = trim($_POST['new_pass']);
                $new_pass2 = trim($_POST['new_pass2']);
                
                if ($new_pass == $new_pass2) {
                    // Enforce crypt mode
                    $salt = chr(rand(64,126)) . chr(rand(64,126));
                    $crypt_password = crypt($new_pass, $salt);

                    $person->password = $crypt_password;

                    $person->update();
                    $message = '<h3>Salasana vaihdettu</h3>';
                    $_MIDCOM->auth->_auth_backend->create_login_session($person->username, $new_pass);
                } else {
                    $message = '<h3>Virhe</h3>Varmistussalasana ei täsmää';
                }
            } else {
                $message = '<h3>Virhe</h3>Uusi salasana liian lyhyt';
            }
        }

        $this->_request_data['person'] = $person;
        $this->_request_data['messages'] = $message;

        return true;
    }
    
    private static function sitegroup_for_auth()
    {
        $mode = $GLOBALS['midcom_config']['auth_sitegroup_mode'];

        if ($mode == 'auto')
        {
            $mode = ($_MIDGARD['sitegroup'] == 0) ? 'not-sitegrouped' : 'sitegrouped';
        }

        if ($mode == 'sitegrouped')
        {
            $sitegroup = new midgard_sitegroup($_MIDGARD['sitegroup']);
            return $sitegroup->name;
        }

        return '';
    }

    /**
     * This function does the output.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param mixed &$data The local request data.
     */
    function _show_changePassword($handler_id, &$data)
    {
        midcom_show_style('change-password');
    }
}
?>