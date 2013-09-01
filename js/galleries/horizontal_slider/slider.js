$(function() {
	var $rgGallery = $('#rg-gallery'),
		$esCarousel	= $rgGallery.find('div.es-carousel-wrapper'),
		$items	= $esCarousel.find('ul > li'),
		$itemsCount	= $items.length;
	
	if ( typeof gallery_slideshow_delay === "undefined" ){
		gallery_slideshow_delay = 4000;
	}
	
	Gallery	= (function() {
			
		var current	= 0, // index of the current item
		 	old		= 0, // index of the last viewed item
			mode 	= 'carousel',// mode : carousel || fullview
			slideshow_delay	= gallery_slideshow_delay, // transition delay during a slideshow
			slideshowTimer	= null, // timer for slideshow
			
			init = function() {
				// (not necessary) preloading the images here...
				$items.add('<img src="images/skins/konsus/building/ajax-loader.gif"/>').imagesLoaded( function() {
					//_addViewModes(); // add options
					_addImageWrapper(); // add large image wrapper
					_showImage( $items.eq( current ) , 'init'); // show first image
				});
				
				if( mode === 'carousel' )
					_initCarousel();
			},
			_initCarousel = function() {
				
				if ( typeof gallery_carousel_speed === "undefined" ){
					gallery_carousel_speed = 450;
				}
				if ( typeof gallery_carousel_image_width === "undefined" ){
					gallery_carousel_image_width = 158;
				}
				if ( typeof gallery_carousel_easing === "undefined" ){
					gallery_carousel_easing = '';
				}
				
				// we are using the elastislide plugin:
				$esCarousel.show().elastislide({
					speed	: gallery_carousel_speed,
					imageW 	: gallery_carousel_image_width,
					easing	: gallery_carousel_easing,
					onClick	: function( $item ) {
						old = current;
						current	= $item.index();
						_showImage($item);
					}
				});
				
				$esCarousel.elastislide( 'setCurrent', current );
				
			},
			_addViewModes = function() {
				
				// top right buttons: hide / show carousel
				var $viewfull	= $('<a href="#" class="rg-view-full"></a>'),
					$viewthumbs	= $('<a href="#" class="rg-view-thumbs rg-view-selected"></a>');
				
				$rgGallery.prepend( $('<div class="rg-view"/>').append( $viewfull ).append( $viewthumbs ) );
				
				$viewfull.on('click.rgGallery', function( event ) {
						if( mode === 'carousel' )
							$esCarousel.elastislide( 'destroy' );
						$esCarousel.hide();
					$viewfull.addClass('rg-view-selected');
					$viewthumbs.removeClass('rg-view-selected');
					mode	= 'fullview';
					return false;
				});
				
				$viewthumbs.on('click.rgGallery', function( event ) {
					_initCarousel();
					$viewthumbs.addClass('rg-view-selected');
					$viewfull.removeClass('rg-view-selected');
					mode	= 'carousel';
					return false;
				});
				
				if( mode === 'fullview' )
					$viewfull.trigger('click');
					
			},
			_addImageWrapper = function() {
				
				// adds the structure for the large image and the navigation buttons (if total items > 1)
				// also initializes the navigation events
				$('#img-wrapper-tmpl').tmpl( {itemsCount : $itemsCount} ).prependTo( $rgGallery );
				
				//prealoading buttons with background images
				buttons = $('.bg-img-button');
				
				if( $itemsCount > 1 ) {
					// addNavigation
					var $navPrev		= $rgGallery.find('a.rg-image-nav-prev'),
						$navNext		= $rgGallery.find('a.rg-image-nav-next'),
						$slideshow		= $rgGallery.find('a.rg-image-slideshow'),
						$imgWrapper		= $rgGallery.find('div.rg-image');
						
					$navPrev.on('click.rgGallery', function( event ) {
						_stopSlideshow();
						_navigate( 'left' );
						return false;
					});	
					
					$navNext.on('click.rgGallery', function( event ) {
						_stopSlideshow();
						_navigate( 'right' );
						return false;
					});
					
					$slideshow.on('click.rgGallery', function( event ) {
						if ( $(this).hasClass('stop') ) {
							_stopSlideshow();
						} else {
							_startSlideshow();
						}
						return false;
					});
				
					// add touchwipe events on the large image wrapper
					$imgWrapper.touchwipe({
						wipeLeft: function() {
							_navigate( 'right' );
						},
						wipeRight: function() {
							_navigate( 'left' );
						},
						preventDefaultEvents: false
					});
				
					$(document).on('keyup.rgGallery', function( event ) {
						if (event.keyCode == 39)
							_navigate( 'right' );
						else if (event.keyCode == 37)
							_navigate( 'left' );	
					});
					
				}
				
			},
			_startSlideshow = function() {
				$rgGallery.find('a.rg-image-slideshow').text('Stop slideshow').addClass('stop');
			    slideshowTimer = setInterval( function(){
			    	_navigate( 'right' );
			    }, slideshow_delay );
			},
			_stopSlideshow = function() {
				$rgGallery.find('a.rg-image-slideshow').text('Play slideshow').removeClass('stop');
				clearInterval( slideshowTimer );
			},
			_navigate = function( dir ) {
				
				// navigate through the large images
				old  = current;
				
				if( dir === 'right' ) {
					if( current + 1 >= $itemsCount )
						current = 0;
					else
						++current;
				}
				else if( dir === 'left' ) {
					if( current - 1 < 0 )
						current = $itemsCount - 1;
					else
						--current;
				}
				
				_showImage( $items.eq( current ) );
				
			},
			_showImage = function( $item, $context ) {
				
				// shows the large image that is associated to the $item
				var idx = old;
				
				//if we click the currently displayed image then we do nothing
				if ( current == idx && $context !== 'init' ) {
					return;
				}
				
				var $loader	= $rgGallery.find('div.rg-loading').show();
				
				$items.removeClass('selected');
				$item.addClass('selected');
					 
				var $thumb		= $item.find('img'),
					largesrc	= $thumb.data('large'),
					title		= $thumb.attr('title'),
					descript	= $thumb.data('description');
				
				$('<img/>').load( function() {
					
					//updating number of currently displayed image
					$rgGallery.find('span.rg-image-pos-current').text( current+1 );
					
					// sliding new image in
					if ( $context !== 'init' ) {
						
						var $currentImage = $rgGallery.find('img').filter(":first"),
							currentImageWidth = $currentImage.width();
						
						var $newImage = $('<img alt="" src="' + largesrc + '">').css('left',currentImageWidth + 'px');
						
						if( $rgGallery.find('div.rg-image').find('img').length > 1)
							$rgGallery.find('div.rg-image').find('img:last').remove();
						
						$rgGallery.find('div.rg-image').prepend( $newImage );
						
						var newImageWidth = $newImage.width();
						
						//check animation direction
					    if ( current < idx ){
					        $newImage.css('left',-newImageWidth + 'px');
					        currentImageWidth = -newImageWidth;
					    }
					    
					    //(same like new image width)
					    $rgGallery.find('div.rg-image-container').stop().animate({
					    	width: newImageWidth + 'px',
					        height: $newImage.height() + 'px',
					        useTranslate3d: true
					    },350 );
					    
					    //animate the new image in
					    $newImage.stop().animate({
					        left: '0px',
					        useTranslate3d: true
					    },350 );
					    
					    //animate the old image out
					    $currentImage.stop().animate({
					        left: -currentImageWidth + 'px',
					        useTranslate3d: true
					    },350);
					    
					} else {
						img = $('<img alt="" src="' + largesrc + '">').load(function(){
							self = $(this);
							$rgGallery.find('div.rg-image').append(this).addClass('loaded');
							$rgGallery.find('div.rg-image-container').
															width(self.width()).
															height(self.height());
						});
						
					}
				    
					// adding image title and description
					if( title )
						$rgGallery.find('h2.rg-caption').show().empty().text( title );
					
					if( descript )
						$rgGallery.find('div.rg-description').show().empty().html( descript );
					
					$loader.hide();
					
					if( mode === 'carousel' ) {
						$esCarousel.elastislide( 'reload' );
						$esCarousel.elastislide( 'setCurrent', current );
					}
					
				}).attr( 'src', largesrc );
				
			},
			addItems = function( $new ) {
			
				$esCarousel.find('ul').append($new);
				$items 		= $items.add( $($new) );
				$itemsCount	= $items.length; 
				$esCarousel.elastislide( 'add', $new );
			
			};
		
		return { 
			init 	: init,
			addItems: addItems
		};
	
	})();

	Gallery.init();
});