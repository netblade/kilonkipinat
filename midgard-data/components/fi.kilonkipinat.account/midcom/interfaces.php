<?php
/**
 * @package fi.kilonkipinat.account 
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is the interface class for fi.kilonkipinat.account
 * 
 * @package fi.kilonkipinat.account
 */
class fi_kilonkipinat_account_interface extends midcom_baseclasses_components_interface
{
    /**
     * Constructor, define component name
     */
    function __construct()
    {
        parent::__construct();
        $this->_component = 'fi.kilonkipinat.account';
    }
    /**
     * Simple lookup method which tries to map the guid to an article of out topic.
     */
    function _on_resolve_permalink($topic, $config, $guid)
    {
        $person = new fi_kilonkipinat_account_person_dba($guid);
        if (!$person)
        {
            return null;
        }

        return "person/view/{$person->guid}/";
    }
}
?>