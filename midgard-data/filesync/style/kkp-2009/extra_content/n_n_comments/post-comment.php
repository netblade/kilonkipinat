<?php
if ($_MIDGARD['user'])
{
?>
<style>
#net_nehmer_comments_post_comment #author_label {
    display: none;
}
</style>
<?php
}
?>
<div id="net_nehmer_comments_post_comment">
    <a name="net_nehmer_comments_post_&(data['objectguid']);"></a>
    <h3><?php $data['l10n']->show('post a comment'); ?>:</h3>
    <?php $data['post_controller']->display_form(); ?>
</div>