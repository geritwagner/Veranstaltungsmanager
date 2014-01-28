<?php
/**
* Formular-Regel zum Prüfen des Meisterschaftsfeldes
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Model
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');
 
// Joomla FormRule laden
jimport('joomla.form.formrule');
 
/**
* Formular-Regel zum Prüfen des Meisterschaftsfeldes
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Model
*/
class JFormRuleMeisterschaft extends JFormRule {
	/**
	* Testet, ob der übergebene Eintrag gültig ist
	*
	* @return boolean Wenn Test erfolgreich, wird true zurückgegeben. Ansonsten false.
	*/
	public function test(&$element, $value, $group = null, &$input = null, &$form = null) {
		// Prüfe, ob Übergabe leer oder einen gültigen Meisterschaftstypen enthält
		return in_array($value, array_merge(array(''), EventsHelper::getMeisterschaft()));
	}
}