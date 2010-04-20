<?php
// Available request keys: datamanager, article, view_url, article_counter
$view = $data['datamanager']->get_content_html();
$view_counter = $data['article_counter'];
$article_count = $data['article_count'];
$class_str = '';
if($view_counter == 0)
{
    $class_str = ' first';
}
elseif($view_counter == ($article_count-1))
{
    $class_str = ' last';
}

$published = "<abbr title=\"" . strftime('%Y-%m-%dT%H:%M:%S%z', $data['article']->metadata->published) . "\">" . date('d.m.Y H:i', $data['article']->metadata->published) . "</abbr>";

?>

<div class="hentry counter_&(view_counter); &(class_str);">
    <h4 class="entry-title"><a href="&(data['view_url']);" rel="bookmark">&(view['title']:h);</a></h4>
    <p class="published">&(published:h);</p>
</div>