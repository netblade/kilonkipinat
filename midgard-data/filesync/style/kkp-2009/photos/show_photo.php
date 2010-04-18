<?php
$prefix = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX);
$view = $data['photo_view'];
if (!isset($data['suffix'])) {
    $data['suffix'] = '';
}
?>
<div class="org_routamc_photostream_photo">
    <h1><?php echo $view['title']; ?></h1>
    <div class="photo-navigation">
    <?php
    if (   isset($data['next_guid'])
        && !empty($data['next_guid']))
    {
    ?>
            <a class="next" href="&(prefix);photo/&(data['next_guid']);/&(data['suffix']);">Seuraava &gt;</a>
    <?php
    }

    if (   isset($data['previous_guid'])
        && !empty($data['previous_guid']))
    {
    ?>
            <a class="previous" href="&(prefix);photo/&(data['previous_guid']);/&(data['suffix']);">&lt; Edellinen</a>
    <?php
    }
    ?>
    </div>
    <div class="photo">
        <?php
        $img_url = '';
        $main_url = '';
        $size_line = '';
        if (isset($data['datamanager']->types["photo"]->attachments_info['view'])) {
            $img_url = $data['datamanager']->types["photo"]->attachments_info['view']['url'];
            if (   $data['datamanager']->types["photo"]->attachments_info['view']['size_x'] != ''
                && $data['datamanager']->types["photo"]->attachments_info['view']['size_y'] != '') {
                $size_line = ' width="'.$data['datamanager']->types["photo"]->attachments_info['view']['size_x'].'" height="'.$data['datamanager']->types["photo"]->attachments_info['view']['size_y'].'"';
            }
            if (isset($data['datamanager']->types["photo"]->attachments_info['main'])) {
                $main_url = $data['datamanager']->types["photo"]->attachments_info['main']['url'];
            }
        }
        ?>
        <a class="thickbox" title="<strong><?php echo $view['title']; ?></strong><br /><?php echo $view['description']; ?>" href="&(main_url:h);"><img &(size_line:h); src="&(img_url:h);" title="<?php echo $view['title']; ?>" alt="<?php echo $view['title']; ?>" border="0"></a>
    </div>

    <div class="taken location">
        <?php
        $coordinates = null;
        if (   $GLOBALS['midcom_config']['positioning_enable']
            && class_exists('org_routamc_positioning_object')
            && $data['photo']->photographer)
        {
            $position_object = new org_routamc_positioning_object($data['photo']);
            $coordinates = $position_object->get_coordinates($data['photo']->photographer, $data['photo']->taken);
        }
        if (   $coordinates
            && $coordinates['latitude']
            && $coordinates['longitude'])
        {
            echo sprintf($data['l10n']->get('taken on %s in %s'), strftime('%d.%m.%Y %H:%M', $data['photo']->taken), org_routamc_positioning_utils::pretty_print_location($coordinates['latitude'], $coordinates['longitude']));
        }
        else
        {
            echo sprintf('Otettu %s', strftime('%d.%m.%Y %H:%M', $data['photo']->taken));
        }
        ?>
    </div>
    <div class="taken photographer">
        Kuvaaja: <a href="&(prefix);list/&(data['user_url']);/"><?php echo $data['photographer']->name; ?></a>
    </div>

    <div class="description">
        &(view['description']:h);
    </div>

    <?php
    // List tags used in this wiki page
    $tags_by_context = net_nemein_tag_handler::get_object_tags_by_contexts($data['photo']);
    if (count($tags_by_context) > 0)
    {
        $photostream_prefix = $prefix;
        if ($data['topic']->component == 'org.routamc.gallery') {
            $photostream_topic = midcom_helper_find_node_by_component('org.routamc.photostream');
            if ($photostream_topic) {
                $photostream_prefix = $photostream_topic['18'];
            }
        }
        echo "<dl class=\"tags\">\n";
        foreach ($tags_by_context as $context => $tags)
        {
            if (!$context)
            {
                $context = $_MIDCOM->i18n->get_string('tagged', 'net.nemein.tag');
            }
            echo "    <dt>{$context}</dt>\n";
            foreach ($tags as $tag => $url)
            {
                echo "        <dd class=\"tag\"><a href=\"{$photostream_prefix}tag/{$data['user_url']}/{$tag}\">{$tag}</a></dd>\n";
            }
        }
        echo "</dl>\n";
    }
    ?>
</div>