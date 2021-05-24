'use strict';
var ATIVIDADES = (function ($, window, document, undefined) {
	var atividades = {} || ATIVIDADES;
	var $filter_content = $('ul.filter-atividades').find('li');
	var $atividades_content = $('.list-atividades').find('ul');

	var filter_click = function() {
		$filter_content.on('click', 'a', function(event){
			event.preventDefault();
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
				$atividades_content.find('li').fadeIn();
			} else {
				var href = $(this).attr('href');
				var action = href.split('categoria/atividades');
				var filter = action[1].split('/');

				$filter_content.find('a').removeClass('active');
				$(this).addClass('active');
				$atividades_content.find('.'+filter[1]+'').addClass('p-absolute');
				$atividades_content.find('li').not('li.'+filter[1]+'').fadeOut(300);
				setTimeout(function(){
					$atividades_content.find('.'+filter[1]+'').fadeIn().removeClass('p-absolute');
				}, 300);
			}
			//console.log(filter[1]);
		});
	},
	tabs_init =  function () {
		var filter = $('ul.filter-atividades li:first-child').find('> a').data('filter');

		$atividades_content.find('> li').fadeOut();
		$filter_content.find('> a').removeClass('active');

		$('ul.filter-atividades li:first-child').find('> a').addClass('active');
		$('.'+filter).fadeIn();
		$('.content-internal-pages').fadeIn();

	},
	accordion_click = function(){
		$('.accordion-content').slideUp();
		$atividades_content.on('click', 'h3', function(){
			$('.accordion-content').slideUp().parent('li').removeClass('active');
			if ($(this).find('+ .accordion-content').is(":visible") == true) {
				$(this).find('+ .accordion-content').slideUp().parent('li').removeClass('active');
			} else {
				$(this).find('+ .accordion-content').slideDown().parent('li').addClass('active');
			}
		});
	};
	atividades.init = function(){
		console.log("[FUNCTION] : Atividades");
		tabs_init();
		filter_click();
		accordion_click();
	};
	return atividades;
}(jQuery, window, document));

ATIVIDADES.init();
