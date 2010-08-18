<?php
/**
 * @package fi.kilonkipinat.forms
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is the class that defines which URLs should be handled by this module.
 *
 * @package fi.kilonkipinat.forms
 */
class fi_kilonkipinat_forms_viewer extends midcom_baseclasses_components_request
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
            'handler' => array('fi_kilonkipinat_forms_handler_index', 'index'),
        );
        
        // CRUD for expense lpk

        // Handle /expense/lpk/create/<schemaname>/
        $this->_request_switch['expense_lpk_create'] = array
        (
            'handler' => array('fi_kilonkipinat_forms_handler_expense_lpk', 'create'),
            'fixed_args' => array('expense', 'lpk', 'create'),
            'variable_args' => 1,
        );

        // Handle /jobhistory/jobgroup/view/<guid>/
        $this->_request_switch['expense_lpk_read'] = array
        (
            'handler' => array('fi_kilonkipinat_forms_handler_expense_lpk', 'read'),
            'fixed_args' => array('expense', 'lpk', 'view'),
            'variable_args' => 1,
        );

        // Handle /jobhistory/jobgroup/update/<guid>/
        $this->_request_switch['expense_lpk_update'] = array
        (
            'handler' => array('fi_kilonkipinat_forms_handler_expense_lpk', 'update'),
            'fixed_args' => array('expense', 'lpk', 'edit'),
            'variable_args' => 1,
        );

        // Handle /jobhistory/jobgroup/delete/<guid>/
        $this->_request_switch['expense_lpk_delete'] = array
        (
            'handler' => array('fi_kilonkipinat_forms_handler_expense_lpk', 'delete'),
            'fixed_args' => array('expense', 'lpk', 'delete'),
            'variable_args' => 1,
        );
    }

    /**
     * Indexes an article.
     *
     * This function is usually called statically from various handlers.
     *
     * @param midcom_helper_datamanager2_datamanager &$dm The Datamanager encapsulating the event.
     * @param midcom_services_indexer &$indexer The indexer instance to use.
     * @param midcom_db_topic The topic which we are bound to. If this is not an object, the code
     *     tries to load a new topic instance from the database identified by this parameter.
     */
    function index(&$dm, &$indexer, $topic)
    {
        if (!is_object($topic))
        {
            $tmp = new midcom_db_topic($topic);
            if (   !$tmp
                || !$tmp->guid)
            {
                $_MIDCOM->generate_error(MIDCOM_ERRCRIT,
                    "Failed to load the topic referenced by {$topic} for indexing, this is fatal.");
                // This will exit.
            }
            $topic = $tmp;
        }

        // Don't index directly, that would loose a reference due to limitations
        // of the index() method. Needs fixes there.

        $nav = new midcom_helper_nav();
        $node = $nav->get_node($topic->id);
        $author = $_MIDCOM->auth->get_user($dm->storage->object->creator);

        $document = $indexer->new_document($dm);
        $document->topic_guid = $topic->guid;
        $document->component = $topic->component;
        $document->topic_url = $node[MIDCOM_NAV_FULLURL];
        $document->read_metadata_from_object($dm->storage->object);
        $indexer->index($document);
    }

    /**
     * Populates the node toolbar depending on the user's rights.
     *
     * @access protected
     */
    function _populate_node_toolbar()
    {

        if ($this->_topic->can_do('midgard:create'))
        {
            foreach (array_keys($this->_request_data['schemadb_expense_lpk']) as $name)
            {
                $this->_node_toolbar->add_item
                (
                    array
                    (
                        MIDCOM_TOOLBAR_URL => "expense/lpk/create/{$name}/",
                        MIDCOM_TOOLBAR_LABEL => sprintf
                        (
                            $this->_l10n_midcom->get('create %s'),
                            $this->_request_data['schemadb_expense_lpk'][$name]->description
                        ),
                        MIDCOM_TOOLBAR_ICON => 'stock-icons/16x16/new-text.png',
                    )
                );
            }
        }
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

    }

    /**
     * The handle callback populates the toolbars.
     */
    function _on_handle($handler, $args)
    {
        $this->_request_data['schemadb_expense_lpk'] = midcom_helper_datamanager2_schema::load_database($this->_config->get('schemadb_expense_lpk'));
//        $this->_request_data['schemadb_expense_lpk_line'] = midcom_helper_datamanager2_schema::load_database($this->_config->get('schemadb_expense_lpk_line'));
//        $this->_request_data['schemadb_expense_group'] = midcom_helper_datamanager2_schema::load_database($this->_config->get('schemadb_expense_group'));
//        $this->_request_data['schemadb_expense_group_line'] = midcom_helper_datamanager2_schema::load_database($this->_config->get('schemadb_expense_group_line'));

        $this->_populate_node_toolbar();

        return true;
    }

}

?>