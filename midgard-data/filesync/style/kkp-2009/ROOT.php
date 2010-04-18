<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fi" lang="fi">
<head>
    <(head-local)>
</head>
<?php
$page_class = $_MIDCOM->metadata->get_page_class();
?>
<body class="<?php echo $page_class; ?>"<?php echo $_MIDCOM->print_jsonload(); ?>>
    <?php
    $_MIDCOM->toolbars->show();
    ?>
<div id="container">
    <div id="left_vert_bg">&nbsp;</div>
    <(header)>
    <div id="top_navi">
        <(navi-top)>
    </div>
    <div id="content_container">
        <(imagery)>
<?php
if ($_MIDCOM->get_context_data(MIDCOM_CONTEXT_ANCHORPREFIX) != '/')
{
?>
        <(content-left)>
<?php
}
?>
        <div id="content">
            <(content)>
            <div class="clearer">&nbsp;</div>
        </div>
        <div class="clearer">&nbsp;</div>
    </div>
    <div class="clearer">&nbsp;</div>
</div>
<(footer)>
<?php
    $_MIDCOM->uimessages->show();
?>
<(google_analytics)>
</body>
</html>