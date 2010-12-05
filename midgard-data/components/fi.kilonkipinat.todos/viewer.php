<?php
/**
 * @package fi.kilonkipinat.todos
 * @author The Midgard Project, http://www.midgard-project.org
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * This is the class that defines which URLs should be handled by this module.
 *
 * @package fi.kilonkipinat.todos
 */
class fi_kilonkipinat_todos_viewer extends midcom_baseclasses_components_request
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
            'handler' => array('fi_kilonkipinat_todos_handler_index', 'index'),
        );
        
        /* Crud for todoites */
        // Handle /create_todo/<schema name>
        $this->_request_switch['create_todo'] = array
        (
            'handler' => array('fi_kilonkipinat_todos_handler_todo', 'create'),
            'fixed_args' => array('create_todo'),
            'variable_args' => 1,
        );
        // Handle /view_todo/<todo_guid>
        $this->_request_switch['view_todo'] = array
        (
            'handler' => array('fi_kilonkipinat_todos_handler_todo', 'read'),
            'fixed_args' => array('view_todo'),
            'variable_args' => 1,
        );
        // Handle /edit_todo/<todo_guid>
        $this->_request_switch['edit_event'] = array
        (
            'handler' => array('fi_kilonkipinat_todos_handler_todo', 'update'),
            'fixed_args' => array('edit_todo'),
            'variable_args' => 1,
        );
        // Handle /delete_todo/<todo_guid>
        $this->_request_switch['delete_todo'] = array
        (
            'handler' => array('fi_kilonkipinat_todos_handler_todo', 'delete'),
            'fixed_args' => array('delete_todo'),
            'variable_args' => 1,
        );

	    // Handle /list/my/
	    $this->_request_switch['list_my'] = array
	    (
	        'handler' => array('fi_kilonkipinat_todos_handler_list', 'my'),
	        'fixed_args' => array('list', 'my'),
	    );

		// Handle /list/my/<count>
	    $this->_request_switch['list_my_count'] = array
	    (
	        'handler' => array('fi_kilonkipinat_todos_handler_list', 'my'),
	        'fixed_args' => array('list', 'my'),
            'variable_args' => 1,
	    );
	    
	    // Handle /list/my_groups/
	    $this->_request_switch['list_mygroups'] = array
	    (
	        'handler' => array('fi_kilonkipinat_todos_handler_list', 'myGroups'),
	        'fixed_args' => array('list', 'my_groups'),
	    );

		// Handle /list/my_groups/<count>
	    $this->_request_switch['list_mygroups_count'] = array
	    (
	        'handler' => array('fi_kilonkipinat_todos_handler_list', 'myGroups'),
	        'fixed_args' => array('list', 'my_groups'),
            'variable_args' => 1,
	    );

	    // Handle /list/my_supervised/
	    $this->_request_switch['list_mysupervised'] = array
	    (
	        'handler' => array('fi_kilonkipinat_todos_handler_list', 'mySupervised'),
	        'fixed_args' => array('list', 'my_supervised'),
	    );

		// Handle /list/my_supervised/<count>
	    $this->_request_switch['list_supervised_count'] = array
	    (
	        'handler' => array('fi_kilonkipinat_todos_handler_list', 'mySupervised'),
	        'fixed_args' => array('list', 'my_supervised'),
            'variable_args' => 1,
	    );
        // Handle /list/open/
	    $this->_request_switch['list_open'] = array
	    (
	        'handler' => array('fi_kilonkipinat_todos_handler_list', 'open'),
	        'fixed_args' => array('list', 'open'),
	    );

		// Handle /list/open/<count>
	    $this->_request_switch['list_open_count'] = array
	    (
	        'handler' => array('fi_kilonkipinat_todos_handler_list', 'open'),
	        'fixed_args' => array('list', 'open'),
            'variable_args' => 1,
	    );
	    
	    // Handle /list/all/
	    $this->_request_switch['list_all'] = array
	    (
	        'handler' => array('fi_kilonkipinat_todos_handler_list', 'all'),
	        'fixed_args' => array('list', 'all'),
	    );

		// Handle /list/all/<count>
	    $this->_request_switch['list_all_count'] = array
	    (
	        'handler' => array('fi_kilonkipinat_todos_handler_list', 'all'),
	        'fixed_args' => array('list', 'all'),
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
                        MIDCOM_TOOLBAR_URL => "create_todo/{$name}/",
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
        $this->_request_data['schemadb_related'] = midcom_helper_datamanager2_schema::load_database($this->_config->get('schemadb_related'));
        $this->_request_data['prefix'] = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX);
        $_MIDCOM->add_link_head(array('rel' => 'stylesheet',  'type' => 'text/css', 'href' => MIDCOM_STATIC_URL . '/fi.kilonkipinat.todos/fi_kilonkipinat_todos.css', 'media' => 'all'));

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

        if (   isset($_REQUEST['fi_kilonkipinat_todos_todoitem_filter_category'])
            && is_array($_REQUEST['fi_kilonkipinat_todos_todoitem_filter_category']))
        {
            // Category filter from GET or POST
            $filters['filter_category'] = trim(strip_tags($_REQUEST['fi_kilonkipinat_todos_todoitem_filter_category']));
        }

        if (   isset($_REQUEST['fi_kilonkipinat_todos_todoitem_filter_status'])
            && is_array($_REQUEST['fi_kilonkipinat_todos_todoitem_filter_status']))
        {
            // Order from GET or POST
            $filters['filter_status'] = $_REQUEST['fi_kilonkipinat_todos_todoitem_filter_status'];
        }

        if (   isset($_REQUEST['fi_kilonkipinat_todos_todoitem_filter_person'])
            && is_array($_REQUEST['fi_kilonkipinat_todos_todoitem_filter_person']))
        {
            // Order from GET or POST
            $filters['filter_person'] = $_REQUEST['fi_kilonkipinat_todos_todoitem_filter_person'];
        }
        
        if (   isset($_REQUEST['fi_kilonkipinat_todos_todoitem_filter_supervisor'])
            && is_array($_REQUEST['fi_kilonkipinat_todos_todoitem_filter_supervisor']))
        {
            // Order from GET or POST
            $filters['filter_supervisor'] = $_REQUEST['fi_kilonkipinat_todos_todoitem_filter_supervisor'];
        }
        
        if (   isset($_REQUEST['fi_kilonkipinat_todos_todoitem_filter_group'])
            && is_array($_REQUEST['fi_kilonkipinat_todos_todoitem_filter_group']))
        {
            // Order from GET or POST
            $filters['filter_group'] = $_REQUEST['fi_kilonkipinat_todos_todoitem_filter_group'];
        }
        
        if (   isset($_REQUEST['fi_kilonkipinat_todos_todoitem_filter_event'])
            && is_array($_REQUEST['fi_kilonkipinat_todos_todoitem_filter_event']))
        {
            // Order from GET or POST
            $filters['filter_event'] = $_REQUEST['fi_kilonkipinat_todos_todoitem_filter_event'];
        }
        
        if (isset($_REQUEST['fi_kilonkipinat_todos_todoitem_filter_limit']))
        {
            // Order from GET or POST
            $filters['filter_limit'] = $_REQUEST['fi_kilonkipinat_todos_todoitem_filter_limit'];
        }
        
        if (   array_key_exists('fi_kilonkipinat_todos_todoitem_filter', $_REQUEST)
            && is_array($_REQUEST['fi_kilonkipinat_todos_todoitem_filter']))
        {
            $filters['other'] = $_REQUEST['fi_kilonkipinat_todos_todoitem_filter'];
        }
        
        return $filters;
    }
    
    /**
     * Prepare todoitem listing query builder that takes all configured filters into account
     *
     * @access static
     */
    static function prepare_todoitem_qb(&$data, &$config)
    {
        // Load filters
        $filters = fi_kilonkipinat_todos_viewer::prepare_filters($config);

        $qb = $data['qb'];

        // Add filtering constraint
        if (isset($filters['filter_category']))
        {
            $qb->add_constraint('category', 'LIKE', '%|' . $filters['filter_category'] . '|%');
        }
        
        // Add filtering constraint
        if (isset($filters['filter_person']))
        {
            $qb->add_constraint('person', 'IN', $filters['filter_person']);
        }
        
        // Add filtering constraint
        if (isset($filters['filter_supervisor']))
        {
            $qb->add_constraint('supervisor', 'IN', $filters['filter_supervisor']);
        }

        // Add filtering constraint
        if (isset($filters['filter_group']))
        {
            $qb->add_constraint('grp', 'IN', $filters['filter_group']);
        }
        // Add filtering constraint
        if (isset($filters['filter_event']))
        {
            $qb->add_constraint('event', 'IN', $filters['filter_event']);
        }
        
        // Add filtering constraint
        if (isset($filters['filter_status']))
        {
            $qb->add_constraint('status', 'IN', $filters['filter_status']);
        } else {
            $status_list = array(
                FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_NEW,
                FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_PENDING,
                FI_KILONKIPINAT_TODOS_TODOITEM_STATUS_ACKNOWLEDGED
            );
            $qb->add_constraint('status', 'IN', $status_list);
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
            $qb->add_constraint('category', 'LIKE', "%|{$filters['category_filter']}|%");
        }
        
        return $filters;
    }

    function getCategories()
    {
        $categories_arr = explode(',', $this->_config->get('categories'));
        $categories = array();
        
        foreach ($categories_arr as $category) {
            $category_str = trim($category);
            $categories[$category_str] = $category_str;
        }
        
        return $categories;
    }
    
    function isInMyGroups($grp_id)
    {
        $mc = midcom_db_member::new_collector('uid', $_MIDGARD['user']);
        $mc->add_constraint('gid', '=', $grp_id);
        if ($mc->count() > 0) {
            return true;
        } else {
            return false;
        }
    }
}

?>