<?php
// Available request keys: article, datamanager, edit_url, delete_url, create_urls
$view = $data['view_article'];
?>
<(article-notes)>
<h1>&(view['title']:h);</h1>

&(view['content']:h);

<?php
    if(isset($data['datamanager']->types["downloads"]))
    {
        $tmp_downloads = $data['datamanager']->types["downloads"]->attachments_info;
    }
    if (   isset($tmp_downloads)
        && count($tmp_downloads)>0)
    {
?>
<div class="downloads">
    <h3>Tiedostot</h3>
    <ul>
<?php
        foreach($tmp_downloads as $tmp_download)
        {
            $filesize = round(($tmp_download['filesize'] / 1024), 0);
            if($filesize > 1000)
            {
                $filesize = round(($filesize / 1024), 2) . ' MB';
            }
            else
            {
                $filesize = $filesize . ' kb';
            }
            $filetype = str_replace('application/', '', $tmp_download['mimetype']);
            $filetype = str_replace('image/', '', $filetype);
            if ($filetype != '')
            {
                $filetype .= ', ';
            }
            if($tmp_download['description'] != '')
            {
                echo "\t\t<li><a href=\"" . $tmp_download['url'] . "\">" . $tmp_download['description'] . "</a> (" . $filetype . $filesize . ")</li>\n";
            }
            else
            {
                echo "\t\t<li><a href=\"" . $tmp_download['url'] . "\">" . $tmp_download['filename'] . "</a> (" . $filetype . $filesize . ")</li>\n";
            }
        }
        ?>
    </ul>
</div>
<?php
    }
?>