<?php
/**
* Events-Controller für mehrere Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Controller
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Joomla AdminController.Klasse laden
jimport('joomla.application.component.controlleradmin');

/**
* Events-Controller für mehrere Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Controller
*/
class EventsControllerEvents extends JControllerAdmin {
	/**
	*  Gibt eine Referenz zum Tabellenobjekt zurück
	*
	* @param string $name (optional) Basis-Name für ein Element
	* @param string $prefix (optional) Prefix für Model-Klasse für mehrere Elemente
	* @param array $config (void) Parameter wird nicht verwendet und wird für das Overwriting bei der Vererbung benötigt
	*
	* @return JModel Das zugehörige Model
	*/
	public function getModel($name = 'Event', $prefix = 'EventsModel', $config = array()) {
		$model = parent::getModel($name, $prefix, array('ignore_request' =>	true));
		return $model;
	}
}