<?php
/**
* HTML-Code zum Listen mehrerer Events (Footer-Datei)
*
* @category   Veranstaltungsmanager
* @package    Admin
* @subpackage View
*/

// Direkten Zugriff verhindern
defined('_JEXEC') or die('Restricted access');
?>
<tr>
	<td colspan="5"><?php echo $this->pagination->getListFooter(); ?></td>
</tr>