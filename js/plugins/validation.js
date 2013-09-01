/******************************************************/
//@Author: Andrey Buligin
//@website: www.andreybuligin.com
//@email: buligin.developer@gmail.com

(function( $ ) {

	$.fn.formValidation = function(options) {

		var self = this,
			form = $(this),
			elements = [],
			elementsFunc = [];

		if (options) {

			$.each(options, function(index, object) {
				var el = $(object.selector),
					elHelper = $(object.helperSelector),
					validationFunc;

				elements.push(el);

				switch (object.type) {
					case 'text': validationFunc = function() {
									return validateText(el, elHelper);
								};
								break;
					case 'email': validationFunc = function(){
									return validateEmail(el, elHelper);
								};
								break;
					case 'textarea': validationFunc = function(){
									return validateTextarea(el);
								};
								break;
				}

				el.blur(validationFunc);
				el.keyup(validationFunc);

				elementsFunc.push(validationFunc);
			});

			//On Submitting
			form.submit(function() {
				var isValid = true;

				for (i = 0; i < elementsFunc.length; i++) {
					if (!isValid) break;
					isValid = elementsFunc[i]();
				}

				if ( isValid ) {
					return true;
				} else {
					return false;
				}
			});

		}

		//validation functions
		function validateEmail(el, elHelper) {
			var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;

			if ( filter.test(el.val()) ) {
				el.removeClass("error");
				elHelper.text("");
				elHelper.removeClass("error");
				return true;
			} else {
				el.addClass("error");
				elHelper.text("Please type a valid e-mail address!");
				elHelper.addClass("error");
				return false;
			}
		}

		function validateText(el, elHelper) {
			var val = el.val(),
				filter = /^[a-zA-Z_.\-\s]+$/;

			if ( val.length < 3 || !filter.test(val) ) {
				el.addClass("error");
				elHelper.text("Please type valid name with more than 2 letters!");
				elHelper.addClass("error");
				return false;
			} else {
				el.removeClass("error");
				elHelper.text("");
				elHelper.removeClass("error");
				return true;
			}
		}

		function validatePhone(el, elHelper) {

		}

		function validateTextarea(el) {
			if ( el.val().length < 10 ) {
				el.addClass("error");
				return false;
			} else {
				el.removeClass("error");
				return true;
			}
		}

	};
})( jQuery );