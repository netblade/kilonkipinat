<div id="footer">
    <div id="footer_top"><div id="footer_top_content">&nbsp;</div></div>
    <div id="footer_bottom">
        <div id="footer_right">
            &copy:&nbsp;<a href="http://netblade.iki.fi/" target="_blank">NetBlade</a>
        </div>
        <div id="footer_left"><?php

$page_metadata = $_MIDCOM->metadata->get_view_metadata();

if (!is_object($page_metadata)) {
    $page_metadata = $_MIDCOM->metadata->get_node_metadata();
}

if (is_object($page_metadata))
{
    $page_metadata = $page_metadata->__object->__object;

    $date_str = '(' . date('d.m.Y', strtotime($page_metadata->metadata->revised)) . ')';
    $person = new midcom_db_person($page_metadata->metadata->revisor);
    $person_str = '';
    if ($person) {
        $person_str = $person->firstname . ' ' . $person->lastname;
    }
    if ($_MIDGARD['user']) {
        $person_str = '<a href="#">' . $person_str . '</a>';
    }
?>Sivua viimeksi muokannut: &(person_str:h); &(date_str:h);<?php
}
?></div>
    </div>
</div>