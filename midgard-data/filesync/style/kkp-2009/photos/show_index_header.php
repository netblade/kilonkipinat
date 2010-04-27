<?php
$prefix = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX);
if ($data['topic']->component == 'org.routamc.gallery') {
?>
<div class="org_routamc_gallery">
<h1><?php echo $data['node']->extra; ?></h1>

<?php
$data['qb']->show_pages();
?>

<ul class="org_routamc_photostream_photos">
<?php
}
else
{
    function scan_subgalleries($node)
    {
        $mc = org_routamc_gallery_photolink_dba::new_collector('node', $node);
        $mc->add_value_property('photo');
        $mc->add_constraint('censored', '=', 0);
        $mc->add_order('photo.taken', 'DESC');
        $mc->set_limit(1);
        $mc->execute();
        $photolinks = $mc->list_keys();

        foreach ($photolinks as $guid => $array)
        {
            $id = $mc->get_subkey($guid, 'photo');
            $photo = new org_routamc_photostream_photo_dba($id);
            return $photo;
        }

        $mc = midcom_db_topic::new_collector('up', $node);
        $mc->add_value_property('id');
        $mc->add_constraint('up', '=', $node);
        $mc->add_constraint('component', '=', 'org.routamc.gallery');
        $mc->add_constraint('metadata.navnoentry', '=', 0);
        $mc->add_order('score');

        $mc->execute();

        $nodes = $mc->list_keys();

        foreach ($nodes as $guid => $array)
        {
            $id = $mc->get_subkey($guid, 'id');

            $link = $this->_scan_subgalleries($id);

            if ($link)
            {
                return $link;
            }
        }

        return false;
    }
    
?>
<div class="org_routamc_photostream">
<h1><?php echo $data['view_title']; ?></h1>

<div id="org_routamc_photostream_subgalleries">
<?php
$mc = midcom_db_topic::new_collector('component', 'org.routamc.gallery');
$mc->add_constraint('up', '=', $data['topic']->id);
$mc->add_value_property('name');
$mc->add_value_property('id');
$mc->add_value_property('extra');
$mc->execute();
$keys = $mc->list_keys();
echo "<ul>\n";
foreach ($keys as $guid => $key) {
    $gallery_topic_name = $mc->get_subkey($guid, 'name');
    $gallery_topic_title = $mc->get_subkey($guid, 'extra');
    $gallery_topic_id = $mc->get_subkey($guid, 'id');
    echo "<li>\n";
    echo "<h3><a href=\"" . $prefix . $gallery_topic_name . "/\">" . $gallery_topic_title . "</a></h3>";
    $photo = scan_subgalleries($gallery_topic_id);
    if ($photo) {
        echo "<a href=\"" . $prefix . $gallery_topic_name . "/\">";
        echo $photo->thumbnail_html;
        echo "</a>";
    }
    echo "</li>\n";
    
}
echo "</ul>\n";
?>
</div>
<div class="clearer_left">&nbsp;</div>

<ul class="org_routamc_photostream_photostreams">
<?php

}
?>