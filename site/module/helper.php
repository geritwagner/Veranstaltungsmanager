<?php
/**
* Modul zum Anzeigen des Newstelegramms
*
* @category   Veranstaltungsmanager
* @package    Site
* @subpackage Module
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Inkludiere Routing-Datei
require_once (JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php');

/**
* Modul zum Anzeigen des Newstelegramms
*
* @category   Veranstaltungsmanager
* @package    Site
* @subpackage Module
*/
class modEventsHelper {
	/**
	 * Bezieht alle relevanten Events aus der Datenbank
	 *
	 * @return stdClass[] Array aus Event-Objekten
	 */
	public function getEvents() {
		// Datenbank-Onjekt holen
		$db = JFactory::getDBO();		
		
		// Neues Query-Objekt erstellen
		$query = $db->getQuery(true);
		
		// Felder auswählen
		$query->select('*');
		
		// Events-Tabelle auswählen
		$query->from('#__events');
		
		// Aufsteigende Sortierung nach Datum
		$query->order('Datum_von ASC');
		
		// Nur Veranstaltungen mit aktiviertem Newstelegramm anzeigen
		$query->where('Newstelegramm = 1');
		
		// Nur im gegebenen Zeitintervall anzeigen
		$query->where('CURDATE() >= DATE_ADD(Datum_von, INTERVAL -NewsTel_preDays DAY)');
		$query->where('CURDATE() <= DATE_ADD(Datum_bis, INTERVAL +NewsTel_postDays DAY)');
		
		// Abfrage durchführen und als Objekt-Liste holen
		$db->setQuery($query);
		$events = $db->loadObjectList();
		
		// Für jede Veranstaltung zugehörige Links holen
		foreach($events as $event) {
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from('#__events_links');
			$query->order('Typ ASC');
			$query->where('Newstelegramm = 1');
			$query->where('id_events = '.$event->id);
			
			$db->setQuery($query);
			$event->links = $db->loadObjectList();
		}
		
		// Rückgabe aller gefundenen Veranstaltungen
		return $events;
	}
}