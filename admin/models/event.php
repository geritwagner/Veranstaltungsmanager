<?php
/**
* Model zum Verwalten eines Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Model
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Joomla FormModel laden
jimport('joomla.application.component.modeladmin');

// Benötigt für EventsModelEvent::updateLinks();
require_once ('eventLinks.php');

/**
* Model zum Verwalten eines Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Model
*/
class EventsModelEvent extends JModelAdmin {
	/**
	* Speichert die Daten in der Datenbank
	*
	* @param array $data Assoziatives-Array, mit Key-Namen gleich den Spaltennamen
	*
	* @return boolean Gibt an, ob das Speichern erfolgreich durchgeführt wurde
	*/
	public function save($data) {
		// Prüfe ob Checkbox "NewsTelegramm" mit übertragen wurde
		if (!isset($data['NewsTelegramm'])) {
			// Falls nicht, setze den Wert auf 0
			$data['NewsTelegramm'] = 0;
		}

		// Wandele Datum vom deutschen (dd.mm.yyyy) ins internationale Format (yyyy-mm-dd) um
		$data['Datum_von'] = implode('-', array_reverse(explode('.', $data['Datum_von'])));
		$data['Datum_bis'] = implode('-', array_reverse(explode('.', $data['Datum_bis'])));

		// Falls Enddatum vor Startdatum liegt, vertausche beide Werte
		if($data['Datum_von'] > $data['Datum_bis']) {
			$swapDate = $data['Datum_von'];
			$data['Datum_von'] = $data['Datum_bis'];
			$data['Datum_bis'] = $swapDate;
		}

		// Speichere das Event und update die Links
//		echo "<pre>";print_r($data);exit;
		$ret = parent::save($data);
		$ret = $ret && $this->updateLinks();

		// Bei einem false return könnte der User auf der Seite verbleiben
		// Nur relevant, falls Benutzer versucht die JS-Formular-Prüfungen zu umgehen
		// Nicht erfolgreich gespeicherte Formularwerte bei Links können jedoch nicht wiederhergestellt werden
		//return $ret

		// Normaler Benutzer erhält alle Fehler durch JS, deswegen immer true-return
		return true;
	}

	/**
	* Update die Links zu einer Veranstaltung
	*
	* @return boolean Gibt an, ob das Speichern aller Links erfolgreich durchgeführt wurde
	*/
	protected function updateLinks() {
		// Hole relevante Input-Daten
		$input = (object)array_shift(JFactory::getApplication()->input->getArray(array('jform' => array('id' => '', 'BezeichnungLink' => '', 'Typ' => '', 'NewsTelegrammLink' => '', 'URL' => ''))));
//echo "<pre>";print_r(JFactory::getApplication()->input->get('id'));exit;
		// Hole ID des Events, bei neu letzter Auto-Increment-Wert, ansonsten mit übergeben
		$input->id = $input->id?$input->id:JFactory::getDbo()->insertid();

		if((JFactory::getApplication()->input->get('id') > 0)){
			$input->id	= JFactory::getApplication()->input->get('id');
		}

		$eventLinks = new EventsModelEventLinks();

		// Lösche alle Links zum Event
		$eventLinks ->deleteAllFromEvent($input->id);

		// Gehe erst mal von keinen Fehlern aus
		$error = false;

		for($i = 0; $i < count($input->BezeichnungLink); $i++) {
			// Hole alle Daten für Link $i
			$link = (object)array('id_events' => $input->id, 'Bezeichnung' => $input->BezeichnungLink[$i], 'Typ' => $input->Typ[$i], 'NewsTelegramm' => $input->NewsTelegrammLink[$i], 'URL' => $input->URL[$i]);

			// Wenn alle Pflichtfelder ausgefüllt sind, speichern.
			if(!(strlen($link->id_events) == 0 ||
				strlen($link->Bezeichnung) == 0 ||
				strlen($link->Typ) == 0 ||
				strlen($link->URL) == 0)) {
				$eventLinks->addLink($link);
			} else {
				$error = true;
			}
		}

		// Nach Speichern aller möglichen Links prüfen, ob Fehler aufgetaucht sind und diesen ausgeben
		if($error) {
			$e = new JException(JText::_('COM_EVENTS_EVENT_ERROR_LINKS'));
			$this->setError($e);

			return false;
		}

		return true;
	}

	/**
	* Gibt eine Referenz zum Tabellenobjekt zurück
	*
	* @param string $name (optional) Basis-Name für mehrere Elemente
	* @param string $prefix (optional) Prefix für Model-Klasse für mehrere Elemente
	* @param array $config (optional) Konfigurationseinstellungen treffen
	*
	* @return JModel Das zugehörige Model
	*/
	public function getTable($type = 'Events', $prefix = 'EventsTable', $config = array()) {
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	* Abruf der zugehörigen Formulars
	*
	* @param array $data Daten des Formulars
	* @param boolean $loadData True, wenn das Formular seine eigenen Daten laden soll, false falls nicht

	* @return mixed Ein JForm-Objekt bei Erfolg, andernfalls false
	*/
	public function getForm($data = array(), $loadData = true) {
		// Event-Formular aus dem Ordner forms laden
		$form = $this->loadForm('com_events.event', 'event', array('control' => 'jform', 'load_data' => $loadData));

		if(empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	* Methode zum Laden der Daten ins Formular
	*
	* @return mixed Daten des Formulars
	*/
	protected function loadFormData() {
		// Session auf zuvor eingegebene Daten prüfen
		$data = JFactory::getApplication()->getUserState('com_events.edit.event.data', array());

		// Falls keine Daten übergeben wurden, hole diese aus DB
		if(empty($data)) {
			$data = $this->getItem();
		}

		// Formatierung des Datums vom internationalen (yyyy-mm-dd) ins deutsche (dd.mm.yyyy.) Format
		if(strpos($data->Datum_von, '-') !== false) {
			$data->Datum_von = implode('.', array_reverse(explode('-', $data->Datum_von)));
			$data->Datum_bis = implode('.', array_reverse(explode('-', $data->Datum_bis)));
		}

		return $data;
	}

	/**
	* Rückgabe der für das Formular benötigten JavaScript-Datei
	*
	* @return string Pfad zur JavaScript-Datei
	*/
	public function getScript() {
		return 'administrator/components/com_events/models/forms/event.js';
	}

	/**
	* Rückgabe der vorhandenen Links zu einem Event
	*
	* @param int $id_events ID des Events
	*
	* @return stdClass[] Ein Object-Array mit allen Links eines Events
	*/
	public function getLinks($id_events) {
		$eventLinks = new EventsModelEventLinks();
		return $eventLinks->getItems($id_events);
	}
}
