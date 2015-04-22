<?php
/**
* Haupt-Controller der Events-Komponente
*
* @category   Veranstaltungsmanager
* @package    Admin
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Joomla Controller-Klasse laden
jimport('joomla.application.component.controller');

/**
* Haupt-Controller der Events-Komponente
*
* @category   Veranstaltungsmanager
* @package    Admin
*/
class EventsController extends JControllerLegacy {
	/**
	* display zeigt Listenansicht der Einträge
	*
	* @return void
	*/
	function display($cachable = false, $urlparams = array())	{
		$input =& JFactory::getApplication()->input;
		
		// Standard-View setzen, falls nicht in der Request übergeben
		$input->set('view',$input->get("view","Events","CMD"));
		
		// Parent-Methode aufrufen
		parent::display($cachable);
		
		// Submenü laden
		EventsHelper::addSubmenu('events');
	}
}
