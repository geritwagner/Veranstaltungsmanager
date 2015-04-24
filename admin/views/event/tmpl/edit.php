<?php
/**
* HTML-Code zum Bearbeiten eines Events
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage View
*/
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('behavior.formvalidator');
//JHtml::_('formbehavior.chosen', 'select');
$this->fieldsets = $this->form->getFieldsets('params');

JFactory::getDocument()->addScriptDeclaration("
	Joomla.submitbutton = function(task)
	{
		if (task == 'event.cancel' || document.formvalidator.isValid(document.getElementById('style-form'))) {
			Joomla.submitform(task, document.getElementById('style-form'));
		}
	};
");

JHtml::_('behavior.framework');
?>

<div class="span12">
	<form action="<?php echo JRoute::_('index.php?option=com_events&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="style-form" class="form-validate">
		<div class="form-horizontal span4">
			<div class="form-vertical">
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('Bezeichnung'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('Bezeichnung'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('Ort'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('Ort'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('Meisterschaft'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('Meisterschaft'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('Datum_von'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('Datum_von'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('Datum_bis'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('Datum_bis'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('NewsTelegramm'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('NewsTelegramm'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('NewsTel_preDays'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('NewsTel_preDays'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('NewsTel_postDays'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('NewsTel_postDays'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="span6">
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
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
<div class="span6">
	<table style="display: none;">
		<tr id="linkTemplate">
			<?php echo $this->getLinkHTML((object)array('Typ' => '', 'BezeichnungLink' => '', 'URL' => '', 'NewsTelegrammLink' => ''), true); ?>
		</tr>
	</table>
</div>