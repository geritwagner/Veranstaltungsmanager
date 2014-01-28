/*
 * Standard-Joomla-Funktion, die beim Absenden des Formulars prüft, ob alle Daten ordnungsgemäß getätigt wurden
 */
Joomla.submitbutton = function(task) {
	if(task == '') {
		return false;
	} else {
		var isValid=true;
		var action = task.split('.');
		
		if(action[1] != 'cancel' && action[1] != 'close') {
			var forms = $$('form.form-validate');
			for (var i=0;i<forms.length;i++) {
				if(!document.formvalidator.isValid(forms[i])) {
					isValid = false;
					break;
				}
			}
		}
		
		if(isValid) {
			Joomla.submitform(task);
			return true;
		} else {
			alert(Joomla.JText._('COM_EVENTS_EVENT_ERROR_UNACCEPTABLE'));
			return false;
		}
	}
}