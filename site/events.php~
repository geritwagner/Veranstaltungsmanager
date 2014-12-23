<?php
/**
* Ausführungsskript der Events-Komponente (Frontend)
*
* @category   Veranstaltungsmanager
* @package    Site
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Controller importieren
jimport('joomla.application.component.controller');

// Controllerinstanz mit Präfix Events laden
$controller = JController::getInstance('Events');

// Ausführen der Benutzeranfrage
$controller->execute(JFactory::getApplication()->input->get('task','','CMD'));

// Falls gesetzt, Weiterleitung ausführen
$controller->redirect();