<?php
// Available request keys: controller, indexmode, schema, schemadb
$view = $data['view_jobgroup'];
?>

<h2>Poista kulukorvauslomake: &(view['title']);</h2>

<form action="" method="post">
  <input type="submit" name="midcom_baseclasses_components_handler_crud_deleteok" value="<?php echo $data['l10n_midcom']->get('delete'); ?> " />
  <input type="submit" name="midcom_baseclasses_components_handler_crud_deletecancel" value="<?php echo $data['l10n_midcom']->get('cancel'); ?>" />
</form>

<?php
midcom_show_style('show-expense-lpk');
?>