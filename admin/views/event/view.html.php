<?php
/**
* View zum Anzeigen eines Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage View
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Joomla View laden
jimport('joomla.application.component.view');

/**
* View zum Anzeigen eines Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage View
*/
class EventsViewEvent extends JViewLegacy {
	/**
	*  Ausführung und Anzeige des Template-Skripts
	*
	* @return void
	*/
	public function display($tpl = null) {
		// Daten vom Events-Model laden
		$this->item = $this->get('Item');
		
		// Formular laden
		$this->form = $this->get('Form');
		
		// Script laden
		$this->script = $this->get('Script');

		// Lade alle Links zu einem Event
		$event = new EventsModelEvent();
		$this->links = $event->getLinks($this->item->id);
		
		// Toolbar hinzufügen
		$this->addToolBar();
		
		// Auf Fehler prüfen und ausgeben
		if(count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		// Template anzeigen
		parent::display($tpl);
		
		// Setzen einiger Dokumenten-Details (z.B. JavaScript, Titel)
		$this->setDocument();
	}
	
	/**
	* Hinzufügen der Toolbar
	*
	* @return void
	*/
	protected function addToolBar() {
		// Deaktiviere Hauptmenü
		JRequest::setVar('hidemainmenu', true);
		
		// isNew ist true, wenn es sich um eine neue Veranstaltung ohne ID handelt
		$isNew = ($this->item->id == 0);
		
		// Objekt zum Überprüfen der Berechtigungen für ein Element
		$canDo = EventsHelper::getActions($this->item->id);
		
		// Setze Titel der Toolbar
		JToolBarHelper::title($isNew?JText::_('COM_EVENTS_MANAGER_EVENT_NEW'):JText::_('COM_EVENTS_MANAGER_EVENT_EDIT'), 'events');
		
		// Wenn Benutzer Veranstaltung hinzufügen oder Editieren darf (beim entsprechenden Status der Veranstaltung), füge Speichern-Button hinzu
		if(($isNew && $canDo->get('core.create')) || (!$isNew && $canDo->get('core.edit'))) {
			JToolBarHelper::save('event.save', 'JTOOLBAR_APPLY');
		}
		
		// Füge Abbrechen-Button hinzu
		JToolBarHelper::cancel('event.cancel', 'JTOOLBAR_CANCEL');
	}
	
	/**
	* Methode zum Setzen der Dokumenteneinstellungen
	*
	* @return void
	*/
	protected function setDocument() {
		// isNew ist true, wenn es sich um eine neue Veranstaltung ohne ID handelt
		$isNew = ($this->item->id == 0);
		
		// Hole aktuelles Dokument
		$document = JFactory::getDocument();
		
		// Setze je nach Status der Veranstaltung den Titel auf "neue" bzw. "bearbeitende" Veranstaltung
		$document->setTitle($isNew?JText::_('COM_EVENTS_EVENT_CREATING'):JText::_('COM_EVENTS_EVENT_EDITING'));
		
		// Füge Java-Script-Dateien hinzu
		$document->addScript(JURI::root().$this->script);
		$document->addScript(JURI::root().'/administrator/components/com_events/views/event/submitbutton.js');
		JText::script('COM_EVENTS_EVENT_ERROR_UNACCEPTABLE');
	}
	
	/**
	* Gibt den HTML-Code für ein Link-Formular zurück
	*
	* @param array $data Daten, um vorab auszufüllen (bei Dokument bearbeiten)
	* @param boolean $tpl (optional) Gibt an, ob das generierte Link-Formular ein Pseudo-Element ist, welches nur als Vorlage fürs Klonen in JavaScript verwendet wird
	*
	* @return string HTML-Code für einen Link-Formular
	*/
	public function getLinkHTML($data, $tpl = false) {
		// Liste für Typ-Auswahl
		$ret  = '<td>';
			$ret .= '<select name="jform[Typ][]" class="required">';
			foreach(array_merge(array(''), EventsHelper::getTyp()) as $typ) {
				$ret .= '<option value="'.$typ.'" '.($typ==$data->Typ?'selected="selected"':'').'>'.$typ.'</option>';
			}
			$ret .= '</select>';
		$ret .= '</td>';
		
		// Textfeld für Bezeichnung
		$ret .= '<td><input name="jform[BezeichnungLink][]" type="text" value="'.$data->Bezeichnung.'" class="inputbox required" /></td>';
		
		// Textfeld für URL
		$ret .= '<td><input name="jform[URL][]" type="text" value="'.$data->URL.'" class="inputbox required" /></td>';
		
		// Hidden- und Checkbox-Element für NewsTelegramm
		$ret .= '<td><input '.($tpl?'id="NewsTelegramm_hidden"':'').' name="jform[NewsTelegrammLink][]" type="hidden" value="'.($data->NewsTelegramm?'1':'0').'" /><input '.($tpl?'id="NewsTelegramm_checkbox"':'').' type="checkbox" '.($data->NewsTelegramm?'checked="checked"':'').' onchange="this.getPrevious().value = this.checked?1:0" /></td>';
		
		// Löschen Button für aktuelles Element
		$ret .= '<td>';
			$ret .= '<div class="icon-16-trash" style="width: 16px; height: 16px; cursor: pointer;" onclick="this.getParent().getParent().destroy();"></div>';
		$ret .= '</td>';
		
		return $ret;
	}
}
