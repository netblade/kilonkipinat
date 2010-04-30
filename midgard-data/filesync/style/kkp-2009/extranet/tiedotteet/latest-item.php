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


$target = '';
if (   strstr($url, 'http')
    && !strstr($url, 'kilonkipinat.fi'))
{
    $target = ' target="_blank"';
}

?>
<div class="hentry">
    aaa<h2 class="entry-title"><a href="&(url);" rel="bookmark">&(title:h);</a></h2>
    <p class="published">
        &(published:h);
    </p>
</div>