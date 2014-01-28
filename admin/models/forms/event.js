/*
 * @var boolean Gibt an, ob das NewsTelegramm noch nie einen Fokus hatte.
 */
var neverFocusedNewsTelegramm = true;

/*
 * @var boolean Gibt an, ob das Enddatum-Feld noch nie einen Fokus hatte.
 */
var neverFocusedDatumBis = true;

/*
 * Ausführung nachdem Dokument fertig geladen wurde
 */
window.addEvent('load', function(){
	// Überprüfung anhand des onchange-Events, ob eine Änderung der Felder Ort oder NewsTelegramm vorliegt.
	$('jform_Ort').addEvent('change', checkOrtUndMeisterschaft);
	$('jform_Meisterschaft').addEvent('change', checkOrtUndMeisterschaft);
	
	// Je nach Zustand sollen die Felder NewsTelegramm (vor und nach) x Tage angezeigt werden
	$('jform_NewsTelegramm').addEvent('change', toggleNewsTelegramm);
	
	// Lasse initial den Zustand herstellen
	toggleNewsTelegramm();

	// Überprüfung anhand des onchange-Events, ob eine Änderung des Startdatums vorliegt
	$('jform_Datum_von').addEvent('change', checkDatumVon);
	document.addEvent('mousemove', checkDatumVon);
	
	// Setze beim ersten focus die onchange (Meisterschaft und Enddatum)-Events außer Kraft
	$('jform_NewsTelegramm').addEvent('focus', function() { neverFocusedNewsTelegramm = false; });
	$('jform_Datum_bis').addEvent('focus', function() { neverFocusedDatumBis = false; });

	// Erlaube bei den Datumsfeldern nur deutsches Datumsformat dd.mm.yyyy
	document.formvalidator.setHandler('date', function(value) {
		regex=/^\d{2}.\d{2}.\d{4}$/;
		return regex.test(value);
	});
});

/*
 * Überprüft ob eine Änderung des Startdatums vorliegt und ändern das Enddatum, falls dieses noch nie fokusiert wurde
 */
function checkDatumVon() {
	if($('jform_Datum_bis').value == "" && $('jform_Datum_von').value.length == 10 && neverFocusedDatumBis) {
		$('jform_Datum_bis').value = $('jform_Datum_von').value;
	}
}

/*
 * Zeige die Felder Newstelegramm (vor und nach) x Tage bei Bedarf an
 */
function toggleNewsTelegramm() {
	// Negierten Checkbox-Status speichern
	var notChecked = !$('jform_NewsTelegramm').checked;
	
	// Deaktiviere Felder falls Checkbox NewsTelegramm nicht markiert ist
	$('jform_NewsTel_preDays').disabled = notChecked;
	$('jform_NewsTel_postDays').disabled = notChecked;
	
	// Setze hidden-Feld zur Übertragung des Checkbox-Statuses auf den aktuellen Status
	$('NewsTelegramm_hidden').value = !notChecked?'1':'0';
	$('NewsTelegramm_checkbox').checked = !notChecked;

	// Verstecke die Felder NewsTelegram (vor und nach) x Tage, wenn Checkbox nicht gesetzt ist.
	$('jform_NewsTel_preDays').getParent().style.display = notChecked?'none':'block';
	$('jform_NewsTel_postDays').getParent().style.display = notChecked?'none':'block';
}

function checkOrtUndMeisterschaft() {
	// Wenn neue Veranstaltung und Newstelegramm noch nie einen Fokus hatte und es sich um eine neue Veranstaltung handelt (keine Editierung)
	if(neverFocusedNewsTelegramm && window.location.search.indexOf('id=') == -1)
		$('jform_NewsTelegramm').checked = ($('jform_Ort').value.toLowerCase().indexOf('regensburg') != -1 || $('jform_Meisterschaft').value != '');
	
	toggleNewsTelegramm();
}