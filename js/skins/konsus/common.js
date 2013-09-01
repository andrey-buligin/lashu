
/*=======================================================================*/
// [[[ Links opening in other window

	function externallinks(){
	    var c=document;
	    if(c){
	        var ls=c.getElementsByTagName('a');
	        for(var i=0; i<ls.length; i++){
	        	
				if(ls[i].getAttribute('target')) {
					if (ls[i].getAttribute('target') == '_blank') {
						ls[i].setAttribute('rel','external');
					}
					ls[i].removeAttribute('target');
				}
	            if(ls[i].getAttribute('rel')=='external'){
	                ls[i].className+=ls[i].className?' extlink':'extlink';
	                ls[i].title+='(opens in new window)';
	                ls[i].onclick=function(){window.open(this.href);return false}
	            }
	        }
	    }
	}

// ]]] Links opening in other window
/*=======================================================================*/
// [[[ Actions that are connected to big header baner, its moving, closing, image rotating

	$(document).ready( function(){ 
		
		var ie55 = (navigator.appName == "Microsoft Internet Explorer" && parseInt(navigator.appVersion) == 4 && navigator.appVersion.indexOf("MSIE 5.5") != -1);
		var ie6  = (navigator.appName == "Microsoft Internet Explorer" && parseInt(navigator.appVersion) == 4 && navigator.appVersion.indexOf("MSIE 6.0") != -1);
		if ($.browser.msie && (ie55 || ie6)) {
			$(document).pngFix();
		}

		externallinks();
		
	    $('#fade').innerfade({ 
	    	timeout: 3000, 
	    	type: 'sequence',
	    	speed: 2000,
	    	containerheight: '440px'
	    });
	    
		//animating album navigation
		var top = '-' + $('#albumNav').css('height');
		$("#selectLink").toggle(function(){
			$("#albumNav").stop().animate({"top": 0},{queue:false, duration:600, easing: 'easeOutBounce'})
		}, function(){
			$("#albumNav").stop().animate({"top": top},{queue:false, duration:600, easing: 'easeOutBounce'})
		});	
		
		$("#selectLink img").hover(function() {
			$(this).attr("src", 'images/skins/konsus/building/ClickMe.jpg');
		}, function() {
			$(this).attr("src", 'images/skins/konsus/building/ClickMeO.jpg');
		});


		//animating fotogallery
/*		 $("a.group").fancybox({
		 	'zoomSpeedIn' : 300, 
		 	'zoomSpeedOut': 300,
		 	'easingIn'	  : 'easeOutBack',
			'easingOut'	  : 'easeInBack'
		 }); 
		 */
		 $('#formOpener').toggle(function(){
			$('#form').css('display', 'block');
			$("#form :input:visible:enabled:last").focus();
		 }, function(){
			$('#form').hide('normal');
		 });
		 //
//		 $("a.simpleImage").fancybox({
//		 	'hideOnContentClick': true,
//		 	'zoomSpeedIn' : 300, 
//		 	'zoomSpeedOut': 300,
//		 	'easingIn'	  : 'easeOutBack',
//			'easingOut'	  : 'easeInBack'
//		 });

	}); 
	
	//napisatj funkckiju kotoraja zamenjajet pri uploade headeri na imagi.
	
// ]]] Actions that are connected to big header baner, its moving, closing, image rotating
/*=======================================================================*/