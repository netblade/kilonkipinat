<?php
// Available request keys: controller, indexmode, schema, schemadb
?>

<h1>Muokkaa tapahtumaa: <?php echo $data['event_title']; ?></h1>

<?php $data['controller']->display_form (); ?>