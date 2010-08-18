<h1>Lomakkeet</h1>
<?php
if (   isset($data['my_forms'])
    && count($data['my_forms']) > 0) {
?>
<h2>Omat lomakkeet</h2>
<?php
    if (   isset($data['my_forms']['forms_expence_lpk'])
        && count($data['my_forms']['forms_expence_lpk']) > 0) {

        $forms_expence_lpk = $data['my_forms']['forms_expence_lpk'];
        ?><h3>Kulukorvaus, lpk</h3>
        <table class="tablesorter">
            <thead>
                <tr>
                    <th class="header">Otsikko</th>
                    <th class="{sorter: 'fiDate'} header">Luotu</th>
                    <th class="{sorter: 'fiDate'} header">Muokattu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($forms_expence_lpk as $form) {
                    $created = date('d.m.Y H:i', strtotime($form->metadata_created));
                    $revised = strtotime($form->metadata_revised);
                    if (date('d.m.Y', $revised) == date('d.m.Y', time())) {
                    	$revised = '<strong>' . date('d.m.Y H:i', $revised) . '</strong>';
            		} else {
            			$revised = date('d.m.Y H:i', $revised);
            		}
                ?>
                <tr>
                    <td><?php echo $form->title; ?></td>
                    <td><?php echo $created; ?></td>
                    <td><?php echo $revised; ?></td>                    
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <?php
        
    }
}

?>
