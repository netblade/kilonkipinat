<?php
/**
 * @package fi.kilonkipinat.brainstorm 
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is the interface class for fi.kilonkipinat.brainstorm
 * 
 * @package fi.kilonkipinat.brainstorm
 */
class fi_kilonkipinat_brainstorm_interface extends midcom_baseclasses_components_interface
{
    /**
     * Constructor, define component name
     */
    function __construct()
    {
        parent::__construct();
        $this->_component = 'fi.kilonkipinat.brainstorm';
    }
}
?>