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

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

$user		= JFactory::getUser();
$trashed	= $this->state->get('filter.published') == -2 ? true : false;
$canOrder	= $user->authorise('core.edit.state', 'com_events.event');
echo $saveOrder	= $this->orderCol == 'ordering';

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_events&task=events.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'eventList', 'adminForm', strtolower($this->orderCol), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();
//echo "<pre>";print_r($sortFields);echo "</pre>";
JHTML::_('behavior.modal');
?>
<script type="text/javascript">

	Joomla.orderTable = function() {
		table = document.getElementById("sortTable");
		direction = document.getElementById("directionTable");
		order = table.options[table.selectedIndex].value;

		if (order != '<?php echo $this->orderCol; ?>') {
			dirn = 'asc';
		} else {
			dirn = direction.options[direction.selectedIndex].value;
		}
		Joomla.tableOrdering(order, dirn, '');
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_events&view=events'); ?>" method="post" name="adminForm" id="adminForm">
	<?php if(!empty( $this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	<?php else : ?>
	<div id="j-main-container">
	<?php endif;?>
		<div id="filter-bar" class="btn-toolbar">
			<div class="filter-search btn-group pull-left">
				<label for="filter_search" class="element-invisible"><?php echo JText::_('JSEARCH_FILTER_LABEL');?></label>
				<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_EVENTS_SEARCH'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_EVENTS_SEARCH'); ?>" />
			</div>
			<div class="btn-group hidden-phone">
				<button class="btn tip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
				<button class="btn tip" type="button" onclick="document.id('filter_search').value='';this.form.submit();" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><i class="icon-remove"></i></button>
			</div>
			<div class="btn-group pull-right hidden-phone">
				<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>

			<div class="btn-group pull-right hidden-phone">
				<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC');?></label>
				<select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
					<option value=""><?php echo JText::_('JFIELD_ORDERING_DESC');?></option>
					<option value="asc" <?php if ($this->orderDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?></option>
					<option value="desc" <?php if ($this->orderDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?></option>
				</select>
			</div>
			<div class="btn-group pull-right">
				<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY');?></label>
				<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
					<option value=""><?php echo JText::_('JGLOBAL_SORT_BY');?></option>
					<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $this->orderCol);?>
				</select>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
		<table class="table table-striped" id="eventList">
			<tbody>
				<tr>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $this->orderDirn, $this->orderCol, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
					</th>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('grid.checkall'); ?>
					</th>
					<th width="10%" class="nowrap center">
						<?php echo JHTML::_('grid.sort', 'COM_EVENTS_EVENT_HEADING_MEISTERSCHAFT', 'a.Meisterschaft', $this->orderDirn, $this->orderCol); ?>
					</th>
					<th width="10%" class="nowrap hidden-phone">
						<?php echo JHtml::_('grid.sort', ( JText::_('COM_EVENTS_EVENT_HEADING_TITLE').'('.JText::_('COM_EVENTS_EVENT_HEADING_ORT').','.JText::_('COM_EVENTS_EVENT_HEADING_DATUM').')'), 'a.Ort', $this->orderDirn, $this->orderCol); ?>
					</th>
					<th width="10%" class="nowrap center">
						<?php echo JText::_('COM_EVENTS_EVENT_HEADING_NEWS'); ?>
					</th>
					<th width="1%" class="nowrap center hidden-phone">
						<?php echo JText::_('COM_EVENTS_EVENT_HEADING_ID'); ?>
					</th>
				</tr>
				<?php foreach($this->items as $i => $item):
					$item->max_ordering = 0;
					$ordering   = ($this->orderCol == 'a.ordering');
					$canCreate  = $user->authorise('core.create',     'com_events.event.' . $item->id);
					$canEdit    = $user->authorise('core.edit',       'com_events.event.' . $item->id);
					$canCheckin = $user->authorise('core.manage',     'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
					$canEditOwn = $user->authorise('core.edit.own',   'com_events.event.' . $item->id);
					$canChange  = $user->authorise('core.edit.state', 'com_events.event.' . $item->id) && $canCheckin;
				?>
				<?php $item->Datum_von = new JDate($item->Datum_von); ?>
				<?php $item->Datum_bis = new JDate($item->Datum_bis); ?>
				<tr class="row<?php echo $i % 2; ?>">
					<td class="order nowrap center hidden-phone">
						<?php
						$iconClass = '';
//						echo $canChange;
						if (!$canChange)
						{
							$iconClass = ' inactive';
						}
						elseif (!$saveOrder)
						{
							$iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
						}
						?>
						<span class="sortable-handler<?php echo $iconClass ?>">
							<i class="icon-menu"></i>
						</span>
						<?php if ($canChange && $saveOrder) : ?>
							<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
						<?php endif; ?>
					</td>
					<td class="nowrap hidden-phone center"><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
					<td class="nowrap hidden-phone center">
						<?php if($item->Meisterschaft): ?>
							<?php echo $item->Meisterschaft; ?>
						<?php else: ?>
							-
						<?php endif; ?>
					</td>
					<td class="nowrap hidden-phone">
						<a href="<?php echo JRoute::_('index.php?option=com_events&task=event.edit&id='.$item->id); ?>">
						<?php echo $item->Bezeichnung; ?>
						(<?php echo $item->Ort; ?>,
						<?php echo $item->Datum_von->calendar('d.m.y'); ?><?php if($item->Datum_von->toUnix() != $item->Datum_bis->toUnix()) echo ' - '.$item->Datum_bis->calendar('d.m.y'); ?>)
						</a>
					</td>
					<td class="nowrap hidden-phone center">
						<?php if($item->NewsTelegramm): ?>
							<?php $item->Datum_von->modify('-'.$item->NewsTel_preDays.' day'); ?>
							<?php $item->Datum_bis->modify('+'.$item->NewsTel_postDays.' day'); ?>
							<?php echo $item->Datum_von->calendar('d.m.y'); ?><?php if($item->Datum_von->toUnix() != $item->Datum_bis->toUnix()) echo ' - '.$item->Datum_bis->calendar('d.m.y'); ?>
						<?php else: ?>
							-
						<?php endif; ?>
					</td>
					<td class="nowrap hidden-phone center"><?php echo $item->id; ?></td>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td colspan="6"><?php echo $this->pagination->getListFooter(); ?></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="clearfix"></div>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $this->orderCol; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->orderDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>