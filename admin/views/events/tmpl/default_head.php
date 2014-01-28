<?php
/**
* HTML-Code zum Listen mehrerer Events (Header-Datei)
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage View
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');
?>
<tr>
	<th width="5"><?php echo JText::_('COM_EVENTS_EVENT_HEADING_ID'); ?></th>
	<th width="20"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" /></th>
	<th width="70"><?php echo JText::_('COM_EVENTS_EVENT_HEADING_MEISTERSCHAFT'); ?></th>
	<th><?php echo JText::_('COM_EVENTS_EVENT_HEADING_TITLE'); ?> (<?php echo JText::_('COM_EVENTS_EVENT_HEADING_ORT'); ?>, <?php echo JText::_('COM_EVENTS_EVENT_HEADING_DATUM'); ?>)</th>
	<th width="130"><?php echo JText::_('COM_EVENTS_EVENT_HEADING_NEWS'); ?></th>
</tr>