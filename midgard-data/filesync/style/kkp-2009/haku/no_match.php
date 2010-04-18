<?php
//$data =& $_MIDCOM->get_custom_context_data('request_data');
?>
<h1><?php echo $data['topic']->extra;?></h1>

<div class="midcom_helper_search_form">
  <?php midcom_show_style("{$data['type']}_form"); ?>
</div>

<h2><?php echo $data['l10n']->get('search results');?>:</h2>

<div class="midcom_helper_search_results">
<p><?php echo $data['l10n']->get('your query returned no results'); ?></p>
</div>