$(document).ready( function(){
	var scMenu = $("#sc_menu");
	$curPos    = 0;
	$onPage	   = 7;
	$itemWidth = 121;
	$padding   = 8;
	$count     = $('.blocks').children().size();
	
	$totalWidth = ($itemWidth + $padding) * $count;
	$('.blocks').width($totalWidth);
    $('#sc_menu').jScrollHorizontalPane({scrollbarHeight:8, scrollbarMargin:0, animateInterval:50}); //, showArrows:true, arrowSize:26
  
    if ($count) {
	    $('#forward').click(function(){
	    	if ($curPos < ($count-$onPage)) {
	    		$curPos++;
				scMenu[0].scrollTo("li:eq("+$curPos+")");
	    	}
		}) ;
		$('#back').click(function(){
			if ($curPos > 0) {
				$curPos--;
				scMenu[0].scrollTo("li:eq("+$curPos+")");
			}
		})
    }
})

// ]]] Horizontal scroll image gallery
/*=======================================================================*/
// ]]] Draggable Popup images

	function openImg($imgSrc, $id) {
		
		if (!document.getElementById($id)) {
			var container = $("#loader").append("<div class='popup-image-container' id='" +$id+ "' ><a href='#' onclick='closeImg(\"" +$id+ "\"); return false;' class='popup-close' title='close'></a></div>");
			var img = new Image();
			$(img).attr('src', $imgSrc).load(function () {
			  $(this).hide();
		      $('#'+$id).append(this);
		      $(this).fadeIn();
		      $(this).addClass('popup-image');
		      $(this).attr('title', 'you can reposition the image by dragging it');
		    });
		    $(img).dblclick(function(){
		    	closeImg($id);
		    })
		    $('#'+$id).draggable();
		} else {
			$('#'+$id).fadeIn();
		}
	}
	
	function closeImg($id) {
		$('#'+$id).hide();
	}