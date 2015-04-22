<?php
/**
* Model zum Listen der Events eines Jahres und der zugehörigen Links
*
* @category   Veranstaltungsmanager
* @package    Site
* @subpackage Model
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Joomla Listen-Model laden
jimport('joomla.application.component.modellist');

// Benötigt für EventsModelEvents::getLinks()
require_once('eventLinks.php');

/**
* Model zum Listen der Events eines Jahres und der zugehörigen Links
*
* @category   Veranstaltungsmanager
* @package    Site
* @subpackage Model
*/
class EventsModelEvents extends JModelList {
	/**
	*  Erzeugt eine Standard-SQL-Abfrage zum Auflisten aller Elemente im aktuellen Jahr
	*
	* @return JQuery Die SQL-Abfrage
	*/
	protected function getListQuery() {
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

		// Beschränkung der Ausgabe auf das aktuelle Jahr
		$query->where('YEAR(Datum_von) = '.$db->quote(JFactory::getApplication()->input->get('jahr')));
		
		// Rückgabe der Abfrage
		return $query;
	}

	// Quick Fix: SQL-Limit (0,50) umgehen
	protected function populateState($ordering = NULL, $direction = NULL)
	{
		$this->setState('list.limit', 2000);
	}
	
	/**
	*  Ermittelt zu einem Event alle vorliegenden Links
	* 
	* @param int $events_id Die ID des Events
	* 
	* @return stdClass[] Ein Object-Array mit allen Links eines Events
	*/
	public function getLinks($events_id) {
		$eventLinks = new EventsModelEventLinks();
		
		return $eventLinks->getLinksForEvent($events_id);
	}
}