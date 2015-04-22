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
JHtml::_('formbehavior.chosen', 'select');
$this->fieldsets = $this->form->getFieldsets('params');

JFactory::getDocument()->addScriptDeclaration("
	Joomla.submitbutton = function(task)
	{
		if (task == 'event.cancel' || document.formvalidator.isValid(document.getElementById('style-form'))) {
			Joomla.submitform(task, document.getElementById('style-form'));
		}
	};
");
?>
<form action="<?php echo JRoute::_('index.php?option=com_events&layout=edit&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="style-form" class="form-validate">
	<div class="form-horizontal">
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
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>