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

$published = sprintf($data['l10n']->get('posted on %s.'), "<abbr title=\"" . strftime('%Y-%m-%dT%H:%M:%S%z', $data['article']->metadata->published) . "\">" . fi_kilonkipinat_website::returnDate($data['article']->metadata->published, 'medium') . "</abbr>");

if (array_key_exists('comments_enable', $data))
{
    $published .= " <a href=\"{$data['view_url']}#net_nehmer_comments_{$data['article']->guid}\">" . sprintf($data['l10n']->get('%s comments'), net_nehmer_comments_comment::count_by_objectguid($data['article']->guid)) . "</a>.";
}
?>

<div class="hentry counter_&(view_counter); &(class_str);">
    <h2 class="entry-title"><a href="&(data['view_url']);" rel="bookmark">&(view['title']:h);</a></h2>
    <p class="published">&(published:h);</p>
</div>