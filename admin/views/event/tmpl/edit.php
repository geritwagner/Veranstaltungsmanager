<?php
/**
* HTML-Code zum Bearbeiten eines Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage View
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');

// Tooltips aktivieren
JHtml::_('behavior.tooltip');

// JavaScript-Validation aktivieren
JHtml::_('behavior.formvalidation');
?>
<form action="<?php echo JRoute::_('index.php?option=com_events&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="event-form" class="form-validate">
	<div class="width-40 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_EVENTS_EVENT_DETAILS'); ?></legend>
			<ul class="adminformlist">
				<?php foreach($this->form->getFieldset('details') as $field): ?>
					<li><?php echo $field->label; echo $field->input;?></li>
				<?php endforeach; ?>
			</ul>
		</fieldset>
	</div>
	<div class="width-60 fltrt">
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_EVENTS_EVENT_LINKS'); ?></legend>
			<table id="linksTable">
				<tr>
					<td>
						<label class="hasTip" title="<?php echo JText::_('COM_EVENTS_EVENT_LINK_FIELD_TYP_LABEL'); ?>::<?php echo JText::_('COM_EVENTS_EVENT_LINK_FIELD_TYP_DESC'); ?>">
							<?php echo JText::_('COM_EVENTS_EVENT_LINK_FIELD_TYP_LABEL'); ?>
						</label>
					</td>
					<td>
						<label class="hasTip" title="<?php echo JText::_('COM_EVENTS_EVENT_FIELD_BEZEICHNUNG_LABEL'); ?>::<?php echo JText::_('COM_EVENTS_EVENT_LINK_FIELD_NEWSTELEGRAMM_DESC'); ?>">
							<?php echo JText::_('COM_EVENTS_EVENT_FIELD_BEZEICHNUNG_LABEL'); ?>
						</label>
					</td>
					<td>
						<label class="hasTip" title="<?php echo JText::_('COM_EVENTS_EVENT_LINK_FIELD_URL_LABEL'); ?>::<?php echo JText::_('COM_EVENTS_EVENT_LINK_FIELD_URL_DESC'); ?>">
							<?php echo JText::_('COM_EVENTS_EVENT_LINK_FIELD_URL_LABEL'); ?>
						</label>
					</td>
					<td>
						<label class="hasTip" title="<?php echo JText::_('COM_EVENTS_EVENT_FIELD_NEWSTELEGRAMM_LABEL'); ?>::<?php echo JText::_('COM_EVENTS_EVENT_LINK_FIELD_NEWSTELEGRAMM_DESC'); ?>">
							<?php echo JText::_('COM_EVENTS_EVENT_FIELD_NEWSTELEGRAMM_LABEL'); ?>
						</label>
					</td>
					<td><label></label></td>
				</tr>
				
				<?php foreach($this->links as $link): ?>
					<tr><?php echo $this->getLinkHTML($link); ?></tr>
				<?php endforeach; ?>
			</table>
			<div style="margin-top: 10px; cursor: pointer;" onclick="$('linkTemplate').clone().inject('linksTable');">
				<div class="icon-16-newarticle" style="width: 16px; height: 16px; float: left;"></div> <div style="float: left; padding-left: 10px; margin-top: 2px"><?php echo JText::_('COM_EVENTS_EVENT_LINK_ADD'); ?></div><div class="clear"></div>
			</div>
		</fieldset>
	</div>
	<div>
		<input type="hidden" name="task" value="event.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<table style="display: none;">
	<tr id="linkTemplate">
		<?php echo $this->getLinkHTML((object)array('Typ' => '', 'BezeichnungLink' => '', 'URL' => '', 'NewsTelegrammLink' => ''), true); ?>
	</tr>
</table>