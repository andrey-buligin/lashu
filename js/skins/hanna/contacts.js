$(document).ready(function(){
	$('#customForm').formValidation({
		name: {
			type: 'text',
			selector: '#name',
			helperSelector: '#nameInfo'
		},
		email: {
			type: 'email',
			selector: '#email',
			helperSelector: '#emailInfo'
		},
		comment: {
			type: 'textarea',
			selector: '#message',
			helperSelector: '#message'
		}
	});
});