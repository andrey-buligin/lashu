$(document).ready(function(){
	$("#commentForm").formValidation({
		name: {
			type: "text",
			selector: "#nameField",
			helperSelector: "#nameInfo"
		},
		email: {
			type: "email",
			selector: "#emailField",
			helperSelector: "#emailInfo"
		},
		comment: {
			type: "textarea",
			selector: "#commentField",
			helperSelector: ""
		}
	});
});