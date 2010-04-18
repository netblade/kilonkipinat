<?php
//$data =& $_MIDCOM->get_custom_context_data('request_data');

$published = "<abbr title=\"" . strftime('%Y-%m-%dT%H:%M:%S%z', $data['item']->metadata->published) . "\">" . fi_kilonkipinat_website::returnDate($data['item']->metadata->published, 'medium') . "</abbr>";
$view = $data['item'];
$title = $data['item']->title;
if(strlen($data['item']->url) > 0)
{
    $url = $data['item']->url;
}
else
{
    $url = $data['permalinks']->create_permalink($view->guid);
}

$item_topic = new midcom_db_topic($data['item']->topic);
$topic_title = $item_topic->extra;
$topic_link = '<a href="/midcom-permalink-' . $item_topic->guid . '/">' . $topic_title . '</a>';

?>
<div class="hentry">
    <h4 class="entry-title"><a href="&(url);" rel="bookmark">&(title:h);</a></h4>
    <p class="published">
        &(published:h); [&(topic_link:h);]
    </p>
</div>