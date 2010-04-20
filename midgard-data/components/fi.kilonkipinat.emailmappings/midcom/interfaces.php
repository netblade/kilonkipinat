<?php
/**
 * @package fi.kilonkipinat.emailmappings 
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is the interface class for fi.kilonkipinat.emailmappings
 * 
 * @package fi.kilonkipinat.emailmappings
 */
class fi_kilonkipinat_emailmappings_interface extends midcom_baseclasses_components_interface
{
    /**
     * Constructor, define component name
     */
    function __construct()
    {
        parent::__construct();
        $this->_component = 'fi.kilonkipinat.emailmappings';
    }
}
?>