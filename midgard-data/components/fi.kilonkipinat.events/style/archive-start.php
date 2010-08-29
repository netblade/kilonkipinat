<?php
// Available request keys: total_count, first_event, last_event, first_month, last_month, 
// year_data

//$data =& $_MIDCOM->get_custom_context_data('request_data');

$summary = sprintf('Yhteensä %d tapahtumaa', $data['total_count']);

if ($data['first_event'])
{
    $summary .= ', ' . sprintf('joista ensimmäinen %s.',
        strftime('%x', strtotime($data['first_event']->start)));
}

$summary .= ' ' . 'Suluissa oleva luku kertoo kyseisen ajanjakson tapahtumien määrän.';
?>

<h1><?php echo $data['topic']->extra; ?>: <?php $data['l10n']->show('archive'); ?></h1>

<p>&(summary);</p>