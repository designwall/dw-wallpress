/*-----------------------------------------------------------------------------------*/
/*	Fix page tempale jigoshop
/*-----------------------------------------------------------------------------------*/
jQuery(function($){
	$('.page-template-layout-shop-php, .item').removeClass('page');
	$('.page-template-layout-shop-php').addClass('jigoshop');
});

/*-----------------------------------------------------------------------------------*/
/*	MENU HOVER ON TOUCH-able DEVICE
/*-----------------------------------------------------------------------------------*/
jQuery(function($){
	//Fix dropdown bootstrap
	$('body').on('touchstart.dropdown', '.dropdown-menu', function (e) { 
		e.stopPropagation(); 
	}).on('touchstart.dropdown', '.dropdown-submenu', function (e) {
		e.preventDefault();
	});

	if( 'ontouchstart' in document.documentElement ) {
		//fix ontouch on shop page
		$('html,body').unbind('touchstart');	
		var clickable = null;
			$('#access .menu-item').each(function(){
				var $this = $(this);

				if( $this.find('ul.sub-menu').length > 0 ) {

					$this.find('a:first').unbind('click').bind('touchstart',function(event){
						if( clickable != this ) {
							clickable = this;
							event.preventDefault();
						} else {
							clickable = null;
						}
					});
				}
		});
	}
});


/**
 * DW Wallpress Theme
 * ----------------------------------------------------------------------
 * Javascript required at theme startup
 * 
 */

