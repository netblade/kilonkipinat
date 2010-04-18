<?php
if ($_MIDGARD['user']) {
    if ($data['article']->abstract != '') {
?>
<div id="article_notes">
    <h2><a href="#" onclick="jQuery('#article_notes_content').toggle('slow'); return false;">Huomiot</a></h2>
    <div id="article_notes_content" style="display: none;">
        &(view['abstract']:h);
    </div>
</div>
<?php
    }
}
?>