var INTRANET = (function ($, window, document, undefined) {
	'use strict';
	var intra = {} || INTRANET;

	var add_projeto = function () {
		var parameter = {};
		$('#cadastro_projetos').on('submit', function(event){
			event.preventDefault();
			var values = $(this).serializeArray();
			parameter.action = 'custom_insert_projeto';
			$.each(values, function(index, field){
				parameter[field.name] = field.value;
			});
			ajax_action($(this), parameter);
		});
	};


	var open_modal = function() {
		$('.fancybox-modal').fancybox({
			padding: 5,
			openEffect: 'elastic',
			beforeShow: function () {

			}
		});
	};

	var gen_download = function() {
		$('[data-action="gen-xls"]').on('click', function(event){
			event.stopPropagation();
			$.ajax({
				type: 'GET',
				url: $(this).attr('href'),
				beforeSend: function() {
					$('#download-overlay').fadeIn();
				},
				complete: function() {
					$('#download-overlay').fadeOut();
				}
			});
		});
	};

	var search_container = function () {
		var controller = 0;
		$('input.search-text').each(function(){
			var rel = ($(this).data('rel'));
			var $input_field = $('#search-text__' + ($(this).data('rel')));
			var $search_container = $('div.search-container__' + rel);

			$search_container.sieve({
				searchInput: $input_field,
				itemSelector: 'div.content-item',
				toggle: function(item, match) {
					if (match === true) {
						++controller;
					}
					return item.toggle(match);
        		},
				complete: function() {
					$('[name="search-dropdown-'+rel+'"]').val('');
					if (controller === 0 ) {
						$('#content-none').show();
					} else {
						$('#content-none').hide();
					}
					controller = 0;
				}
			});
		});
	};

	var filter_cadastro = function () {
		$('.filter-cadastro__item').on('click', 'a', function(event){
			event.preventDefault();
			var rel = ($(this).data('associate'));
			var type = ($(this).data('type'));
			var text = ($(this).text());
			var $container = $('div.search-container__' + rel +' .content-item');
			var $input_field = $('input[name="search-dropdown-'+rel+'"]');

			if (type === 'all') {
				$input_field.val('');
			} else {
				$input_field.val(text);
			}

			$container.each(function() {
				if ($(this).hasClass(type) || type === 'all') {
					$(this).show();
				} else {
					$(this).hide();
				}
			});
		});
	};

	var filter_year = function () {
		$('.dropdown-year').on('click', 'a', function(event){
			event.preventDefault();
			var year = $(this).data('year');
			var type = $(this).attr('rel');
			var $search_container = $('.search-container__'+type+' .content-item');
			var $search_input = $('input[name="search-dropdown-ano-'+type+'"]');



			if (year === 'all') {
				$search_input.val('');
			} else {
				$search_input.val(year);
			}

			$search_container.each(function() {
				if ($(this).hasClass('ano-'+year) || year === 'all') {
					$(this).show();
				} else {
					$(this).hide();
				}
			});
		});
	};

	var filter_historico__tipo = function () {
		$('.dropdown-tipo-historico').on('click', 'a', function(event){
			event.preventDefault();
			var filter 	= $(this).data('rel');
			var text 	= $(this).text();
			var type 	= $(this).data('type');
			var $search_container = $('.search-container__'+type+' .content-item');
			var $search_input = $('input[name="search-dropdown-tipo-'+type+'"]');

			if (filter === 'all') {
				$search_input.val('');
			} else {
				$search_input.val(text);
			}

			$search_container.each(function() {
				if ($(this).hasClass(filter) || filter === 'all') {
					$(this).show();
				} else {
					$(this).hide();
				}
			});
		});
	};



	var accordion_action = function() {
		$('.accordion-element').on('click', '.header-accordion', function(){
			$('.content-accordion').not($(this).closest('.accordion-element').find('.content-accordion')).slideUp();
			$('.accordion-element').not($(this).closest('.accordion-element')).removeClass('open');
			$(this).closest('.accordion-element').find('.content-accordion').toggleClass('open').slideToggle('slow');
			$(this).closest('.accordion-element').toggleClass('open');
		});
	};

	var ajax_action = function($this, data_serialize){
			var type, titulo, texto = [];
			$.ajax({
				type: 'POST',
				url: ajax_object.url,
				data: data_serialize,
				dataType: "json",
				beforeSend: function() {
					$this.addClass('loading');
				},
				error: function(jqXHR, textStatus, errorThrown ) {
					type = 'error';
					titulo = 'Erro!';
					texto = textStatus;
				},
				success: function(result){
					if(result.sucess !== undefined) {
						type = 'success';
						titulo = 'Sucesso';
						texto = result.sucess.msg;
						$.fancybox.close();
					}else if (result.error !== undefined){
						type = 'error';
						titulo = 'Ops!';
						texto = result.error;
					} else {

					}
				},
				complete: function(jqXHR, textStatus ) {
					$this.removeClass('loading');
					$.toast({
						icon: type,
						heading: titulo,
						text: texto,
						hideAfter : false
					});
				}
			});
	};

	intra.init = function() {
		add_projeto();
		open_modal();
		accordion_action();
		search_container();
		filter_cadastro();
		filter_year();
		filter_historico__tipo();
		gen_download();
	};
	return intra;
}(jQuery, window, document));

INTRANET.init();
