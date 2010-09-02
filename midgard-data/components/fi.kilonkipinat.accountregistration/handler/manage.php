<?php
/**
 * @package fi.kilonkipinat.accountregistration
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is a URL handler class for fi.kilonkipinat.accountregistration
 *
 * The midcom_baseclasses_components_handler class defines a bunch of helper vars
 *
 * @see midcom_baseclasses_components_handler
 * @see: http://www.midgard-project.org/api-docs/midcom/dev/midcom.baseclasses/midcom_baseclasses_components_handler/
 * 
 * @package fi.kilonkipinat.accountregistration
 */
class fi_kilonkipinat_accountregistration_handler_manage extends midcom_baseclasses_components_handler
{

    /**
     * Datamanager2 to be used for displaying an object used for delete preview
     *
     * @var midcom_helper_datamanager2_datamanager
     * @access private
     */
    var $_datamanager = null;

    /**
     * The Datamanager2 controller of the object used for editing
     *
     * @var midcom_helper_datamanager2_controller_simple
     * @access private
     */
    var $_controller = null;


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
    function _handler_listPending($handler_id, $args, &$data)
    {
        $_MIDCOM->auth->require_admin_user();
        $this->_request_data['name']  = "fi.kilonkipinat.accountregistration";
        $this->_update_breadcrumb_line($handler_id);
        $title = $this->_l10n_midcom->get('fi.kilonkipinat.accountregistration');
        $_MIDCOM->set_pagetitle(":: {$title}");
        $prefix = $this->_request_data['prefix'];
        
        $qb = fi_kilonkipinat_accountregistration_accountrequest_dba::new_query_builder();
        $qb->add_constraint('status', '=', FI_KILONKIPINAT_ACCOUNTREGISTRATION_ACCOUNT_STATUS_EMAILVALIDATED);
        $results = $qb->execute();
        
        $this->_request_data['pending'] = $results;
        
        return true;
    }
    
    function _show_listPending($handler_id, &$data)
    {
        midcom_show_style('list-pending');
    }
    
    /**
     * The handler for the index article.
     *
     * @param mixed $handler_id the array key from the request array
     * @param array $args the arguments given to the handler
     * @param Array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_manageRequest($handler_id, $args, &$data)
    {
        $_MIDCOM->auth->require_admin_user();
        $this->_request_data['name']  = "fi.kilonkipinat.accountregistration";
        $this->_update_breadcrumb_line($handler_id);
        $title = $this->_l10n_midcom->get('fi.kilonkipinat.accountregistration');
        $_MIDCOM->set_pagetitle(":: {$title}");
        $prefix = $this->_request_data['prefix'];
        
        $request = new fi_kilonkipinat_accountregistration_accountrequest_dba(trim($args[0]));
        
        if (   !isset($request)
            || !isset($request->guid)
            || $request->guid == ''
            || $request->guid != $args[0])
        {
            debug_push_class(__CLASS__, __FUNCTION__);
            debug_pop();
            $_MIDCOM->generate_error(MIDCOM_ERRNOTFOUND,
                'Failed to load request, cannot continue. Last Midgard error was: '. midcom_application::get_error_string());
            // This will exit.
        }
        
        $this->_request_data['request'] = $request;

        if (   isset($_POST)
            && isset($_POST['username'])) {
            if (   isset($_POST['isduplicate'])
                && $_POST['isduplicate'] == '1') {
                $request->status = FI_KILONKIPINAT_ACCOUNTREGISTRATION_ACCOUNT_STATUS_INVALID;
                $request->update();
                $message['title'] = $this->_l10n_midcom->get("Poistettu");
                $message['content'] = $this->_l10n_midcom->get("Kyseinen hakemus on merkattu duplikaatiksi, ts poistettu.");
            } else {

                if (isset($_POST['merge_user_guid'])
                    && $_POST['merge_user_guid'] != '') {
                    $person = new fi_kilonkipinat_account_person_dba(trim($_POST['merge_user_guid']));
                } else {
                    $qb = fi_kilonkipinat_account_person_dba::new_query_builder();
                    $qb->add_constraint('username', '=', trim($_POST['username']));
                    $results = $qb->execute();
                    if (count($results)>0) {
                        $message['title'] = $this->_l10n_midcom->get("error");
                        $message['content'] = $this->_l10n_midcom->get("Kyseinen tyyppi on jo olemassa");
                    } else {
                        $person = new fi_kilonkipinat_account_person_dba();
                        $person->username = trim($_POST['username']);
                        $person->create();
                    }
                }
            
                if (isset($person)) {
            
                    $person->firstname = $request->firstname;
                    $person->lastname = $request->lastname;
                    $person->email = $request->email;
            
                    $password = fi_kilonkipinat_accountregistration_viewer::generatePassword($this->_config->get('password_length'));

                    // Enforce crypt mode
                    $salt = chr(rand(64,126)) . chr(rand(64,126));
                    $crypt_password = crypt($password, $salt);
            
                    $person->password = $crypt_password;
            
                    $person->update();
                    if (   isset($_POST['add_to_groups'])
                        && count($_POST['add_to_groups']) > 0) {
                        foreach ($_POST['add_to_groups'] as $group_guid) {
                            $group = new midcom_db_group($group_guid);
                            if (   isset($group)
                                && isset($group->guid)
                                && $group->guid == $group_guid) {
                    
                                $membership = new midcom_db_member();
                                $membership->uid = $person->id;
                                $membership->gid = $group->id;
                                $membership->create();
                            }
                        }
                    }
                
                    $person->set_privilege('midgard:owner', "user:{$person->guid}");
            
                    $request->status = FI_KILONKIPINAT_ACCOUNTREGISTRATION_ACCOUNT_STATUS_RESOLVED;
                    $request->personGuid = $person->guid;
                    $request->update();

                    $subject = 'Tunnuksesi kilonkipinat.fi-sivustolle';
                    $body = sprintf('Hei %s', $person->firstname);
                    $body .= "\n\n";
                    $body .= sprintf('käyttäjätunnus: %s', $person->username);
                    $body .= "\n\n";
                    $body .= sprintf('salasana: %s', $password);
        
                    $mail = new org_openpsa_mail();
                    $mail->from = $this->_config->get('mail_sender_title') . ' <' . $this->_config->get('mail_sender_address') . '>';
                    $mail->to = $person->firstname . ' ' . $person->lastname . ' <' . $person->email . '>';
                    $mail->body = $body;
                    $mail->subject = $subject;

                    $message = array();
                    if ($mail->send('mail')) {
                        $message['title'] = $this->_l10n_midcom->get("Onnistui");
                        $message['content'] = '';
                    } else {
                        $message['title'] = $this->_l10n_midcom->get("error");
                        $message['content'] = $this->_l10n_midcom->get("Oops, something went wrong.");
                    }
                }
            }

            $this->_request_data['message'] = $message;
            
        }

        return true;
    }
    
    function _show_manageRequest($handler_id, &$data)
    {
        midcom_show_style('manage-request');
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