jQuery(document).ready(function($) {
	var screen_height = $(window).height();
	$('#content.masonry').css({'min-height': screen_height + 1});
	
	// Masonry container
	var $container = $('.masonry'); 

	// Item selector 
	var item_selector = '.item';    

	/**
	 * [ Show/hide sidebar control ]
	 */
	$('#header .sidebar-control').click(function(){
		$('body').toggleClass('sidebar-on');
	    $('#header').attr('style','');
		$('#header .sidebar-control').toggleClass('sidebar-on');
			if($('.navigation-control').is(':visible')){
				$('#navigation:visible').hide();
			}
		$(window).trigger('resize');
	});

	/**
	 * [ Show/hide menu control ]
	 */
	$('#header .navigation-control').click(function(){
		$('#navigation').slideToggle(function(){
			if($('#navigation').is(":visible")){
			  $('html,body').animate({scrollTop:0},500);
      	$('#header').css('position','absolute');
     	}
			else{
				$('#header').attr('style','');
			}

		});
		if($('.navigation-control').is(':visible')&& $('#sidebar').is(':visible') ){
			$('body').toggleClass('sidebar-on');
		}
		
	});


    /**
     * Scrolltop button 
     */
    
    // Timeout for Scrolltop button show
    var scrollTimeout;   

    $('a.scroll-top').click(function(){
    	$('html,body').animate({scrollTop:0},500);
    	return false;
    });

	$(window).scroll(function(){
         clearTimeout(scrollTimeout);
          if($(window).scrollTop()>400){
          	  scrollTimeout = setTimeout(function(){$('a.scroll-top:hidden').fadeIn()},300);
          }
          else{
          	  scrollTimeout = setTimeout(function(){$('a.scroll-top:visible').fadeOut()},300);	
          }

	});


	/**
	 * Add collapse icon for parent menu on mobile mode
	 */
	
	$('#header #navigation .menu > li').each(function(){
		if($(this).find('.sub-menu').length<1) return;
		$(this).addClass('parent')
		 $(this).append('<a href="#" class="ico-collapse"></a>').find('.ico-collapse').html('<i class="fa fa-angle-down"></i>')
		 	.click(function(){
		 			if($(this).prev().is(':visible')){$(this).prev().slideToggle(); return;}
		 			
 					$('#header #navigation .menu >li > .sub-menu:visible').slideToggle();
 					$(this).prev().slideToggle();
 					return false;
				}
			);

		});

	// Trigger window resize when tabs changing in Jigoshop item detail
	$('div#tabs ul.tabs li > a').bind('click',function(){
	    $(window).trigger('resize');
	});


   // Init Sidebar IScroll
   if(document.getElementById('sidebar')){
		window.sidebarScroll = new iScroll('sidebar',{vScrollbar: true, scrollbarClass: 'sidebarTracker'});
		setTimeout(function(){$('.sidebarTrackerV').css({opacity:0}); },1000);
		//Active form iput for iscroll
		$('#sidebar').find('select,input').each(function(){
			$(this).on('touchstart',function(e){
				e.stopPropagation();
			})
		});
	}

	// add a blank, invisible masonry block to get the base width
	if (!$('#base-blank-item').length) {
		$('<div id="base-blank-item" class="'+item_selector.substr(1)+'" style="height:0;visibility:hidden" />').appendTo ($container);
	}


	var reloadSidebar = function(){
		//Reload sidebar
		   var sbtop = $('#wpadminbar').height()+$('#header').height();
		   var sbmrg = sbtop;
		   if($(window).width()<=900) {
		   		sbtop=sbtop;
		   		sbmrg = sbtop;
		   		if(!$('body').hasClass('sidebar-on')){
					$('#navigation:visible').hide();
				}
			}
			else{
				if($('#header').css('position')=='absolute'){
					$('#header').css('position','');
				}
				//$('#navigation').show();

			}
			
	       var sbheight = $(window).height() - sbmrg;
	       
	       $('#sidebar').css({top:sbtop,height:sbheight});
	       
	       if(document.getElementById('sidebar')){
		    	window.sidebarScroll.refresh();
	    	}
	} 

	/**
	 * [reloadMasonry & reload sidebar scroll ]
	 */
	var reloadMasonry = function () {
		//trigger mansory reload
		$('body').addClass('masonry-relayout');
		$container.masonry('reload',function(){$('body').removeClass('masonry-relayout')});
		reloadSidebar();
	}; 



	var updateWidthTimeout = 0;
	var reloadTimeout = 0;
	var basewidth =200;
	var updateMasonryContainerWidth = function () {
		// wrapper width
		var cw = $('#base-blank-item').width();
		
		// wrap width
		var mw = $container.width ();
		
		//  detect number of columns by it's container
		var cols = Math.round(mw / cw);
		// update new width
		var cw_ = Math.floor (mw / cols);
		var mw_ = cols * cw_;     
		if ($container.data('basewidth') != cw_) {
			$container.data('basewidth', cw_);
			basewidth = cw_;
			updateBrickWidth ();
		}

		//Reload gallery
		reload_gallery();

		// reload layout
		reloadMasonry ();

	};

	var updateBrickWidth = function ($bricks) {

		if (!$bricks) $bricks = $container.find(item_selector);
		var cw_ = $container.data ('basewidth');
		//basewidth=cw_;
		
		if (!cw_) return;
		// update width for items
		$bricks.not('#base-blank-item').width (cw_);
		$bricks.filter('.grid-double').width(cw_*2);
		$bricks.filter('.grid-triple').width(cw_*3);

	};

	var reloadSetting = function () {
		// update masonry colwidth
		updateMasonryContainerWidth();


	};

	// init masonry
	$container.masonry({
		itemSelector: item_selector,
		isResizable: false,
		columnWidth: function() { 
			return  (basewidth==0)?200:basewidth;
		}
	});

	
	// Init second sidebar masonry
	if($('.sidebar-secondary-inner').length>0)
	{	
		$('.sidebar-secondary-inner').masonry({
			itemSelector: $('.widget'),
			isAnimated: true
		});
	}

	// reload masonry when image loaded
	$container.imagesLoaded(function(){
		reloadSetting ();
	});

	//fix gap when custom font loaded
	$(window).load(reloadMasonry);

	// create your jQuery window resize method. The clearTimeout() method prevents the
	$(window).resize(function(){
		clearTimeout( updateWidthTimeout );
		updateWidthTimeout = setTimeout(updateMasonryContainerWidth, 400);
	}); 
	 
  	 //ios rotate
	window.onorientationchange = function(){
		jQuery(window).scrollTop(1);
    	updateMasonryContainerWidth();
	}
	

	/* infinitive scroll for main masonry only */

	$('#content').infinitescroll({
		loading: {
		finished: undefined,
		finishedMsg: "<em>Oops, no more pages to load.</em>",
		msgText: "<em>Loading more items</em>",
		speed: 'fast',
		img: 'http://i.imgur.com/QrOjF.gif'
		},
		navSelector  : "div.navigation",            
		nextSelector : "div.navigation a:first",    
		itemSelector : "#content div.item"
	},function( newElms) {

		var $newElems = $( newElms ).css({ opacity: 0 });
		// ensure that images load before adding to masonry layout
		$newElems.imagesLoaded(function(){
			$newElems.animate({ opacity: 1 });
			// update bricks width
			updateBrickWidth ($newElems);
			$container.masonry( 'appended', $newElems, true ); 
			// trigger scroll again
			$(window).trigger('scroll');
			//add_popup();

			//Reload new item
			reload_jPlayer();
			fancyBox();
			reload_gallery();
		});
	});


	/**
	 * [fancybox initialization]
	 */
	var fancyBox = function(){
		if ( typeof jigoshop_params != 'undefined') {
			if ( jigoshop_params.load_fancybox ) {
				$('a.zoom, .gallery-item a').prettyPhoto(
				{
					animation_speed: 'normal',
					slideshow: 5000, 
					autoplay_slideshow: false, 
					show_title: false,
					theme: 'pp_default',
					horizontal_padding: 50,
					opacity: 0.7,
					overlay_gallery: false,
					deeplinking: false,
					social_tools: false
				});
			}
		}
	}

	fancyBox();

	/**
	 * Reload jPlayer effect after masonry reload
	 * @return null
	 */
	var reload_jPlayer = function(){
		jQuery('body').find('.jp-jplayer').each(function(){
			var selector = '#'+jQuery(this).attr('id');
			var selectorAncestor = '#'+ jQuery(this).attr('data-interface');
			var swfPath = jQuery(this).attr('data-swf');
			var mp3 = jQuery(this).attr('data-file');

			$(selector).jPlayer({
		        ready: function(event) {
		            jQuery(this).jPlayer("setMedia", {
		                mp3: mp3,
		            });
		        },
		        swfPath: swfPath,
		        cssSelectorAncestor: selectorAncestor,
		        supplied: "mp3, all"
		    });
		});
		return;
	}

	/** GALLERY POST FORMAT */
	
	/**
	 * Get numeric of css style
	 * @param  string css Css value
	 * @return int
	 */
	function wallpress_css_parseInt(css){
		if( css.length > 0 ){
			if( css.indexOf('px') > -1 ){
				return parseInt( css.replace('px', '') );
			}
		}
		return 0;
	}

	/**
	 * Get real width of item without border, padding and margin
	 * @return int
	 */
	function wallpress_getCoverHorizon( selector ){
		var padding 	= wallpress_css_parseInt($( selector ).css( 'padding-left' ));
		var border 		= wallpress_css_parseInt($( selector ).css( 'border-width' ));
		var margin 		= wallpress_css_parseInt($( selector ).css( 'margin-left' ));
		return ( padding + margin + border ) * 2 ;

	}

	/**
	 * Transform list item to gallery format
	 * @return {null}
	 */
	function wallpress_gallery(selector) {

		gallery_update_width(selector);

		var number = selector.find('.dw-gallery-item').length;
		var pagination = selector.find('.dw-gallery-pagination');
		pagination.html('');
		for(i=1;i <= number;i++){
			var pg_pos = '';
			if( i == 1) 
				pg_pos = ' class = " first" ';
			else if( i == number ) 
						pg_pos = ' class = "last" ';

	  		pagination.append('<li'+pg_pos+'>'+i+'</li>');
	    }	
	    pagination.find('li:first').addClass('active');

	    return;


	}

	function gallery_update_width(selector){
		var gallery = selector.find( '.dw-gallery' );
		gallery.css('margin-left',0);
		var number = gallery.find( '.dw-gallery-item' ).length;
		
		var base_cw = $('#base-blank-item').width();
		var container_w = $container.width();
		
		var cw;

		if( !$('#content').hasClass('masonry') ){
			cw = selector.parent().width();
		} else {
			if( $( selector ).closest('.masonry-brick').hasClass('grid-double') && container_w > 460 ){
				base_cw *= 2;
			} else if( $( selector ).closest('.masonry-brick').hasClass('grid-triple') && container_w > 682 ){
				base_cw *= 3;
			}else if( $( selector ).closest('.masonry-brick').hasClass('grid-triple') && container_w > 460 ){
				base_cw *= 2;
			} 
			cw =  base_cw - wallpress_getCoverHorizon( selector.parent() );
		}

		selector.data('gallery-cw',cw);

		gallery.width( cw * number );
		selector.find('.mask').width( cw );
		gallery.find( '.dw-gallery-item' ).width( cw );
	}

	function reload_gallery(){
		/** Find all gallery post format and apply gallery style */
		$('.dw-gallery-container').each(function(){
			wallpress_gallery($(this));
		});
	}

	/** Find all gallery post format and apply gallery style */
	$('.dw-gallery-container').each(function(){
			wallpress_gallery($(this));
	});

	/** Set active slide when pagination click  */
	$('.dw-gallery-pagination li').live('click',function(){

   		if($(this).is('.active') ) return;

   		$('.dw-gallery-pagination li').removeClass('active');
   		$(this).addClass('active');
   		var pageNum = parseInt($(this).text())-1;

   		var container = $(this).closest('.dw-gallery-container');
   		var gallery = container.find('.dw-gallery');
   		var length = container.find('.dw-gallery-item').length;

   		var cw = container.data('gallery-cw');

   		gallery.animate({marginLeft:-(pageNum*cw)},700);

   });

	$('.dw-gallery-next').live('click',function(){

		var container = $(this).closest('.dw-gallery-container'); 
   		var next = container.find('.dw-gallery-pagination li.active').next();
   		if(next.length<1) container.find('.dw-gallery-pagination li.first').click();
   		next.click();
   		return false;
   });

   $('.dw-gallery-prev').live('click',function(){
		var container = $(this).closest('.dw-gallery-container'); 
   		var next = container.find('.dw-gallery-pagination li.active').prev();
   		if(next.length<1) container.find('.dw-gallery-pagination li.last').click();
   		next.click();
   		return false;
   });

   //END GALLERY POST FORMAT
   
   //MENU HOVER ON TOUCH-able DEVICE
	if( 'ontouchstart' in document.documentElement ){
		var clickable = null;
		$('#menu-navigation .menu-item').each(function(){
			var $this = $(this);

			if( $this.find('ul.sub-menu').length > 0 ){

				$this.find('a:first').unbind('click').bind('touchstart',function(event){
					if( clickable != this ){
						clickable = this;
						event.preventDefault();
					}else{
						clickable = null;
					}
				});
			} 
	
		});

		
		
	}
	// END MENU HOVER ON TOUCH-ABLE DEVICE
	if( $('.masonry').height() < $(window).height() ){
		$('.masonry').css({'min-height':( $(window).height() + 1) + 'px' });
	}
	$(window).trigger('resize');

	// Header search
	$('#header #searchform').click(function(){
		$(this).find('#s').focus();
	});

});

jQuery('.masonry .item-actions a').live('click',function(e){
	window.location.href=jQuery(this).attr('href');
});
