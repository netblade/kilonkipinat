<?php
if (   isset($_GET)
    && isset($_GET['search_str'])
    && $_GET['search_str'] != ''
    && strlen(trim($_GET['search_str']))>2)
{
    $search_str = trim($_GET['search_str']);
    $qb = fi_kilonkipinat_account_person_dba::new_query_builder();
    $qb->begin_group('OR');
    $qb->add_constraint('username', 'LIKE', '%'.$search_str.'%');
    $qb->add_constraint('firstname', 'LIKE', '%'.$search_str.'%');
    $qb->add_constraint('lastname', 'LIKE', '%'.$search_str.'%');
    $qb->end_group();
    $results = $qb->execute();
    if (count($results)>0) {
        echo "<table id=\"fi_kilonkipinat_accountregistration_merge_search_results\">\n";
        echo "\t<tr>\n";
        echo "\t\t<th>Etunimi</th>";
        echo "\t\t<th>Sukunimi</th>";
        echo "\t\t<th>Käyttäjätunnus</th>";
        echo "\t\t<th>Sähköposti</th>";
        echo "\t\t<th>&nbsp;</th>";
        echo "\t</tr>\n";
        foreach ($results as $result) {
            echo "\t<tr id=\"user_".$result->guid."\">\n";
            echo "\t\t<td>".$result->firstname."</td>";
            echo "\t\t<td>".$result->lastname."</td>";
            echo "\t\t<td>".$result->username."</td>";
            echo "\t\t<td>".$result->email."</td>";
            echo "\t\t<td><a href=\"#\" onclick=\"chooseUser('".$result->guid."', '".$result->username."'); return false;\">Valitse</a></td>";
            echo "\t</tr>\n";
        }
        echo "</table>\n";
    }
}

?>