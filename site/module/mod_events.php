<?php
/**
* Ausführungsskript des Newstelegramm-Moduls
*
* @category   Veranstaltungsmanager
* @package    Site
* @subpackage Module
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Prüfe ob Directory Separator gesetzt ist und setze diesen gegenbenenfalls
if(!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

// Inkludiere Helper-Klasse
require_once(dirname(__FILE__).DS.'helper.php');

// Hole alle Events
$events = modEventsHelper::getEvents();

// Ermittle Layout-Path und inkludiere diesen
require(JModuleHelper::getLayoutPath('mod_events'));