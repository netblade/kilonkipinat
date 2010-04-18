<?php
/**
 * @package fi.kilonkipinat.account
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is the class that defines which URLs should be handled by this module.
 *
 * @package fi.kilonkipinat.account
 */
class fi_kilonkipinat_account_viewer extends midcom_baseclasses_components_request
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
            'handler' => array('fi_kilonkipinat_account_handler_index', 'index'),
        );
        
        // Handle /own_details/
        $this->_request_switch['own_details'] = array
        (
            'handler' => array('fi_kilonkipinat_account_handler_account', 'ownDetails'),
            'fixed_args' => array('own_details'),
        );
        // Handle /change_password/
        $this->_request_switch['change_password'] = array
        (
            'handler' => array('fi_kilonkipinat_account_handler_account', 'changePassword'),
            'fixed_args' => array('change_password'),
        );
        
        // CRUD for person

        // Handle /person/create/<person_schemaname>/
        $this->_request_switch['person_create'] = array
        (
            'handler' => array('fi_kilonkipinat_account_handler_person', 'create'),
            'fixed_args' => array('person', 'create'),
            'variable_args' => 1,
        );

        // Handle /person/view/<person_guid>/
        $this->_request_switch['person_read'] = array
        (
            'handler' => array('fi_kilonkipinat_account_handler_person', 'read'),
            'fixed_args' => array('person', 'view'),
            'variable_args' => 1,
        );

        // Handle /person/update/<person_guid>/
        $this->_request_switch['person_update'] = array
        (
            'handler' => array('fi_kilonkipinat_account_handler_person', 'update'),
            'fixed_args' => array('person', 'edit'),
            'variable_args' => 1,
        );

        // Handle /person/delete/<person_guid>/
        $this->_request_switch['person_delete'] = array
        (
            'handler' => array('fi_kilonkipinat_account_handler_person', 'delete'),
            'fixed_args' => array('person', 'delete'),
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
            foreach (array_keys($this->_request_data['schemadb']) as $name)
            {
                $this->_node_toolbar->add_item
                (
                    array
                    (
                        MIDCOM_TOOLBAR_URL => "person/create/{$name}/",
                        MIDCOM_TOOLBAR_LABEL => sprintf
                        (
                            $this->_l10n_midcom->get('create %s'),
                            $this->_request_data['schemadb'][$name]->description
                        ),
                        MIDCOM_TOOLBAR_ICON => 'fi.kilonkipinat.website/fam/user_add.png',
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
        $this->_request_data['schemadb'] = midcom_helper_datamanager2_schema::load_database($this->_config->get('schemadb'));
        $this->_request_data['prefix'] = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX);
        
        $_MIDCOM->add_link_head(array('rel' => 'stylesheet',  'type' => 'text/css', 'href' => MIDCOM_STATIC_URL . '/fi.kilonkipinat.account/fi_kilonkipinat_account.css', 'media' => 'all'));

        $this->_populate_node_toolbar();

        return true;
    }

}

?>