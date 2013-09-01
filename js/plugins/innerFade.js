/* =========================================================

// jquery.innerfade.js

// Datum: 2008-02-14
// Firma: Medienfreunde Hofmann & Baldes GbR
// Author: Torsten Baldes
// Mail: t.baldes@medienfreunde.com
// Web: http://medienfreunde.com

// based on the work of Matt Oakes http://portfolio.gizone.co.uk/applications/slideshow/
// and Ralf S. Engelschall http://trainofthoughts.org/

 *
 *  <ul id="news"> 
 *      <li>content 1</li>
 *      <li>content 2</li>
 *      <li>content 3</li>
 *  </ul>
 *  
 *  $('#news').innerfade({ 
 *	  animationtype: Type of animation 'fade' or 'slide' (Default: 'fade'), 
 *	  speed: Fading-/Sliding-Speed in milliseconds or keywords (slow, normal or fast) (Default: 'normal'), 
 *	  timeout: Time between the fades in milliseconds (Default: '2000'), 
 *	  type: Type of slideshow: 'sequence', 'random' or 'random_start' (Default: 'sequence'), 
 * 		containerheight: Height of the containing element in any css-height-value (Default: 'auto'),
 *	  runningclass: CSS-Class which the container get’s applied (Default: 'innerfade'),
 *	  children: optional children selector (Default: null)
 *  }); 
 *

// ========================================================= */

(function($) {

    $.fn.innerfade = function(options) {
        return this.each(function() {   
            $.innerfade(this, options);
        });
    };

    $.innerfade = function(container, options) {
        var settings = {
        	'animationtype':    'fade',
            'speed':            'normal',
            'type':             'sequence',
            'timeout':          4000,
            'containerheight':  'auto',
            'runningclass':     'innerfade',
            'children':         null
        };
        
       	$.innerfade.current = 0;
       	 
        if (options)
            $.extend(settings, options);
        if (settings.children === null) {
            var elements = $(container).children();
            var elements = $('#fade li');
        } else
            var elements = $(container).children(settings.children);
        if (elements.length > 1) {
        	
            $(container).css('height', settings.containerheight).addClass(settings.runningclass);
            for (var i = 0; i < elements.length; i++) {
                $(elements[i]).css('z-index', String(elements.length-i)).css('position', 'absolute').hide();
            };
            if (settings.type == "sequence") {
                window.$fadeTimeout = setTimeout(function() {
                    $.innerfade.move(elements, settings, 'goNext');
                }, settings.timeout);
                $(elements[0]).show();
            } else if (settings.type == "random") {
            		var last = Math.floor ( Math.random () * ( elements.length ) );
                setTimeout(function() {
                    do { 
						current = Math.floor ( Math.random ( ) * ( elements.length ) );
						} while (last == current );             
						$.innerfade.animate(elements, settings, current, last);
                }, settings.timeout);
                $(elements[last]).show();
						} else if ( settings.type == 'random_start' ) {
								settings.type = 'sequence';
								var current = Math.floor ( Math.random () * ( elements.length ) );
								setTimeout(function(){
									$.innerfade.animate(elements, settings, (current + 1) %  elements.length, current);
								}, settings.timeout);
								$(elements[current]).show();
						}	else {
							alert('Innerfade-Type must either be \'sequence\', \'random\' or \'random_start\'');
						}
		}
		if (!window.$started) {//if we hide and after that reveal we every time add event to this buttons, that is wy we limit it
			$('#nextFade').click(function(){$.innerfade.move(elements, settings, 'goNext')});
			$('#prevFade').click(function(){$.innerfade.move(elements, settings, 'goPrev')});
		}
    };

    /**
	 * Funkcija rawitivaet kakie img vzatj kgoda nuzen next i prev imagi
	 */
	$.innerfade.move = function(elements, settings, moveType) {
		
		//alert("moving");
		current = $.innerfade.current;
		window.clearTimeout(window.$fadeTimeout);
		window.$fadeTimeout = null;
//		alert("cur"+current);
//		alert("length"+elements.length);
//		for ($i= 0; $i < elements.length; $i++) {
//			alert(elements[$i]);
//		}
		if (moveType == 'goNext') {
			if ((current+1) < elements.length) {//added-1
			 	current = current+1;
			 	last 	= current - 1;
			} else {
				current = 0;
				last = elements.length - 1;
			}
		} else {
			if (current > 0) {
			 	current = current-1;
			 	last	= current+1;
			} else {
				current = elements.length - 1;
				last = 0;
			}
		}

		$.innerfade.current = current;
		$.innerfade.animate(elements, settings, current, last);
	}
     
	 /**
	 * Funkcija samoi animacii fade`a
	 */
    $.innerfade.animate = function(elements, settings, current, last) {
        if (settings.animationtype == 'slide') {
            $(elements[last]).slideUp(settings.speed);
            $(elements[current]).slideDown(settings.speed);
        } else if (settings.animationtype == 'fade') {
        	$('#curImage').html(current+1);
            $(elements[last]).fadeOut(settings.speed);
            $(elements[current]).fadeIn(settings.speed, function() {
							removeFilter($(this)[0]);
						});
        } else {
            alert('Innerfade-animationtype must either be \'slide\' or \'fade\'');
        }

        window.$fadeTimeout = setTimeout((function() {
            $.innerfade.move(elements, settings, 'goNext');
        }), settings.timeout);
    };

})(jQuery);

// **** remove Opacity-Filter in ie ****
function removeFilter(element) {
	if(element.style.removeAttribute){
		element.style.removeAttribute('filter');
	}
}