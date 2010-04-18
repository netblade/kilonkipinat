<?php
$_MIDCOM->componentloader->load('fi.protie.navigation');
$navigation = new fi_protie_navigation();
$navigation->list_leaves = false;
$navigation->list_levels = 1;
$navigation->url_name_to_class = true;
$navigation->draw();
?>