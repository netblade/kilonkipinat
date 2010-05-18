<?php
// Available request data: comments, objectguid, comment, display_datamanager
//$data =& $_MIDCOM->get_custom_context_data('request_data');
$view = $data['display_datamanager']->get_content_html();
$created = $data['comment']->metadata->published;

$published = sprintf(
    $data['l10n']->get('published by %s on %s.'),
    $view['author'],
    strftime('%x %X', $created)
);

$rating = '';
if ($data['comment']->rating > 0)
{
    $rating = ', ' . sprintf('rated %s', $data['comment']->rating);
}

$comment_div_id = 'comment_tools_for_' . $data['comment']->guid;

?>

<div class="net_nehmer_comments_comment">
<!--    <h3 class="headline">&(view['title']);&(rating);</h3>-->
    <div class="content">&(view['content']:h);</div>
    <div class="published">&(published);</div>
<?php
if ($_MIDGARD['user'])
{
?>
    <div class="net_nehmer_comments_comment_toolbar">
        <a href="#" onclick="jQuery('#&(comment_div_id);').toggle('slow'); return false;">Näytä työkalut</a>
        <div id="&(comment_div_id);" style="display: none;">
            <?php echo $data['comment_toolbar']->render(); ?>
            <div class="clearer_left">&nbsp;</div>
        </div>
    </div>
<?php
}
?>
</div>