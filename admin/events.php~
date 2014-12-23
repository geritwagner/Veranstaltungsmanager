<?php
/**
* Ausführungsskript der Events-Komponente (Backend)
*
* @category   Veranstaltungsmanager
* @package    Admin
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Zugriffsprüfung
if(!JFactory::getUser()->authorise('core.manage', 'com_events')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// verankert den Helper im autoloader
JLoader::register('EventsHelper', dirname(__FILE__) . '/helpers/events.php');

// Controller importieren
jimport('joomla.application.component.controller');

// Controllerinstanz mit Präfix Events laden
$controller = JController::getInstance('Events');

// Ausführen der Benutzeranfrage
$controller->execute(JFactory::getApplication()->input->get('task','','CMD'));

// Falls gesetzt, Weiterleitung ausführen
$controller->redirect();