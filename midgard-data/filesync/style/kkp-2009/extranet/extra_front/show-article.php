<?php
// Available request keys: article, datamanager, edit_url, delete_url, create_urls
$view = $data['view_article'];
?>

<h1>&(view['title']:h);</h1>

&(view['content']:h);

<br />

        <div class="content_fp_lift_container_wide">
            <div class="tm"><div class="bm"><div class="lm"><div class="rm">
            <div class="tl"><div class="tr"><div class="bl"><div class="br">
                <div class="content_fp_lift_content">
                <h2>Lippukuntapostit</h2>
                <?php
                $dl_path = '/midcom-substyle-dl_frontpage/extranet/tiedotteet/lippukuntapostit/feedcollector/latest/4';
                $_MIDCOM->dynamic_load($dl_path);
                ?>
                </div>
            </div></div></div></div>
            </div></div></div></div>
        </div>
        <div class="content_fp_lift_container_left">
            <div class="tm"><div class="bm"><div class="lm"><div class="rm">
            <div class="tl"><div class="tr"><div class="bl"><div class="br">
                <div class="content_fp_lift_content">
                <?php
                $dl_path = '/midcom-substyle-dl_frontpage/extranet/tiedotteet/nettisaitin_uutiset/latest/4';
                $_MIDCOM->dynamic_load($dl_path);
                ?>
                </div>
            </div></div></div></div>
            </div></div></div></div>
        </div>
        <div class="content_fp_lift_container_right">
            <div class="tm"><div class="bm"><div class="lm"><div class="rm">
            <div class="tl"><div class="tr"><div class="bl"><div class="br">
                <div class="content_fp_lift_content">
                <?php
                $dl_path = '/midcom-substyle-dl_frontpage/extranet/tiedotteet/kkp-n_wikin_muutokset/latest/4';
                $_MIDCOM->dynamic_load($dl_path);
                ?>
                </div>
            </div></div></div></div>
            </div></div></div></div>
        </div>
        <div class="content_fp_lift_container_wide">
            <div class="tm"><div class="bm"><div class="lm"><div class="rm">
            <div class="tl"><div class="tr"><div class="bl"><div class="br">
                <div class="content_fp_lift_content">
                <h2>Viimeisimmät tiedotteet</h2>
                <?php
                $dl_path = '/midcom-substyle-dl_frontpage/extranet/tiedotteet/feedcollector/latest/4';
                $_MIDCOM->dynamic_load($dl_path);
                ?>
                </div>
            </div></div></div></div>
            </div></div></div></div>
        </div>