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

	function BeginListAnimation() {
		$('body.node-type-work .field-field-projectimages .field-item:hidden:first').fadeIn(2000, function(){
		BeginListAnimation();
		});
	}

	$(document).ready(function(){

		var ie55 = (navigator.appName == "Microsoft Internet Explorer" && parseInt(navigator.appVersion) == 4 && navigator.appVersion.indexOf("MSIE 5.5") != -1);
		var ie6  = (navigator.appName == "Microsoft Internet Explorer" && parseInt(navigator.appVersion) == 4 && navigator.appVersion.indexOf("MSIE 6.0") != -1);
		if ($.browser.msie && (ie55 || ie6)) {
			$(document).pngFix();
		}
		
		$("#body").fadeIn(1500);

		/*=======================================================================*/
		//navigation animation
	    
		$('#navigation .menu li:not(.active) a').each(function(index, obj){
	    	$(obj).css('background', '#dce1e4');
	    	$(obj).mouseover(function(){
		    	$(this).animate({ 
			        backgroundColor: "#474a53",
			        color: 'white'
			    }, 800);	
	    	})
	    })
	    $('#navigation .menu li:not(.active) a').mouseout(function(){
	    	$(this).animate({ 
		        backgroundColor: "#dce1e4",
		        color: 'black'
		    }, 400);	
	    })
		$('#navigation-left li.active a').animate({
			paddingLeft: '38'
		}, 1800);
		
		//article animation
		$('body.node-type-work .field-field-projectimages .field-item').hide();
		BeginListAnimation();
		
		/*=======================================================================*/
		//portfolio animation
		
			
		
		/*=======================================================================*/
		//Buttons
		
		$('#formOpener').click(function(){
			if ($('#commentForm').css('display') == 'none') {
				$('#commentForm').fadeIn(500);
				$.scrollTo('#commentForm', 800);
			} else {
				$('#commentForm').fadeOut(500);
			}
			return false;
		});

		/*=======================================================================*/
		//Images
		
		 externallinks();
		 $("a.simpleImage").fancybox({
		 	'hideOnContentClick': true
		 });
		 $("a.group").fancybox({
		 	'zoomSpeedIn' : 300, 
		 	'zoomSpeedOut': 300,
		 	'easingIn'	  : 'easeOutBack',
			'easingOut'	  : 'easeInBack'
		 }); 

		 $("a.ajaxLink").fancybox({
		 	'frameWidth'  : 770,
		 	'frameHeight' : 480,
		  	'zoomSpeedIn' : 300, 
		 	'zoomSpeedOut': 300,
		 	'easingIn'	  : 'easeOutBack',
			'easingOut'	  : 'easeInBack',
			'hideOnContentClick': false,
			'zoomOpacity' : true,
			'padding'	  : 0
		 });
		 
		 $("#firstImg").trigger("click");	
	});
	;

	function openWin($url){
		windowWidth  = $(document).width();
		windowHeight = $(document).height();
		window.open($url, 'mainWindow', 'status=yes, location=yes, resizable=yes, scrollbars=yes, toolbar=no, menubar=no, width='+windowWidth+', height='+windowHeight+', left=0, top=0');
		return false;
	}
		
	function changeImg($obj, $src){
		$obj.src = $src;
	}
	
/*=======================================================================*/
// [[[ Ajax gallereja

	function ajaxGallery($id){
		
		return false;
	}
	
// ]]] Ajax gallereja
/*=======================================================================*/
// [[[ Submiting buttons

	function submitSearch(){
		
		$value = $.trim($("#searchField").attr('value'));
		if ($value.length <3 ) {
			alert("MÄ“klÄ“Å¡anas vÄ�rdam jÄ�bÅ«t 3 vai vairÄ�k simboliem");
			return false;
		}
		document.forms['wizard_form'].submit();
		return false;
	}	
	
	function checkCommentField(){
		$value = $.trim($("#comentField").val());
		if ($value.length >2000 ) {
			alert("KomentÄ�rs nevar bÅ«t lielÄ�ks par 2000 simboliem");
			$("#comentField").attr('value', $value.substr(0,$value.length-1));
		}
	}

// ]]] Submiting buttons
/*=======================================================================*/
// [[[ Opening/ Closing

	function OpenCloseProject($obj){
		
		$uls 	= $($obj).parent().find('ul');
		$status = $($obj).attr('status');
		if (!$uls.length) return;
		
		$($obj).toggleClass("act");
		if (!$status) $status = 'closed';
		if ($status == 'closed') {
			//opening hidden ul list
			$uls.show('normal');
			$newStatus = 'opened';
		} else {
			//closing
			$uls.hide('normal');
			$newStatus = 'closed';
		}
		$($obj).attr('status', $newStatus);
	}
	
	var $timeout;
	
	function showHideSertificate($sertImg, e){
		
		if (!e) e = window.event;
		
		$status = $('#sertificate').attr('status');
		if ($status == 'opened') {
			$timeout = setTimeout('hideSertificate()', 700);
		} else {
			if ($timeout) {
				clearTimeout($timeout);
			}
			eleOffset = $('#sertificate').position();
			$('#sertificate').css({
				'left' 	 : e.clientX+20,
				'top' 	 : e.clientY-80
				//'display': 'block'
			});
			$('#sertificate').show(400);
			$('#sertificate').attr('status', 'opened');
			$('#sertificate img:last').attr('src', "images/building/"+$sertImg);
		}
	}
	
	function hideSertificate(){
		$('#sertificate').css('display','none');
		$('#sertificate').attr('status', 'hidden');
	}

// ]]] Opening/ Closing
/*=======================================================================*/