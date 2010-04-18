<div id="imagery">
            <div id="imagery_content">
<?php
$mc_count = org_routamc_photostream_photo_dba::new_collector('sitegroup', $_MIDGARD['sitegroup']);
$max_count = $mc_count->count();

$photostream_prefix = '';
$photostream_topic = midcom_helper_find_node_by_component('org.routamc.photostream');
if ($photostream_topic) {
    $photostream_prefix = $photostream_topic['18'];
}

function get_image_str_by_counter($max_count, $photostream_prefix) {
    $img_str = '';
    $image_counter = rand(0, $max_count);
    $image_qb = org_routamc_photostream_photo_dba::new_query_builder();
    $image_qb->set_limit(1);
    $image_qb->set_offset($image_counter-1);
    $images = $image_qb->execute();
    if (count($images)>0) {
        $image =  $images[0];

        $qb_thumb = new midgard_query_builder('midgard_attachment');
        $qb_thumb->add_constraint('parentguid', '=', $image->guid);
        $qb_thumb->add_constraint('parameter.domain', '=', 'midcom.helper.datamanager2.type.blobs');
        $qb_thumb->add_constraint('parameter.name', '=', 'identifier');
        $qb_thumb->add_constraint('parameter.value', '=', 'thumbnail');
        $thumbs = $qb_thumb->execute();
        
        if (count($thumbs)>0) {
            $thumb = $thumbs[0];
        
            $img_str = '';
            if ($photostream_prefix != '') {
                $img_str = '<a title="' . $image->title . '" href="' . $photostream_prefix . 'photo/' . $image->guid . '/">';
            }
        
            $img_str .= '<img src="/midcom-serveattachmentguid-' . $thumb->guid . '/' . $thumb->guid . '" border="0" alt="' . $image->title . '" />';

            if ($photostream_prefix != '') {
                $img_str .= '</a>';
            }
            $img_str .= "<br />\n<br />\n";
        }
    }
    return $img_str;
    
}

echo get_image_str_by_counter($max_count, $photostream_prefix);
echo get_image_str_by_counter($max_count, $photostream_prefix);
echo get_image_str_by_counter($max_count, $photostream_prefix);

?>
            </div>
        </div>