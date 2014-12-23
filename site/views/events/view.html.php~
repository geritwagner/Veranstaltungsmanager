<?php
/**
* View zum Listen von Events eines Jahres und der zugehörigen Links
*
* @category   Veranstaltungsmanager
* @package    Site
* @subpackage View
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Joomla View laden
jimport('joomla.application.component.view');

/**
* View zum Listen von Events eines Jahres und der zugehörigen Links
*
* @category   Veranstaltungsmanager
* @package    Site
* @subpackage View
*/
class EventsViewEvents extends JView {
	/**
	*  Ausführung und Anzeige des Template-Skripts
	*
	* @return void
	*/
	function display($tpl = null) {
		// Falls kein Jahr übergeben wurde, auf aktuelles Jahr setzen
		if(!JFactory::getApplication()->input->get('jahr')) JFactory::getApplication()->input->set('jahr', JDate::getInstance()->calendar('Y'));
	
		// Daten vom Events-Model laden
		$items = $this->get('Items');
		
		// Laden der zugehörigen Links zu jedem Event
		$events = new EventsModelEvents();
		foreach($items as $item) {
			$item ->links = $events->getLinks($item->id);
		}

		// Setzen der View-Variablen
		$this->items = $items;
		$this->year = JFactory::getApplication()->input->get('jahr');
		$this->headline = !JFactory::getApplication()->input->get('noheadline');
		
		// Auf Fehler prüfen und ausgeben
		if(count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		// Template anzeigen
		parent::display($tpl);
	}
}