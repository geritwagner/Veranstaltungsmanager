<?php
/**
* Installationsskript des Veranstaltungsmanagers
*
* @category   Veranstaltungsmanager
* @package    Setup
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

/**
* Installationsskript des Veranstaltungsmanagers
*
* @category   Veranstaltungsmanager
* @package    Setup
*/
class com_EventsInstallerScript {
	/**
	* Methode, die bei der Installation aufgerufen wird
	*
	* @return void
	*/
	function install($parent) {
		$module_installer = new JInstaller();
		@$module_installer->install(dirname(__FILE__).DIRECTORY_SEPARATOR.'site'.DIRECTORY_SEPARATOR.'module');
		echo '<p>' . JText::_('COM_EVENTS_INSTALL_TEXT') . '</p>';
		$parent->getParent()->setRedirectURL('index.php?option=com_events');
	}

	/**
	* Methode, die bei der Deinstallation aufgerufen wird
	*
	* @return void
	*/
	function uninstall($parent) {
		// uninstalling jumi module
		$db = JFactory::getDBO();
        $db->setQuery("select extension_id from #__extensions where type = 'module' and element = 'mod_events'");
        $module_uninstaller = new JInstaller();
        @$module_uninstaller->uninstall('module', $db->loadObject()->extension_id);
		echo '<p>' . JText::_('COM_EVENTS_UNINSTALL_TEXT') . '</p>';
	}
	
	/**
	* Methode, die beim Update aufgerufen wird
	*
	* @return void
	*/
	function update($parent) {
		echo '<p>' . JText::_('COM_EVENTS_UPDATE_TEXT') . '</p>';
		$parent->getParent()->setRedirectURL('index.php?option=com_events');
	}
	
	/**
	* Methode läuft vor der Update-, Install- oder Uninstall-Methode
	*
	* @return void
	*/
	function preflight($type, $parent) {
		; //
	}
	
	/**
	* Methode läuft nach der Update-, Install- oder Uninstall-Methode
	*
	* @return void
	*/
	function postflight($type, $parent) {
		; //
	}
}