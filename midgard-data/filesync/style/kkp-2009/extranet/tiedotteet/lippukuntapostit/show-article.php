<?php
// Available request keys: article, datamanager, edit_url, delete_url, create_urls
$view = $data['view_article'];
?>

<h1>&(view['title']:h);</h1>

&(view['content']:h);

<br />
<?php

$topic = new midcom_db_topic();
$topic->get_by_path('/kkp_root/extranet/tiedotteet/lippukuntapostit');
$mc = midcom_db_topic::new_collector('up', $topic->id);
$mc->add_constraint('component', '=', 'net.nehmer.blog');
$mc->add_value_property('name');
$mc->execute();

$keys = $mc->list_keys();

$counter = 0;
foreach ($keys as $guid => $blog_topic) {
    $counter++;
    $topic_name = $mc->get_subkey($guid, 'name');
    $dl_path = '/midcom-substyle-dl_frontpage/extranet/tiedotteet/lippukuntapostit/' . $topic_name . '/latest/4';
    if (($counter % 2) != 0 ) {
        ?>
            <div class="content_fp_lift_container_left">
        <?php
    } else {
        ?>
            <div class="content_fp_lift_container_right">
        <?php
    }
    ?>
            <div class="tm"><div class="bm"><div class="lm"><div class="rm">
            <div class="tl"><div class="tr"><div class="bl"><div class="br">
                <div class="content_fp_lift_content">
        <?php
        $_MIDCOM->dynamic_load($dl_path);
        ?>
                </div>
            </div></div></div></div>
            </div></div></div></div>
            </div>
    <?php
}

?>