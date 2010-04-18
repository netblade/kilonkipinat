<?php
$prefix = $data['prefix'];

$person = $data['object'];
$view = $data['view_person'];
?>
<h1>&(person.firstname);&nbsp;&(person.lastname);</h1>
<table>
<?php

foreach ($data['schemadb']['default']->fields as $key => $data) {
    $content = '';
    if (   is_array($data['storage'])) {
        if (   isset($data['storage']['location'])
            && $data['storage']['location'] != 'parameter') {
            $content = $person->$data['storage']['location'];
        } else {
            $content = $person->get_parameter('midcom.helper.datamanager2', $data['storage']['name']);
        }
    } elseif ($data['storage'] == 'parameter') {
        $content = $person->get_parameter('midcom.helper.datamanager2', $key);
    } else {
        $content = $person->$data['storage'];
    }
    if ($data['type'] == 'date') {
        if (   isset($data['widget_config'])
            && isset($data['widget_config']['show_time'])
            && $data['widget_config']['show_time'] == false) {
            $content = date('d.m.Y', strtotime($content));
        } else {
            $content = date('d.m.Y H:i', strtotime($content));
        }
        
    }
?>
    <tr>
        <th>&(data['title']:h);</th>
        <td>&(content:h);</td>
    </tr>
<?php
}
?>
</table>