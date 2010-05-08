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
class fi_kilonkipinat_accountregistration_handler_actions extends midcom_baseclasses_components_handler
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
    function _handler_validateEmail($handler_id, $args, &$data)
    {
        $message = array();
        $account_request = new fi_kilonkipinat_accountregistration_accountrequest_dba(trim($args[0]));
        if (   isset($account_request)
            && isset($account_request->guid)
            && $account_request->guid == trim($args[0])
            && $account_request->status == FI_KILONKIPINAT_ACCOUNTREGISTRATION_ACCOUNT_STATUS_NEW) {
            $_MIDCOM->auth->request_sudo('fi.kilonkipinat.accountregistration');

            $account_request->status = FI_KILONKIPINAT_ACCOUNTREGISTRATION_ACCOUNT_STATUS_EMAILVALIDATED;
            $account_request->update();
            $message['title'] = $this->_l10n_midcom->get("Sähköpostiosoite varmistettu");
            $message['content'] = $this->_l10n_midcom->get("Tunnuspyyntönne on nyt lähetetty eteenpäin sivuston ylläpitäjille, jotka palaavat asiaan sähköpostitse.");

            if (   $this->_config->get('moderator') != null
                && $this->_config->get('moderator') != '') {

                $moderator = new midcom_db_person($this->_config->get('moderator'));
                if (   $moderator->guid != ''
                    && $moderator->guid == $this->_config->get('moderator')) {

                    $mail = new org_openpsa_mail();
                    $mail->from = $this->_config->get('mail_sender_title') . ' <' . $this->_config->get('mail_sender_address') . '>';
                    $mail->to = $moderator->firstname . ' ' . $moderator->lastname . ' <' . $moderator->email . '>';
                    $mail->body = "Henkilö " . $account_request->firstname . ' ' . $account_request->lastname . " on vahvistanut sähköpostiosoitteensa. \n\n";
                    $mail->body .= "Käy hyväksymässä tai estämässä tunnus osoitteessa http:://kilonkipinat.fi/recovery/manage_request/" . $account_request->guid . "/\n\n";
                    $mail->body .= "Muita tunnuspyyntöjä voit tarkastella osoitteessa http:://kilonkipinat.fi/recovery/list_pending/";
                    $mail->subject = "Uusi tunnuspyyntö kipinöiden sivuilla.";

                    $mail->send('mail')
                }
            }
            
            $_MIDCOM->auth->drop_sudo('fi.kilonkipinat.accountregistration');

        } else {
            $message['title'] = $this->_l10n_midcom->get("Virhe");
            $message['content'] = $this->_l10n_midcom->get("Tunnuspyyntöä ei löydetty. Sähköposti voi olla jo varmistettu.");
        }

        $this->_request_data['message'] = $message;

        return true;
    }
    
    /**
     * This function does the output.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param mixed &$data The local request data.
     */
    function _show_validateEmail($handler_id, &$data)
    {
        midcom_show_style('validate-email');
    }
    
    /**
     * The handler for the index article.
     *
     * @param mixed $handler_id the array key from the request array
     * @param array $args the arguments given to the handler
     * @param Array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_approveReset($handler_id, $args, &$data)
    {
        $message = array();
        $reset_request = new fi_kilonkipinat_accountregistration_resetrequest_dba(trim($args[0]));
        if (   isset($reset_request)
            && isset($reset_request->guid)
            && $reset_request->guid == trim($args[0])
            && $reset_request->status == FI_KILONKIPINAT_ACCOUNTREGISTRATION_PASSWORDRESETREQUEST_STATUS_NEW) {
            $_MIDCOM->auth->request_sudo('fi.kilonkipinat.accountregistration');

            $person = new midcom_db_person($reset_request->person);
            
            if (   isset($person)
                && isset($person->guid)
                && $person->guid != ''
                && $person->id == $reset_request->person) {
                $password = fi_kilonkipinat_accountregistration_viewer::generatePassword($this->_config->get('password_length'));

                // Enforce crypt mode
                $salt = chr(rand(64,126)) . chr(rand(64,126));
                $crypt_password = crypt($password, $salt);
                
                $person->password = $crypt_password;

                if ($person->update()) {

                    $reset_request->status = FI_KILONKIPINAT_ACCOUNTREGISTRATION_PASSWORDRESETREQUEST_STATUS_RESOLVED;
                    $reset_request->update();

                    $message['title'] = "Onnistui";
                    $message['content'] = "Tarkista sähköpostisi";

                    $subject = sprintf('Uusi salasananne', $_SERVER['SERVER_NAME']);
                    $body = sprintf('Hei %s', $person->firstname);
                    $body .= "\n\n";
                    $body .= sprintf('Uusi salasanne on %s', $password);
                
                    $mail = new org_openpsa_mail();
                    $mail->from = $this->_config->get('mail_sender_title') . ' <' . $this->_config->get('mail_sender_address') . '>';
                    $mail->to = $person->firstname . ' ' . $person->lastname . ' <' . $person->email . '>';
                    $mail->body = $body;
                    $mail->subject = $subject;

                    if ($mail->send('mail')) {
                        $message['title'] = "Onnistui";
                        $message['content'] = "Tarkista sähköpostisi.";
                    } else {
                        $message['title'] = "Virhe";
                        $message['content'] = "Oho, jotain meni pieleen";
                    }
                }
            }

            $_MIDCOM->auth->drop_sudo('fi.kilonkipinat.accountregistration');

        } else {
            $message['title'] = "Virhe";
            $message['content'] = "Ei löytynyt pyyn";
        }

        $this->_request_data['message'] = $message;

        return true;
    }
    
    /**
     * This function does the output.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param mixed &$data The local request data.
     */
    function _show_approveReset($handler_id, &$data)
    {
        midcom_show_style('approve-reset');
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