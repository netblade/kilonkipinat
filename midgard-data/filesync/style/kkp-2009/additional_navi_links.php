<?php
$_MIDCOM->load_library('midcom.helper.xsspreventer');
$search_value = '';
if (   isset($_GET['query'])
    && $_GET['query'] != '') {
    $search_value = str_replace('"', '', midcom_helper_xsspreventer::escape_attribute($_GET['query']));
}

?>
<div class="left_bottom_container">
    <span class="left_content_top">&nbsp;</span>
    <div id="additional_navi_links">
        <ul>
            <li class="sitemap"><a href="/sivukartta/">Sivukartta</a></li>
            <li class="feedback"><a href="/palaute/">Palaute</a></li>
            <li class="search"><form method="get" action="/haku/"><input value="&(search_value:h);" id="search_input" type="text" name="query" /><input id="search_submit" type="submit" value="Hae" /></form></li>
        </ul>
    </div>
</div>