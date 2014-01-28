<?php
/**
* Formular-Regel zum Prüfen, ob ein Feld numerisch ist
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
* Formular-Regel zum Prüfen, ob ein Feld numerisch ist
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage Model
*/
class JFormRuleNumeric extends JFormRule {
        /**
         * @var string Prüfe mithilfe von regulären Ausdrücken auf gültige Ziffern (oder leer)
         */
        protected $regex = '^[0-9]*$';
}