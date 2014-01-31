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
		
		$gestern = new Jdate();
		$gestern->sub(new DateInterval('P1D'));
		
		echo '<p>';
		echo $event->Ort;
		echo ', ';
		if($event->Datum_von->toUnix() != $event->Datum_bis->toUnix()) {
			echo $event->Datum_von->calendar('d.');	
			echo '-';
			echo $event->Datum_bis->calendar('d.m.y');
		} else {
			echo $event->Datum_von->calendar('d.m.y');			
		}
		echo '<br />';
		echo '<strong>'.$event->Bezeichnung.'</strong>';
		
		foreach($event->links as $link) {
			if(!( ($link->Typ=="Ausschreibung" || $link->Typ=="Zeitplan" ||$link->Typ=="Teilnehmer" ) && $event->Datum_bis < $gestern)){
			echo '<br />';
			echo '<a target="_blank" href="'.$link->URL.'">'.$link->Bezeichnung.'</a>';
			}
		}
		
		echo '</p>';
		echo '<hr style="margin: 2px 0; border: 0; border-bottom: 1px solid #C5C5C5;" />';
	}
	echo '<p style="text-align: center; margin-top: 10px; font-weight: bold">Weitere Ergebnisse in der&nbsp; <a href="index.php?option=com_events&view=events&jahr='.date("Y").'&noheadline=1">Ergebnisrubrik</a>...</p>';
} else {
	echo '<p>Es sind noch keine Einträge vorhanden.</p>';
}