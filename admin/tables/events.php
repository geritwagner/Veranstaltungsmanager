<?php
/**
* Tabellen-Klasse für alle Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Table
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// JTable-Klasse laden
jimport('joomla.database.table');

/**
* Tabellen-Klasse für alle Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Table
*/
class EventsTableEvents extends JTable {
	/**
	 * Konstruktor zur Übergabe der aktuellen Datenbank-Instanz
	 * 
	 * @param JDatabase $db Referenz zu einem Datenbank-Objekt
	 */
	function __construct(&$db) {
		// Übergeben des Namens der Tabelle sowie des Primary Keys
		parent::__construct('#__events', 'id', $db);
	}
}