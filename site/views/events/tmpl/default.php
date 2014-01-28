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
<?php if($this->headline): ?>
<h1>Veranstaltungen <?php echo $this->year; ?></h1>
<p>&nbsp;</p>
<?php endif; ?>
<p>Sie sind Veranstalter und wollen Ihr Event in die Liste mit aufnehmen lassen, so schicken Sie uns über das <a target="_blank" href="kontakt" mce_href="/kontakt">Kontaktformular</a> den Link zur Ausschreibung bzw. zu den Ergebnissen.</p>
<p><img alt="ergebnisse" src="images/stories/navigation/archiv/ergebnisse.gif" mce_src="/images/stories/navigation/archiv/ergebnisse.gif" />Ergebnisse - <img alt="berichte" src="images/stories/navigation/archiv/berichte.gif" mce_src="/images/stories/navigation/archiv/berichte.gif" />Berichte - <img alt="fotos" src="images/stories/navigation/archiv/fotos.gif" mce_src="/images/stories/navigation/archiv/fotos.gif" /> Fotos</p>
<?php echo $this->loadTemplate('head');?>
<?php echo $this->loadTemplate('body');?>
<?php echo $this->loadTemplate('foot');?>