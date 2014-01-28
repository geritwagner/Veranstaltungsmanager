<?php
/**
* HTML-Code zum Listen mehrerer Events (Body-Datei)
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage View
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');
?>
<?php foreach($this->items as $i => $item): ?>
	<?php $item->Datum_von = new JDate($item->Datum_von); ?>
	<?php $item->Datum_bis = new JDate($item->Datum_bis); ?>
	<tr class="row<?php echo $i % 2; ?>">
		<td><?php echo $item->id; ?></td>
		<td><?php echo JHtml::_('grid.id', $i, $item->id); ?></td>
		<td>
			<?php if($item->Meisterschaft): ?>
				<?php echo $item->Meisterschaft; ?>
			<?php else: ?>
				-
			<?php endif; ?>
		</td>
		<td>
			<a href="<?php echo JRoute::_('index.php?option=com_events&task=event.edit&id='.$item->id); ?>">
			<?php echo $item->Bezeichnung; ?>
			(<?php echo $item->Ort; ?>,
			<?php echo $item->Datum_von->calendar('d.m.y'); ?><?php if($item->Datum_von->toUnix() != $item->Datum_bis->toUnix()) echo ' - '.$item->Datum_bis->calendar('d.m.y'); ?>)
			</a>
		</td>
		<td style="text-align: right; padding-right: 20px;">
			<?php if($item->NewsTelegramm): ?>
				<?php $item->Datum_von->modify('-'.$item->NewsTel_preDays.' day'); ?>
				<?php $item->Datum_bis->modify('+'.$item->NewsTel_postDays.' day'); ?>
				<?php echo $item->Datum_von->calendar('d.m.y'); ?><?php if($item->Datum_von->toUnix() != $item->Datum_bis->toUnix()) echo ' - '.$item->Datum_bis->calendar('d.m.y'); ?>
			<?php else: ?>
				-
			<?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>