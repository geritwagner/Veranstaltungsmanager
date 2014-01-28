<?php
/**
* HTML-Code des Newstelegramms
*
* @category   Veranstaltungsmanager
* @package    Site
* @subpackage Module
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Ausgabe der Event Liste
if(count((array)$events)) {
	foreach($events as $event) {
		$event->Datum_von = new JDate($event->Datum_von);
		$event->Datum_bis = new JDate($event->Datum_bis);
		
		echo '<p>';
		echo $event->Ort;
		echo ', ';
		echo $event->Datum_von->calendar('d.m.y');
		if($event->Datum_von->toUnix() != $event->Datum_bis->toUnix()) {
			echo ' - ';
			echo $event->Datum_bis->calendar('d.m.y');
		}
		echo '<br />';
		echo '<strong>'.$event->Bezeichnung.'</strong>';
		
		foreach($event->links as $link) {
			echo '<br />';
			echo '<a target="_blank" href="'.$link->URL.'">'.$link->Bezeichnung.'</a>';
		}
		
		echo '</p>';
		echo '<hr style="margin: 2px 0; border: 0; border-bottom: 1px solid #C5C5C5;" />';
	}
	echo '<p style="text-align: center; margin-top: 10px; font-weight: bold">Weitere Ergebnisse in der&nbsp; <a href="veranstaltungen">Ergebnisrubrik</a>...</p>';
} else {
	echo '<p>Es sind noch keine Einträge vorhanden.</p>';
}