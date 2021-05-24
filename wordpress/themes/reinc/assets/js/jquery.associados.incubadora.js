var ASSOCIADOS_SINGLE = (function ($, window, document, undefined) {
	'use strict';

	var associados_single = {} || ASSOCIADOS_SINGLE;

	var filter = [],
		toggle_all = false,
		text_empty = "Nenhum resultado encontrado",
		url_action = 'http://www.reinc.org.br/wp-json/reinc-api/v1/get_empresas_per_incubadora';

	var incubadora_id = $('.accordion-content__list_item > a').data('associate');

	var $associates_result = $('#associates_result');

	var tranlate_text = function() {
		var lang = $('html').attr('lang');
		if (lang === "en_US") {
			text_empty = "no results found"
		} else {

		}
 	},
	toggle_content = function () {
		$('.filters-container').on('click', '.accordion-title', function(event) {
			$('.filters-container').toggleClass('active');
			$associates_result.slideToggle();
			$('.filter-associados-incubadoras .accordion-content').slideToggle();
		});
	},
	on_click_filter = function() {

		$('.accordion-content__list_item').on('click', 'a', function(event) {
			event.preventDefault();
			var current_type = $(this).data('type');

			if (current_type === 'all') {
				filter = [];
				$(this).parent('li').parent('ul').find('li > a').removeClass('active');
				$('[data-type="all"]').addClass('active');
				toggle_all = false;
			} else {
				toggle_all = true;
				$(this).toggleClass('active');
				$(this).parent('li').parent('ul').find('a[data-type="all"]').removeClass('active');
				toggle_type(current_type);
			}

			if (filter.length == 0){
				toggle_all = false;
			}

			get_json_associates();
		});
	},
	toggle_type = function (type) {
		var itemIndex;
		itemIndex = filter.indexOf(type);
		if (itemIndex == -1) {
			filter.push(type);
		} else {
			filter = filter.filter(function(i) {
					return i != type;
			});
		}
	},
	get_json_associates = function(posts_per_page, paged) {
		var html_out = '';

		posts_per_page = typeof posts_per_page !== 'undefined' ?  posts_per_page : -1;
		paged = typeof paged !== 'undefined' ?  paged : 1;

		$('.associate_loading').fadeIn();

		$.getJSON(
			url_action,
			{
				"inc_id": incubadora_id,
				"filter": {
					"terms": filter,
					"posts_per_page": posts_per_page
				}
			}
		).done(function(data){
			var post = data.posts;
			if (post !== null) {
				for (var i = 0; i < post.length; i++) {
					html_out += "<div class=\"associate_item load col-xs-3 col-sm-3 col-md-3\">";
						html_out += "<div class=\"item-container "+post[i].type +" \">";
							html_out += "<a class=\"link\" href=\""+post[i].link+"\">";
								if(post[i].logotipo.thumbnail){
									html_out += "<img src=\""+post[i].logotipo.thumbnail+"\" alt=\""+post[i].title+"\">";
								} else {
									html_out += "<img src=\"http://www.reinc.org.br/wp-content/themes/reinc/assets/img/thumb-default-150.png\"  alt=\""+post.title+"\">"; 							}
								html_out += "<h3 class=\"h3\">"+post[i].title+"</h3>";
							html_out += "</a>";
						html_out += "</div>";
					html_out += "</div>";
				}
			} else {
				html_out += "<div class=\"col-xs-12 col-sm-12 col-md-12 associates_not_found\">";
					html_out += "<button class=\"btn btn-lg\" disabled>";
						html_out += "<span class=\"fa fa-close\"></span>" + text_empty;
					html_out += "</button>";
				html_out += "</div>";
			}
		 	$associates_result.html('');
			$associates_result.append(html_out);

			$('.associate_loading').fadeOut();
		});

		if (toggle_all === false) {
			$('[data-associate="'+incubadora_id+'"][data-type="all"]').addClass('active');
		}
	};
	associados_single.init = function(){
		console.log("[ASSOCIADOS_SINGLE] : Init");
		get_json_associates();
		on_click_filter();
		toggle_content();
		$('.filters-container').addClass('active');
	};
	return associados_single;
}(jQuery, window, document));

ASSOCIADOS_SINGLE.init();
