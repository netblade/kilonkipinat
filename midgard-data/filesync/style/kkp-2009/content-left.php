<div id="content_left">
<?php

$topic = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_CONTENTTOPIC);

$left_title = '';
$left_content = '';

$topic = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_CONTENTTOPIC);
$left_content_hide = $topic->get_parameter('midcom.helper.datamanager2', 'left_content_hide');

if ($left_content_hide != 1)
{
    $left_title = $topic->get_parameter('midcom.helper.datamanager2', 'left_content_title');
    $left_content = $topic->get_parameter('midcom.helper.datamanager2', 'left_content');
    if (   strlen($left_title) == 0)
    {
        while(strlen($left_title) < 1)
        {
            $topic = new midcom_db_topic($topic->up);
            if ($topic->get_parameter('midcom.helper.datamanager2', 'left_content_hide'))
            {
                break;
            }
            $left_title = $topic->get_parameter('midcom.helper.datamanager2', 'left_content_title');
            $left_content = $topic->get_parameter('midcom.helper.datamanager2', 'left_content');
            if ($topic->up == 0)
            {
                break;
            }
        }
    }
}

$topic = $_MIDCOM->get_context_data(MIDCOM_CONTEXT_CONTENTTOPIC);
$left_navigation_hide = $topic->get_parameter('midcom.helper.datamanager2', 'left_navigation_hide');
$left_navigation_show = true;

if ($left_navigation_hide == 1) {
    $left_navigation_show = false;
}
elseif ($left_navigation_hide != -1)
{
    while(true)
    {
        $topic = new midcom_db_topic($topic->up);
        if ($topic->get_parameter('midcom.helper.datamanager2', 'left_navigation_hide'))
        {
            $left_navigation_show = false;
            break;
        }
        if ($topic->up == 0)
        {
            $left_navigation_show = true;
            break;
        }
    }
}

if ($left_navigation_show) {
?>
        <div id="left_top">
            <span class="left_content_top">&nbsp;</span>
            <div id="navigation_content">
                <(navi-content)>
            </div>
        </div>
<?php
}
?>
        <div id="left_bottom">
<?php

if (   strlen($left_title) > 0)
{
?>
        <div class="left_bottom_container">
            <span class="left_content_top">&nbsp;</span>
            <h2>&(left_title:h);</h2>
        	&(left_content:h);
        </div>
<?php
}
?>
        <(additional_navi_links)>
        </div>
    </div>