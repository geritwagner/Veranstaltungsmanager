<?php
/**
* HTML-Code zum Listen mehrerer Events (Layout-Datei)
*
* @category   Veranstaltungsmanager
* @package    Site
* @subpackage View
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted Access');
?>
<?php if($this->headline){ ?>
<h1>Veranstaltungen <?php echo $this->year; ?></h1>
<p>&nbsp;</p>
<?php } else { ?>
<h1>Ergebnisse <?php echo $this->year; ?></h1>
<p>&nbsp;</p>
<?php }?>

<p>Sie sind Veranstalter und wollen Ihr Event in die Liste mit aufnehmen lassen, so schicken Sie uns über das <a target="_blank" href="kontakt" mce_href="/kontakt">Kontaktformular</a> den Link zur Ausschreibung bzw. zu den Ergebnissen.</p>
<p><img alt="ergebnisse" src="images/stories/navigation/archiv/ergebnisse.gif" mce_src="/images/stories/navigation/archiv/ergebnisse.gif" />Ergebnisse - <img alt="berichte" src="images/stories/navigation/archiv/berichte.gif" mce_src="/images/stories/navigation/archiv/berichte.gif" />Berichte - <img alt="fotos" src="images/stories/navigation/archiv/fotos.gif" mce_src="/images/stories/navigation/archiv/fotos.gif" /> Fotos</p>
<?php
/**
* HTML-Code zum Listen mehrerer Events (Header-Datei)
*
* @category   Veranstaltungsmanager
* @package    Site
* @subpackage View
*/

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

?>
<table width="100%" border="0">
	<tr>
		<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>#Januar" mce_href="#Januar">Jan</a></td>
		<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>#Februar" mce_href="#Februar">Feb</a></td>
		<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>#März" mce_href="#März">März</a></td>
		<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>#April" mce_href="#April">Apr</a></td>
		<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>#Mai" mce_href="#Mai">Mai</a></td>
		<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>#Juni" mce_href="#Juni">Jun</a></td>
		<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>#Juli" mce_href="#Juli">Jul</a></td>
		<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>#August" mce_href="#August">Aug</a></td>
		<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>#September" mce_href="#September">Sept</a></td>
		<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>#Oktober" mce_href="#Oktober">Okt</a></td>
		<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>#November" mce_href="#November">Nov</a></td>
		<td><a href="<?php echo $_SERVER['REQUEST_URI']; ?>#Dezember" mce_href="#Dezember">Dez</a></td>
	</tr>
</table>
<p>&nbsp;</p>
<table class="veranstaltung table table-striped" id="eventsList">
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
			<td class="order nowrap center hidden-phone" ><?php if($item->Datum_von->toUnix() != $item->Datum_bis->toUnix()){echo $item->Datum_von->calendar('d.').'-'.$item->Datum_bis->calendar('d.m');} else {echo $item->Datum_von->calendar('d.m');} ?></td>
			<td class="order nowrap center hidden-phone">
				<?php foreach($item->links as $link): ?>
					<?php if($link->Typ == 'Ausschreibung'): ?>
						<a target="_blank" href="<?php echo $link->URL; ?>" mce_href="<?php echo $link->URL; ?>">
					<?php endif; ?>
				<?php endforeach; ?>
				<?php echo $item->Bezeichnung; ?></a></td>
			<td class="order nowrap center hidden-phone"><?php echo $item->Ort; ?></td>
			<td class="order nowrap center hidden-phone">
				<?php foreach($item->links as $link): ?>
					<?php if($link->Typ == 'Fotogalerie'): ?>
						<a target="_blank" href="<?php echo $link->URL; ?>" mce_href="<?php echo $link->URL; ?>"><img src="images/stories/navigation/archiv/fotos.gif" mce_src="/images/stories/navigation/archiv/fotos.gif" alt="Fotos" />
					<?php elseif($link->Typ == 'Bericht'): ?>
						<a target="<?php if(stripos($link->URL, JURI::base()) !== false){echo "_self";}else {echo "_blank";} ?>" href="<?php echo $link->URL; ?>" mce_href="<?php echo $link->URL; ?>"><img src="images/stories/navigation/archiv/berichte.gif" mce_src="/images/stories/navigation/archiv/berichte.gif" alt="Bericht" />
					<?php elseif($link->Typ == 'Ergebnis'): ?>
						<a target="_blank" href="<?php echo $link->URL; ?>" mce_href="<?php echo $link->URL; ?>"><img src="images/stories/navigation/archiv/ergebnisse.gif" mce_src="/images/stories/navigation/archiv/ergebnisse.gif" alt="Ergebnisliste" />
					<?php endif; ?>
				<?php endforeach; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>
