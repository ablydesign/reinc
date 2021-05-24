'use strict';
var BIBLIOTECA = (function ($, window, document, undefined) {
	var biblioteca = {} || BIBLIOTECA;
	var $tabs_container = $('.tabs-container').find('.tabs-content');
	var $tabs_menu = $('.filter-content');
	var height_content;
	var tab_init = function() {

		$tabs_container.find('> div').fadeOut();
		$tabs_menu.find('> a').removeClass('active');

		var hash = window.location.hash;

		console.log(hash.slice(1));

		if (hash.length > 1) {
			console.log("null");
			$('[href="'+hash+'"]').addClass('active');
			$('[data-content="'+hash.slice(1)+'"]').fadeIn().addClass('active');
			$('[data-content="'+hash.slice(1)+'"]').parent().height($('[data-content="'+hash.slice(1)+'"]').height());
		} else {
			console.log("empty");
			$('[href="#documentos"]').addClass('active');
			$('[data-content="documentos"]').fadeIn().addClass('active');
			$('[data-content="documentos"]').parent().height($('[data-content="documentos"]').height());
		}
	},
	filter_click = function() {
		$tabs_menu.on('click', 'a', function(){
			var hash = $(this).attr('href');

			$tabs_menu.find('> a').removeClass('active');
			$tabs_container.find('> div').fadeOut();

			$(this).addClass('active');
			$('[data-content="'+hash.slice(1)+'"]').fadeIn();
		 	$('[data-content="'+hash.slice(1)+'"]').parent().height($('[data-content="'+hash.slice(1)+'"]').height());
		});
	},
	accordion_click = function(){
		$tabs_container.on('click', 'h3', function(){
			var $parent = $(this).parent().parent('.inner-content');
			if ($(this).find('+ .accordion-content').is(":visible") == true) {
				$(this).parent('div').removeClass('active-div');
			} else {
				$(this).parent('div').addClass('active-div');
			}
		});
	};
	biblioteca.init = function(){
		console.log("[FUNCTION] : Biblioteca");
		$(".accordion-container").accordion({
			collapsible: true,
			heightStyle: "content",
    		active: false
		});

		tab_init();

		filter_click();

	};
	return biblioteca;
}(jQuery, window, document));

BIBLIOTECA.init();
