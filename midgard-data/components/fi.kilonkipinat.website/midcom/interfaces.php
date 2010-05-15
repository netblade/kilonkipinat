<?php
/**
 * @package fi.kilonkipinat.website 
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is the interface class for fi.kilonkipinat.website
 * 
 * @package fi.kilonkipinat.website
 */
class fi_kilonkipinat_website_interface extends midcom_baseclasses_components_interface
{
    /**
     * Constructor, define component name
     */
    function __construct()
    {
        parent::__construct();
        $this->_component = 'fi.kilonkipinat.website';
        // Load all mandatory class files of the component here
        $this->_autoload_files = array
        (
        );
        // Load all libraries used by component here
        $this->_autoload_libraries = array
        (
        );
    }
}
?>