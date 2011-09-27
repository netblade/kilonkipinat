<?php
// Available request keys: article, datamanager, edit_url, delete_url, create_urls
$view = $data['view_article'];
?>

<h1>&(view['title']:h);</h1>

&(view['content']:h);

<br />

            <div class="frontpage_lift_container_left">
            <div class="tm"><div class="bm"><div class="lm"><div class="rm">
            <div class="tl"><div class="tr"><div class="bl"><div class="br">
                <div class="frontpage_lift_content">
<?php
$_MIDCOM->dynamic_load('/midcom-substyle-dl_frontpage/kisa/tapahtumat/upcoming/trips/4');
?>
                </div>
            </div></div></div></div>
            </div></div></div></div>
            </div>
            <div class="frontpage_lift_container_right">
            <div class="tm"><div class="bm"><div class="lm"><div class="rm">
            <div class="tl"><div class="tr"><div class="bl"><div class="br">
                <div class="frontpage_lift_content">
<?php
$_MIDCOM->dynamic_load('/midcom-substyle-dl_frontpage/kisa/tapahtumat/upcoming/meetings/4');
?>
                </div>
            </div></div></div></div>
            </div></div></div></div>
            </div>
            <div class="frontpage_lift_container_left">
            <div class="tm"><div class="bm"><div class="lm"><div class="rm">
            <div class="tl"><div class="tr"><div class="bl"><div class="br">
                <div class="frontpage_lift_content">
<?php
$_MIDCOM->dynamic_load('/midcom-substyle-dl_frontpage/kisa/uutiset/latest/4');
?>
                </div>
            </div></div></div></div>
            </div></div></div></div>
            </div>