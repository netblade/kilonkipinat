<?php
/**
 * @package net.nemein.calendar
 * @author The Midgard Project, http://www.midgard-project.org
 * @version $Id: feed.php 11821 2007-08-29 15:08:28Z bergie $
 * @copyright The Midgard Project, http://www.midgard-project.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */

/**
 * Blog Feed handler
 *
 * Prints the various supported feeds using the FeedCreator library.
 *
 * @package net.nemein.calendar
 */

class fi_kilonkipinat_events_handler_feed extends midcom_baseclasses_components_handler
{
    /**
     * The events to display
     *
     * @var Array
     * @access private
     */
    var $_events = null;

    /**
     * The datamanager for the currently displayed event.
     *
     * @var midcom_helper_datamanager2_datamanager
     */
    var $_datamanager = null;

    /**
     * The de.bitfolge.feedcreator instance used.
     *
     * @var UniversalFeedCreator
     * @access private
     */
    var $_feed = null;

    /**
     * Simple default constructor.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Maps the content topic from the request data to local member variables.
     */
    function _on_initialize()
    {
        $this->_content_topic =& $this->_request_data['content_topic'];
    }

    /**
     * Shows the autoindex list. Nothing to do in the handle phase except setting last modified
     * dates.
     *
     * @param mixed $handler_id The ID of the handler.
     * @param Array $args The argument list.
     * @param Array &$data The local request data.
     * @return boolean Indicating success.
     */
    function _handler_rss($handler_id, $args, &$data)
    {
        $_MIDCOM->load_library('de.bitfolge.feedcreator');
        $_MIDCOM->cache->content->content_type("text/xml; charset=UTF-8");
        // FIXME: There should be some lifetime specification for the cache engine
        $_MIDCOM->cache->content->uncached();
        $_MIDCOM->header("Content-type: text/xml; charset=UTF-8");

        $_MIDCOM->skip_page_style = true;

        // Prepare control structures
        $this->_datamanager = new midcom_helper_datamanager2_datamanager($data['schemadb']);

        // Get the pre-filtered QB
        $qb = fi_kilonkipinat_events_viewer::prepare_event_qb($this->_request_data, $this->_config);

        // Show only events that haven't ended
        $qb->add_constraint('end', '>', date('Y-m-d H:i:s'));

        $qb->set_limit($this->_config->get('rss_count'));

        $sorts = $this->_config->get('rss_sort_rules');
        if (!is_array($sorts))
        {
            $sorts = array('start' => 'ASC');
        }
        foreach ($sorts as $prop => $rule)
        {
            $qb->add_order($prop, $rule);
        }

        $qb->set_limit($this->_config->get('rss_count'));
        $this->_events = $qb->execute();

        // Prepare the feed (this will also validate the handler_id)
        $this->_create_feed($handler_id);

        return true;
    }

    /**
     * Creates the Feedcreator instance.
     */
    function _create_feed($handler_id)
    {
        $this->_feed = new UniversalFeedCreator();
        if ($this->_config->get('rss_title'))
        {
            $this->_feed->title = $this->_config->get('rss_title');
        }
        else
        {
            $this->_feed->title = $this->_topic->extra;
        }
        $this->_feed->description = $this->_config->get('rss_description');
        $this->_feed->language = $this->_config->get('rss_language');
        $this->_feed->editor = $this->_config->get('rss_webmaster');
        $this->_feed->link = $_MIDCOM->get_host_name() . $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX);
        $this->_feed->cssStyleSheet = false;

        switch($handler_id)
        {
            case 'feed-rss2':
                $this->_feed->syndicationURL = "{$this->_feed->link}rss.xml";
                break;

            case 'feed-category-rss2':
                $this->_feed->title = sprintf($this->_request_data['l10n']->get('%s category %s'), $this->_feed->title, $this->_request_data['category']);
                $this->_feed->syndicationURL = "{$this->_feed->link}feeds/category/{$this->_request_data['category']}";
                break;

            default:
                $_MIDCOM->generate_error(MIDCOM_ERRCRIT, "The feed handler {$handler_id} is unsupported");
                // This will exit.
        }

    }

    /**
     * Displays the feed
     *
     * @param mixed $handler_id The ID of the handler.
     * @param mixed &$data The local request data.
     */
    function _show_rss($handler_id, &$data)
    {
        $data['feedcreator'] =& $this->_feed;

        // Add each event now.
        if ($this->_events)
        {
            foreach ($this->_events as $event)
            {
                $this->_datamanager->autoset_storage($event);
                $data['event'] =& $event;
                $data['datamanager'] =& $this->_datamanager;
                midcom_show_style('feeds-item');
            }
        }

        echo $this->_feed->createFeed('RSS2.0');
    }
}
?>