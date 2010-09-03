/* The schema database to use */
'schemadb' => 'file:/fi/kilonkipinat/events/config/schemadb_default.inc',
'schemadb_location' => 'file:/fi/kilonkipinat/events/config/schemadb_location_default.inc',
'schemadb_feed'        => 'file:/net/nemein/rss/config/schemadb_default.inc',

'schema' => 'default',

'index_count'          => 10,      // How many upcoming events to display on index
'categories' => '',
'categories_in_navigation' => false,

// RSS export
'rss_enable' => true,  // enable RSS export on rss/latest.xml
'rss_count' => 20, // show that many items by default (if called 'rss.xml' without any count)
'rss_title' => null,  // RSS feed title, leave null to use the topic title
'rss_description' => '',
'rss_webmaster' => '',
'rss_language' => '',
'rss_use_content'      => true,
'archive_enable' => true,
'archive_year_order'   => 'ASC',  // Order for years in archive welcome page
'archive_in_navigation' => true,
'archive_years_in_navigation' => true,

'ical_count' => 20, // show that many items by default

'show_navigation_pseudo_leaves' => true,   // Set this to false if you want to hide archive navigation items