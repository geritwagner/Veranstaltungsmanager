<?php
/**
* Model zum Verwalten der Links eines Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Model
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Joomla Listen-Model laden
jimport('joomla.application.component.modellist');

/**
* Model zum Verwalten der Links eines Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Model
*/
class EventsModelEventLinks extends JModelList {
	/**
	* Löscht alle Links, die zu der Veranstaltung $id_events gehören
	*
	* @param int $id_events Die ID der Veranstaltung
	*
	* @return void
	*/
	public function deleteAllFromEvent($id_events) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->delete('#__events_links');
		$query->where('id_events = '.$db->quote($id_events));
		$db->setQuery($query);
		$db->query();
	}
	
	/**
	* Fügt einen neuen Link hinzu
	*
	* @param array $data Assoziatives Array mit den Keys id_events, Bezeichnung, URL und NewsTelegramm
	*
	* @return void
	*/
	public function addLink($data) {
		$db = JFactory::getDbo();
		$db ->insertObject('#__events_links', $data);
	}

	/**
	* Rückgabe der vorhandenen Links zu einem Event
	*
	* @param int $id_events ID des Events
	*
	* @return stdClass[] Ein Object-Array mit allen Links eines Events
	*/	
	public function getItems($id_events) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__events_links');
		$query->where('id_events = '.$db->quote($id_events));
		$db->setQuery($query);
		return $db->loadObjectList();
	}
}
