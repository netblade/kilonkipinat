<meta http-equiv="content-type" content="text/html; charset=utf-8" />    
        <title>Kilon Kipinät ry - <?php echo $_MIDCOM->get_context_data(MIDCOM_CONTEXT_PAGETITLE); ?></title>
        <?php echo $_MIDCOM->print_head_elements(); ?>
    <link rel="stylesheet" href="/style/css/master.css" type="text/css" media="all" charset="utf-8">
    <link rel="stylesheet" href="/style/css/elements.css" type="text/css" media="all" charset="utf-8">
    <link rel="stylesheet" href="/style/css/print.css" type="text/css" media="print" charset="utf-8">
    <!--[if gte IE 7]>
        <link rel="stylesheet" href="/style/css/ie7.css" type="text/css" media="screen" charset="utf-8">
    <![endif]-->
    <!--[if lte IE 6]>
        <link rel="stylesheet" href="/style/css/ie6.css" type="text/css" media="screen" charset="utf-8">
    <![endif]-->

    <link rel="shortcut icon" href="/style/img/kkp_favicon.ico">

<!-- jqModal, http://dev.iceburg.net/jquery/jqModal/ -->
<script type="text/javascript" src="/style/js/additional/jqModal.js"></script>
<link rel="stylesheet" href="/style/css/additional/jqModal.css" type="text/css" media="screen" />

<script type="text/javascript" src="/style/js/additional/jquery.simplemodal.1.4.min.js"></script>

<script type="text/javascript" src="/style/js/additional/jquery.corner.js"></script>

<script type="text/javascript" src="/style/js/additional/jquery.metadata.js"></script>

<link rel="stylesheet" href="/style/css/additional/tablesorter/style.css" type="text/css" media="screen" />
<script type="text/javascript" src="/style/js/additional/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="/style/js/additional/jquery.tablesorter.pager.js"></script>

<script type="text/javascript" src="/style/js/additional/thickbox-compressed.js"></script>
<link rel="stylesheet" href="/style/css/additional/thickbox.css" type="text/css" media="screen" />


<script type="text/javascript" src="/style/js/kilonkipinat.js"></script>

<?php
if ($_MIDGARD['user'] != 0)
{
?>
<style>
#top_navi ul li.johtajille
{
    display: none;
}
</style>
<?php
}
?>

<script type="text/javascript">
/*<![CDATA[*/
jQuery(document).ready(function() {
jQuery.application.init();
});
/*]]>*/
</script>