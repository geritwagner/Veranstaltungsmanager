<?php
/**
* Haupt-Controller des Veranstaltungsmanagers (Frontend)
*
* @category   Veranstaltungsmanager
* @package    Site
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Joomla Controller-Klasse laden
jimport('joomla.application.component.controller');

/**
* Haupt-Controller des Veranstaltungsmanagers (Frontend)
*
* @category   Veranstaltungsmanager
* @package    Site
*/
class EventsController extends JController {
	/**
	* Anzeige der Listenansicht der Einträge
	*
	* @return void
	*/
	function display($cachable = false)	{
		$input =& JFactory::getApplication()->input;
		
		// Standard-View setzen, falls nicht in der Request übergeben
		$input->set('view',$input->get("view","Events","CMD"));
		
		// Parent-Methode aufrufen
		parent::display($cachable);
	}
}
