<?php
// Available request keys: controller, indexmode, schema, schemadb
?>

<h1>Luo <?php echo $data['event_desc']; ?></h1>
<?php $data['controller']->display_form (); ?>