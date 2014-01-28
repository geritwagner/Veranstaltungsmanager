<?php
/**
* Model zum Listen der Links eines Events
*
* @category   Veranstaltungsmanager
* @package    Site
* @subpackage Model
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Joomla Listen-Model laden
jimport('joomla.application.component.modellist');

/**
* Model zum Listen der Links eines Events
*
* @category   Veranstaltungsmanager
* @package    Site
* @subpackage Model
*/
class EventsModelEventLinks extends JModelList {
	/**
	* Ermittelt alle hinterlegten Links zu einem bestimmten Event
	*
	* @param int $events_id Die ID des Events
	*
	* @return stdClass[] Ein Object-Array mit allen Links eines Events
	*/
	public function getLinksForEvent($events_id) {
		// Datenbank-Onjekt holen
		$db = JFactory::getDBO();
		
		// Neues Query-Objekt erstellen
		$query = $db->getQuery(true);
		
		// Felder auswählen
		$query->select('*');
		
		// Event-Links-Tabelle auswählen
		$query->from('#__events_links');
		
		// Beschränkung auf Event mit ID $events_id vornehmen
		$query->where('id_events = '.$events_id);
		
		// Aufsteigende Sortierung nach Typ
		$query->order('Typ ASC');
		
		// Durchführen der Abfrage und Rückgabe der Links-Liste
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}
