<?php
/**
* HTML-Code zum Listen mehrerer Events (Body-Datei)
*
* @category   Veranstaltungsmanager
* @package    Site
* @subpackage View
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<table class="veranstaltung" width="100%" border="0" cellpadding="0" cellspacing="0">
	<?php $aktuellerMonat = 0; $color = 0; ?>
	<?php foreach($this->items as $i => $item): ?>
		<?php $item->Datum_von = new JDate($item->Datum_von); ?>
		<?php if($item->Datum_von->calendar('m') != $aktuellerMonat): ?>
			<?php if($aktuellerMonat): ?>
				<tr><td colspan="4">&nbsp;</td></tr>
				<tr><td colspan="4">&nbsp;</td></tr>
			<?php endif; ?>
			<?php $aktuellerMonat = $item->Datum_von->calendar('m'); ?>
			<tr><th colspan="4"><a name="<?php echo $aktuellerMonat; ?>" id="<?php echo JText::_('COM_EVENTS_EVENT_MONAT_'.$aktuellerMonat); ?>"></a><?php echo JText::_('COM_EVENTS_EVENT_MONAT_'.$aktuellerMonat); ?></th></tr>
			<tr><td colspan="4">&nbsp;</td></tr>
		<?php endif; ?>
		<?php $color++; $item->Datum_bis = new JDate($item->Datum_bis); ?>
		<tr  <?php if($color%2==0){echo 'style="background-color:#E6E6E6"';} ?> class="row<?php echo $i % 2; ?>">
			<td style="padding-right: 8px;" ><?php if($item->Datum_von->toUnix() != $item->Datum_bis->toUnix()){echo $item->Datum_von->calendar('d.').'-'.$item->Datum_bis->calendar('d.m');} else {echo $item->Datum_von->calendar('d.m');} ?></td>
			<td style="max-width: 280px; padding-right: 5px;">
				<?php foreach($item->links as $link): ?>
					<?php if($link->Typ == 'Ausschreibung'): ?>
						<a target="_blank" href="<?php echo $link->URL; ?>" mce_href="<?php echo $link->URL; ?>">
					<?php endif; ?>
				<?php endforeach; ?>
				<?php echo $item->Bezeichnung; ?></a></td>
			<td style="max-width: 90px;"><?php echo $item->Ort; ?></td>
			<td style="text-align: right;">
				<?php foreach($item->links as $link): ?>
					<?php if($link->Typ == 'Fotogalerie'): ?>
						<a target="_blank" href="<?php echo $link->URL; ?>" mce_href="<?php echo $link->URL; ?>"><img src="images/stories/navigation/archiv/fotos.gif" mce_src="/images/stories/navigation/archiv/fotos.gif" alt="Fotos" />
					<?php elseif($link->Typ == 'Bericht'): ?>
						<a target="<?php if(stripos($link, JURI::base()) !== false){echo "_self";}else {echo "_blank";} ?>" href="<?php echo $link->URL; ?>" mce_href="<?php echo $link->URL; ?>"><img src="images/stories/navigation/archiv/berichte.gif" mce_src="/images/stories/navigation/archiv/berichte.gif" alt="Bericht" />
					<?php elseif($link->Typ == 'Ergebnis'): ?>
						<a target="_blank" href="<?php echo $link->URL; ?>" mce_href="<?php echo $link->URL; ?>"><img src="images/stories/navigation/archiv/ergebnisse.gif" mce_src="/images/stories/navigation/archiv/ergebnisse.gif" alt="Ergebnisliste" />
					<?php endif; ?>
				<?php endforeach; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>