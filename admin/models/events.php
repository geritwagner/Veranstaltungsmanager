<?php
/**
* Model zum Verwalten mehrerer Events
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
* Model zum Verwalten mehrerer Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Model
*/
class EventsModelEvents extends JModelList {
	/**
    * @var int $_limitstart Gibt an, wie viele Elemente bei der Listenansicht erst mal übersprungen werden sollen
    */
	protected $_limitstart = 0;

	/**
	* Methode erzeugt die SQL Query für die Listeneinträge
	*
	* @return string Eine SQL-Abfrage
	*/
	protected function getListQuery() {
		//Neues Query-Objekt erstellen.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		
		// Felder auswählen
		$query->select('*');
		
		// aus der events Tabelle laden
		$query->from('#__events');
		
		// Absteigend nach Startdatum sortieren
		$query->order('Datum_von DESC');
		
		return $query;
	}
	
	/**
	 * Konstruktor
	 */
	public function __construct() {
		parent::__construct();
		
		// Prüfe ob Anzahl der Elemente manuell geändert wurde
		if(!JFactory::getApplication()->input->get('limit')) {
			$db = JFactory::getDBO();
			
			// Berechne Anzahl der Veranstaltungen nach dem aktuellen Datum
			$query = $this->getListQuery();
			$query ->clear('select');
			$query ->select('COUNT(id)');
			$query ->where('Datum_von >= CURDATE()');
			
			$db ->setQuery($query);
			
			$eventsAfterToday = $db->loadResult();
			
			// Setze aktuelle Seite auf das mit dem momentanen Datum
			$currentPage = ceil($eventsAfterToday/$this->getPagination()->limit);
			
			// Wenn aktuelle Seite keinen sinnvollen Wert annimmt, auf erste Seite setzen
			if($currentPage <= 0) $currentPage = 1;
			
			// Setze Bezeichnung im Pagination-Footer-Bereich
			$this->getPagination()->set('pages.current', $currentPage);
			
			// Setze die zu überspringenden Datenelemente in der Datenbank
			// Erster Befehl nur aus Kompatibilitätsgründen, bei aktueller Version überschreibe this->getStart();
			$this->getPagination()->limitstart = ($currentPage - 1) * $this->getPagination()->limit;
			$this->_limitstart = $this->getPagination()->limitstart;
		}
		
	}
	
	/**
	* Methode gibt an, ab welchen Element in der DB gestartet werden soll
	*
	* @return int Anzahl der zu überspringenden Elemente (limit)
	*/
	public function getStart() {
		// Prüfe ob Anzahl der Elemente manuell geändert wurde
		if(!JFactory::getApplication()->input->get('limit')) {
			// Rückgabe der im Konstruktor ermittelten limitstart-Variable
			return $this->_limitstart;
		} else {
			return parent::getStart();
		}
	}
}