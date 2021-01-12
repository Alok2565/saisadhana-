// [MASTER SCRIPT]
//	Project     :	Arisen
//	Version     :	1.0
//	Last Change : 	05/07/2017
//	Primary Use :   Arisen
jQuery(document).ready(function($) {
	"use strict"; //Start of Use Strict		
	
	/* hook theme-option css after elementor css in html head section */
	if($('head').find('#arisen-theme-custom-style-css, #elementor-frontend-css').length){
		$('#arisen-theme-custom-style-css').detach().insertAfter('#elementor-frontend-css');
	}	
	
	/* document on scroll - show/hide menu with active */
	$(document).on('scroll',function() {
		arisen_menuActive(); // active menu on scroll
	});	

	/* scroll to section - menu selected from blog page */
	function arisen_sectionActive(){
		if(window.location.hash) {			
			var hash = window.location.hash; 
			
			if($( hash ).length){
				
				var top_pos;
				if($('#top_nav').hasClass('navbar-fixed-top')){
					top_pos = 60;
				}else{
					top_pos = 0;
				}
				
				$('html, body').animate({
					scrollTop: $( hash ).offset().top -top_pos
				}, 2000);
			}
		}
		return false;
	}

	/* function add/remove class 'active' dynamically on page load/scroll */
	function arisen_menuActive(){
		var scrollPos = $(window).scrollTop()+100;
		
		$('ul.nav li a').each(function () {			
			if($(this).attr('href').indexOf('#') != -1 && !$(this).hasClass('dropdown-toggle')){
				var currLink = $(this);
				var url = $(this).attr('href');
				var href = url.substring(url.lastIndexOf('/') + 1);
				var tabValue = href;
				
				if(tabValue != ''){
					if ($( tabValue ).length){
						if ($( tabValue ).position().top <= scrollPos && $( tabValue ).position().top + $( tabValue ).height() > scrollPos) {
							$('ul.nav li.active').removeClass("active");
							currLink.parent().removeClass("active");
							currLink.parent().addClass("active");
						}
						else{
							currLink.parent().removeClass("active");
						}
					}else{
						return false;
					}
				}
			}
		});
	}

	/* Header nav menu smooth scroll on click */
	$('ul.nav').on('click', 'li a',function(event){
		
		if($(this).attr('href').indexOf('#') != -1 && !$(this).hasClass('dropdown-toggle')){ //has string # and not has submenu		 
		
			var disp = $("#bs-example-navbar-collapse-1").css('display');
			if(disp == 'block'){
				$("#bs-example-navbar-collapse-1").slideUp(500);
				$("#bs-example-navbar-collapse-1").addClass('out');
				$("#bs-example-navbar-collapse-1").removeClass('in');
			}else{
				$("#bs-example-navbar-collapse-1").removeClass('out');
			}

			var url = $(this).attr('href');
			var href = url.substring(url.lastIndexOf('/') + 1);
			var tabValue = href;
		
			if (!$("body").hasClass("page")) {	
				window.location.replace(url);
				return;
			}
			
			if(tabValue != ''){
				if($( tabValue ).length){
					var top_pos;
					if($('#top_nav').hasClass('navbar-fixed-top')){
						top_pos = 60;
					}else{
						top_pos = 0;
					}					
					$('html, body').animate({
						scrollTop: $( tabValue ).offset().top -top_pos
					}, 2000);
				}
			}					
			
			event.preventDefault();
			return false;				
		}		
	});
	
	/* Navbar toggle click event */
	$('.navbar-default').on('click', '.navbar-toggle', function(event){
		$(".navbar-collapse").removeClass('out');
		if($(".navbar-collapse").css('display') == 'block'){
				$(".navbar-collapse").slideUp();
		}else{
			$(".navbar-collapse").slideDown();
		}
	});

	/* mc-signup form message reset */
	if($('.mc4wp-response').find('.mc4wp-alert').length){
		$('.form-control.sub-input').val('');
		$('.mc4wp-alert').show().delay(7000).fadeOut();
	}	
	 
	$(window).load(function() {	
		 arisen_sectionActive(); //section visible on clip board
		 arisen_menuActive(); //active menu on scroll		
		 $('.form-control.sub-input').val('');
	});	
	return false;

// End of use strict
});