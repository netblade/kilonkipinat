<?php
/**
 * @package fi.kilonkipinat.events
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is the class that defines which URLs should be handled by this module.
 *
 * @package fi.kilonkipinat.events
 */
class fi_kilonkipinat_events_viewer extends midcom_baseclasses_components_request
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
        $this->_request_data['content_topic'] = $this->_topic;

        /**
         * Prepare the request switch, which contains URL handlers for the component
         */

        // Handle /config
        $this->_request_switch['config'] = array
        (
            'handler' => array('midcom_core_handler_configdm2', 'config'),
            'schema' => 'config',
            'fixed_args' => array('config'),
        );

        // Handle /
        $this->_request_switch['index'] = array
        (
            'handler' => array('fi_kilonkipinat_events_handler_index', 'index'),
        );
        
        /* Crud for events */
        // Handle /create_event/<schema name>
        $this->_request_switch['create_event'] = array
        (
            'handler' => array('fi_kilonkipinat_events_handler_event', 'create'),
            'fixed_args' => array('create_event'),
            'variable_args' => 1,
        );
        // Handle /view_event/<event_guid>
        $this->_request_switch['view_event'] = array
        (
            'handler' => array('fi_kilonkipinat_events_handler_event', 'read'),
            'fixed_args' => array('view_event'),
            'variable_args' => 1,
        );
        // Handle /edit_event/<event_guid>
        $this->_request_switch['edit_event'] = array
        (
            'handler' => array('fi_kilonkipinat_events_handler_event', 'update'),
            'fixed_args' => array('edit_event'),
            'variable_args' => 1,
        );
        // Handle /delete_event/<event_guid>
        $this->_request_switch['delete_event'] = array
        (
            'handler' => array('fi_kilonkipinat_events_handler_event', 'delete'),
            'fixed_args' => array('delete_event'),
            'variable_args' => 1,
        );
        
        // /archive/between/<from date>/<to date> shows all events of selected week
        // in Archive mode, only relevant for style code, it sets a flag
        // which allows better URL handling: The request context key 'archive_mode'
        // will be true in this case.
        $this->_request_switch['archive-between'] = Array
        (
            'handler' => array('fi_kilonkipinat_events_handler_list', 'between'),
            'fixed_args' => array('archive', 'between'),
            'variable_args' => 2,
        );

        // /archive Main archive page
        $this->_request_switch['archive-welcome'] = Array
        (
            'handler' => array('fi_kilonkipinat_events_handler_archive', 'welcome'),
            'fixed_args' => array('archive'),
        );

        // /archive/view/<event GUID> duplicate of the view handler for archive
        // operation, only relevant for style code, it sets a flag
        // which allows better URL handling: The request context key 'archive_mode'
        // will be true in this case.
        $this->_request_switch['archive-view'] = Array
        (
            'handler' => array('fi_kilonkipinat_events_handler_event', 'view'),
            'fixed_args' => array('archive', 'view'),
            'variable_args' => 1,
        );
        // Handle /upcoming/trips/<count>
        $this->_request_switch['upcoming_trips'] = array
        (
            'handler' => array('fi_kilonkipinat_events_handler_list', 'upcoming'),
            'fixed_args' => array('upcoming', 'trips'),
            'variable_args' => 1,
        );
        // Handle /upcoming/meetings/<count>
        $this->_request_switch['upcoming_meetings'] = array
        (
            'handler' => array('fi_kilonkipinat_events_handler_list', 'upcoming'),
            'fixed_args' => array('upcoming', 'meetings'),
            'variable_args' => 1,
        );
    }

    /**
     * Indexes an event.
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
                        MIDCOM_TOOLBAR_URL => "create_event/{$name}/",
                        MIDCOM_TOOLBAR_LABEL => sprintf
                        (
                            $this->_l10n_midcom->get('create %s'),
                            $this->_request_data['schemadb'][$name]->description
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
        $this->_request_data['schemadb'] = midcom_helper_datamanager2_schema::load_database($this->_config->get('schemadb'));
        $this->_request_data['prefix'] = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX);
        $this->_request_data['datamanager'] = new midcom_helper_datamanager2_datamanager($this->_request_data['schemadb']);
        
        $_MIDCOM->add_link_head(array('rel' => 'stylesheet',  'type' => 'text/css', 'href' => MIDCOM_STATIC_URL . '/fi.kilonkipinat.events/fi_kilonkipinat_events.css', 'media' => 'all'));

        $this->_populate_node_toolbar();

        return true;
    }
    
    /**
     * Prepare filters used for event handling
     *
     * @access static
     */
    static function prepare_filters(&$config)
    {
        $filters = array();
        $type_filter = $config->get('type_filter_upcoming');
        
        if (   $type_filter !== false
            && $type_filter !== null)
        {
            // Type filter from configuration
            $filters['type_filter'] = $config->get('type_filter_upcoming');
        }
        
        if ($config->get('category_filter'))
        {
            // Category filter from configuration
            $filters['category_filter'] = $config->get('category_filter');
        }
        
        // PONDER: Should this be inside the if ($config->get('enable_filters')) -block below
        if (isset($_REQUEST['fi_kilonkipinat_events_category']))
        {
            // Category filter from GET or POST
            $filters['category_filter'] = trim(strip_tags($_REQUEST['fi_kilonkipinat_events_category']));
        }
        
        if ($config->get('enable_filters'))
        {
            // Other, direct property mappign filters from GET or POST
            if (   array_key_exists('fi_kilonkipinat_events_filter', $_REQUEST)
                && is_array($_REQUEST['fi_kilonkipinat_events_filter']))
            {
                $filters['other'] = $_REQUEST['fi_kilonkipinat_events_filter'];
            }
        }
        
        return $filters;
    }
    
    /**
     * Prepare event listing query builder that takes all configured filters into account
     *
     * @access static
     */
    static function prepare_event_qb(&$data, &$config)
    {
        // Load filters
        $filters = fi_kilonkipinat_events_viewer::prepare_filters($config);

        $qb = fi_kilonkipinat_events_event_dba::new_query_builder();
        if (!$_MIDGARD['user']) {
            $qb->add_constraint('visibility', '=', FI_KILONKIPINAT_EVENTS_EVENT_VISIBILITY_PUBLIC);
        }
        // Add node or root event constraints
        if ($config->get('list_from_master'))
        {
            // List under an event tree by up field
            $qb->add_constraint('up', 'INTREE', $data['master_event']);
        }
        else
        {
            $list_from_folders = $config->get('list_from_folders');
            if ($list_from_folders)
            {
                // We have specific folders to list from, therefore list from them and current node
                $guids = explode('|', $config->get('list_from_folders'));
                $guids_array = array();
                $guids_array[] = $data['content_topic']->guid;
                foreach ($guids as $guid)
                {
                    if (   !$guid
                        || !mgd_is_guid($guid))
                    {
                        // Skip empty and broken guids
                        continue;
                    }
    
                    $guids_array[] = $guid;
                }

                /**
                 * Ref #1776, expands GUIDs before adding them as constraints, should save query time
                 */
                $topic_ids = array();
                $topic_ids[] = $data['content_topic']->id;
                if (!empty($guids_array))
                {
                    $mc = midcom_db_topic::new_collector('sitegroup', $_MIDGARD['sitegroup']);
                    $mc->add_constraint('guid', 'IN', $guids_array);
                    $mc->add_value_property('id');
                    $mc->execute();
                    $keys = $mc->list_keys();
                    foreach ($keys as $guid => $dummy)
                    {
                        $topic_ids[] = $mc->get_subkey($guid, 'id');
                    }
                    unset($mc, $keys, $guid, $dummy);
                }

                /**
                 * Ref #1776, expands GUIDs before adding them as constraints, should save query time
                $qb->add_constraint('topic.guid', 'IN', $guids_array);
                 */
                $qb->add_constraint('topic', 'IN', $topic_ids);
            }
            else
            {
                // List from current node only
                $qb->add_constraint('topic', '=', $data['content_topic']->id);
            }
        }
        
        // Add filtering constraint
        if (isset($filters['type_filter']))
        {
            $qb->add_constraint('type', '=', (int) $filters['type_filter']);
        }
        
        if (isset($filters['other']))
        {
            // Handle other direct field mapping constraints
            foreach ($filters['other'] as $field => $filter)
            {
                $qb->add_constraint($field, '=', $filter);
            }
        }

        // Handle category filter
        if (isset($filters['category_filter']))
        {
            /**
             * This triggers bug http://trac.midgard-project.org/ticket/1009
            $qb->begin_group('AND');
                $qb->add_constraint('parameter.domain', '=', 'net.nemein.calendar');
                $qb->add_constraint('parameter.name', '=', 'categories');
                $qb->add_constraint('parameter.value', 'LIKE', "%|{$filters['category_filter']}|%");
            $qb->end_group();
             */
            /**
             * BEGIN: Workaround http://trac.midgard-project.org/ticket/1009 
             * see also: http://trac.midgard-project.org/ticket/261
             */
            $mc = new midgard_collector('midgard_parameter', 'domain', 'net.nemein.calendar');
            $mc->set_key_property('parentguid');
            $mc->add_constraint('name', '=', 'categories');
            $mc->add_constraint('value', 'LIKE', "%|{$filters['category_filter']}|%");
            $mc->execute();
            $keys = $mc->list_keys();
            unset($mc);
            $guids = array_keys($keys);
            if (empty($guids))
            {
                // array constraint cannot be empty, see #1636
                $guids[] = 'dummy';
            }
            $qb->add_constraint('guid', 'IN', $guids);
            unset($keys, $guids);
            /**
             * END: Workaround http://trac.midgard-project.org/ticket/1009 
             */
        }

        return $qb;
    }
}

?>