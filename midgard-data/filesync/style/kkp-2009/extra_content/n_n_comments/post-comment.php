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
    <h3><a href="#" onclick="jQuery('#n_n_comments_comment_form').toggle('slow'); return false;"><?php $data['l10n']->show('post a comment'); ?>:</a></h3>
    <div id="n_n_comments_comment_form" style="display: none;">
        <?php $data['post_controller']->display_form(); ?>
    </div>
</div>