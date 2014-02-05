<?php
/**
* Helper-Klasse für Events, die häufig benötigte Funktionen zusammenfasst
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Helper
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die;

/**
* Helper-Klasse für Events, die häufig benötigte Funktionen zusammenfasst
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Helper
*/
abstract class EventsHelper {
	/**
	*  Fügt dem Submenü das Logo hinzu
	*
	* @return void
	*/
	public static function addSubmenu() {
		JFactory::getDocument()->addStyleDeclaration('.icon-48-events {background-image:url(components/com_events/images/events-48x48.png);}');
	}

	/**
	*  Erstellt ein Objekt aus verfügbaren Aktionen (Anlegen, Bearbeiten, ...) und die zugehörigen Zugriffsrechte des aktuellen Benutzers
	*
	* @return JObject Ein Objekt, welches alle Aktionsnamen und zugrhörige Zugriffsrechte enthält
	*/
	public static function getActions() {
		// Hole aktuellen Benutzer
		$user = JFactory::getUser();
		
		// Erzeuge neues leeres JObject
		$result = new JObject;
		
		// Name der Komponente
		$assetName = 'com_events';
		
		// Verfügbare Aktionen
		$actions = array('core.admin', 'core.manage', 'core.create', 'core.edit', 'core.delete');
		
		// Prüfe für jede verfügbare Aktion, ob Benutzer entsprechende Rechte besitzt
		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}
		
		return $result;
	}
	
	/**
	*  Gibt die verfügbaren Meisterschafts-Typen zurück
	*
	* @return array Ein Array mit den abgekürzten Meisterschaftsnamen als Value
	*/
	public static function getMeisterschaft() {
		return array('BM', 'SM', 'DM', 'EM', 'WM', 'OS');
	}
	
	/**
	*  Gibt die verfügbaren Link-Typen zurück
	*
	* @return array Ein Array mit den verschiedenen Link-Typen als Value
	*/
	public static function getTyp() {
		return array('Ausschreibung', 'Webseite', 'Zeitplan', 'Teilnehmer', 'Ergebnis', 'Bericht', 'Fotogalerie', 'Videos', 'Sonstiges');
	}
}