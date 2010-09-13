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
class fi_kilonkipinat_accountregistration_handler_index extends midcom_baseclasses_components_handler
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
        $this->_request_data['name']  = "fi.kilonkipinat.accountregistration";
        $this->_update_breadcrumb_line($handler_id);
        $title = $this->_l10n_midcom->get('fi.kilonkipinat.accountregistration');
        $_MIDCOM->set_pagetitle(":: {$title}");
        $prefix = $this->_request_data['prefix'];

        $this->_request_data['sort_order'] = $this->_config->get('sort_order');
        
        if (   isset($_POST)
            && isset($_POST['action_type'])
            && (   $_POST['action_type'] == 'reset_password'
                || $_POST['action_type'] == 'registration')) {

            $_MIDCOM->auth->request_sudo('fi.kilonkipinat.accountregistration');

            if ($_POST['action_type'] == 'reset_password') {
                if (trim($_POST['username']) == '') {
                    $error_msg = 'Täytä käyttäjätunnus-kenttä';
                } else {
                    $qb = fi_kilonkipinat_account_person_dba::new_query_builder();
                    $qb->add_constraint('username', '=', trim($_POST['username']));
                    $qb->set_limit(1);
                    $user = $qb->execute();
                    if (   isset($user)
                        && count($user) > 0) {

                        $reset_request = new fi_kilonkipinat_accountregistration_resetrequest_dba();
                        $reset_request->username = $user[0]->username;
                        $reset_request->person = $user[0]->id;
                        $reset_request->status = FI_KILONKIPINAT_ACCOUNTREGISTRATION_PASSWORDRESETREQUEST_STATUS_NEW;
                        $reset_request->create();

                        $reset_request_quid = $reset_request->guid;

                        $subject = sprintf('Salasanan vaihto palvelimella %s', $_SERVER['SERVER_NAME']);
                        $body = sprintf('Hei %s', $user[0]->firstname);
                        $body .= "\n\n";
                        $body .= sprintf($this->_l10n_midcom->get('Pyysit salasanasi resetointia palvelimella %s'), $_SERVER['SERVER_NAME']);
                        $body .= "\n\n";
                        $body .= sprintf($this->_l10n_midcom->get('Resetoidaksesi salasanasi käyttäjätunnukselle %s, klikkaa alla olevaa linkkiä'), $user[0]->username);
                        $body .= "\n\n";
                        $body .= 'http://' . $_SERVER['SERVER_NAME'] . $prefix . 'approve_reset/' . $reset_request_quid . '/';
                        
                        $mail = new org_openpsa_mail();
                        $mail->from = $this->_config->get('mail_sender_title') . ' <' . $this->_config->get('mail_sender_address') . '>';
                        $mail->to = $user[0]->firstname . ' ' . $user[0]->lastname . ' <' . $user[0]->email . '>';
                        $mail->body = $body;
                        $mail->subject = $subject;

                        if ($mail->send('mail')) {
                            $success_msg = $this->_l10n_midcom->get("Salasanan resetointipyyntö vastaanotettu, katso sähköpostiasi.");
                        }
                    }
                }

            } elseif ($_POST['action_type'] == 'registration') {
                if (   $_POST['firstname'] == ''
                    || $_POST['lastname'] == ''
                    || $_POST['email'] == '') {
                    $error_msg = 'Täytä kaikki pakolliset kentät';
                } else {
                    $accountrequest = new fi_kilonkipinat_accountregistration_accountrequest_dba();
                    $accountrequest->firstname = $_POST['firstname'];
                    $accountrequest->lastname = $_POST['lastname'];
                    $accountrequest->email = $_POST['email'];
                    $accountrequest->status = FI_KILONKIPINAT_ACCOUNTREGISTRATION_ACCOUNT_STATUS_NEW;
                    $accountrequest->create();

                    $accountrequest_quid = $accountrequest->guid;

                    $subject = sprintf('Käyttäjätunnuksen rekisteröinti palvelimelle %s', $_SERVER['SERVER_NAME']);
                    $body = sprintf('Hei %s', $accountrequest->firstname);
                    $body .= "\n\n";
                    $body .= sprintf($this->_l10n_midcom->get('Käyttäjätunnuksen rekisteröinti palvelimelle %s.'), $_SERVER['SERVER_NAME']);
                    $body .= "\n\n";
                    $body .= $this->_l10n_midcom->get('Varmistaaksesi sähköpostisi, klikkaa alla olevaa linkkiä');
                    $body .= "\n\n";
                    $body .= 'http://' . $_SERVER['SERVER_NAME'] . $prefix . 'validate_email/' . $accountrequest_quid . '/';
                
                    $mail = new org_openpsa_mail();
                    $mail->from = $this->_config->get('mail_sender_title') . ' <' . $this->_config->get('mail_sender_address') . '>';
                    $mail->to = $accountrequest->firstname . ' ' . $accountrequest->lastname . ' <' . $accountrequest->email . '>';
                    $mail->body = $body;
                    $mail->subject = $subject;

                    if ($mail->send('mail')) {
                        $success_msg = 'Käyttäjätunnuksen rekisteröinti vastaanotettu, katso sähköpostisi';
                    }
                }
            }
            
            $_MIDCOM->auth->drop_sudo('fi.kilonkipinat.accountregistration');
        }

        $message = array();

        if (   isset($success_msg)
            && $success_msg != '')
        {
            $message['title'] = 'Onnistui';
            $message['content'] = $success_msg;
            $this->_request_data['message'] = $message;
        }

        if (   isset($error_msg)
            && $error_msg != '')
        {
            $message['title'] = 'Virhe';
            $message['content'] = $error_msg;
            $this->_request_data['message'] = $message;
        }
        
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