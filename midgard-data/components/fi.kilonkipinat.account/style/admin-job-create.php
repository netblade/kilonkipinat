<?php
// Available request keys: controller, indexmode, schema, schemadb
?>
<?php
if (   $data['handler_id'] == 'jobhistory_job_create_for'
    && isset($data['person'])
    && isset($data['person']->id)) {
?>
<h1>Luo pesti henkilölle <?php echo $data['person']->firstname; ?> <?php echo $data['person']->lastname; ?></h1>
<?php
} else {
?>
<h1>Luo pesti</h1>
<?php
}
?>

<?php $data['controller']->display_form (); ?>