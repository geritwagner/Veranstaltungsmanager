<?php
/**
* Formular-Element zum Darstellen der verschiedenen Meisterschaftstypen in einer Dropdown-Liste
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Model
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Joomla FormField laden
jimport('joomla.form.formfield');
 
/**
* Formular-Element zum Darstellen der verschiedenen Meisterschaftstypen in einer Dropdown-Liste
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Model
*/
class JFormFieldMeisterschaft extends JFormField {
	/**
    * @var string $type Setze Typ-Namen auf Meisterschaft
    */
	protected $type = 'Meisterschaft';

	/**
	* Methode zum Erstellen einer Dropdown-Liste mit den verschiedenen Meisterschaftstypen
	*
	* @return string HTML-String zum Darstellen der Dropdown-Liste
	*/
	public function getInput() {
		// Übergebe id und name aus Formular
		$ret = '<select id="'.$this->id.'" name="'.$this->name.'">';
		
		// Erstelle leeres Element
		$ret .= '<option value=""></option>';
		
		// Erstelle einen Eintrag für jeden Meisterschaftstyp. Falls Formular editiert wird, wähle bisher gespeichertes Element aus
		foreach(EventsHelper::getMeisterschaft() as $meisterschaft) {
			$ret .= '<option value="'.$meisterschaft.'"'.($this->value==$meisterschaft?' selected="selected"':'').'>'.JText::_('COM_EVENTS_EVENT_FIELD_MEISTERSCHAFT_'.$meisterschaft).'</option>';
		}
		
		$ret .= '</select>';

		return $ret;
	}
}