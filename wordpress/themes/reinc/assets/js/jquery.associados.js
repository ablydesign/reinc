var ASSOCIADOS = (function ($, window, document, undefined) {
	'use strict';
	var associados = {} || ASSOCIADOS;
	var mapaAss;
	var controllMapa;
	var markers = [];
	var infor_windows;
	var infor_address_controll = [];
	var infor_address = [];
	var infor_content = [];
	var filter = [];
	var result = [];
	var associates = 'Incubadoras';
	var toggle_all = false;
	var url_associates = 'https://www.reinc.org.br/wp-json/reinc-api/v1/associados';
	var template_url;
	var type_content = function() {
		$('[name="imagem"]').on('click', function(event){
			event.stopPropagation();
			$('#associates_result_stage').fadeIn();
			$('.filter-empresas').fadeIn();
			$('#mapa-container').fadeOut();
			$('#mapa-associados').html('');
			$('[name="mapa"]').fadeIn();
			$(this).fadeOut();
			clear_map();
			controllMapa = false;
			$('.requestAssociate').each(
				function() {
				 	$(this).removeClass('filterMap');
				}
			);
		});
		$('[name="mapa"]').on('click', function(event){
			event.stopPropagation();
			$('#associates_result_stage').fadeOut();
			$('.filter-empresas').fadeOut();
			$('#mapa-container').fadeIn();
			$('[name="imagem"]').fadeIn();
			$(this).fadeOut();
			clear_map();
			associados.initMap();
			associados.load_associados();
			controllMapa = true;
			$('.requestAssociate').each(
				function() {
				 	$(this).addClass('filterMap');
				}
			);
		});
	},
	content_infoWindow = function(infor, type) {
		var html = '';
		if (type === 'default') {
			html += '<div class="content-inforwindow content-inforwindow-default">';
				html += '<div class="mCustomScrollbar" data-mcs-theme="dark">';
					html += '<img src="'+infor.logo.thumbnail+'" style="width: 40%; height: auto; float: left;">';
					html += '<h4>'+infor.title+'</h4>';
					html += '<p class="text">'+infor.end+'</p>';
					html += '<p class="link"><a class="bt-link btn-'+infor.type+'" href="'+infor.link+'">Saiba Mais</a></p>';
				html += '</div>';
			html += '</div>';
		} else {
			html += '<div class="content-inforwindow content-inforwindow-scroll">';
				html += '<div class="mCustomScrollbar" data-mcs-theme="dark">';
					html += '<h3>Endereço:</h3>';
					html += '<p class="text">'+infor_address[infor]+'</p>';
					html += '<h3>Empresas:</h3>';
					html += '<div class="content-list">';
						html += infor_content[infor];
					html += '</div>';
				html += '</div>';
			html += '</div>';
		}
		return html;
	},
	set_line = function(infor, html) {
		html += '<p class="link">';
			html += infor.title;
			html += '<a class="bt-link btn-'+infor.type+'" href="'+infor.link+'">Saiba Mais</a>';
		html += '</p>';
		return html;
	},
	loadCascade = function ($seletor_element){
	   $seletor_element.each(function(i, element){
		   setTimeout(function(){
			   $(this).fadeIn();
			   $(this).removeClass("load");
			   $(element).removeClass("load");
		   }, i * 250);
	   });
   },
	filter_map = function () {
		if (controllMapa === true) {
			$('.filterMap').on('click', function(event){
				console.log("map active");
			});
		} else {
			console.log('map not active');
		}
	},
	set_markers = function(infor, controller, image) {
		var options = {};
		var marker = null;
		if (associates === 'Empresas') {
			options = {
				map: mapaAss,
				position: infor.position,
				animation: google.maps.Animation.DROP,
				title: infor.title,
				icon: image,
				rel: infor.rel
			}
				marker = (new google.maps.Marker(options));
				markers[controller] = marker;
				google.maps.event.addListener(marker, 'click', function () {
					if (this.html !== undefined) {
						infor_windows.setContent(this.html);
					} else {
						var inner_content = content_infoWindow(this.rel, 'inline');
						infor_windows.setContent(inner_content);
						setTimeout(function(){
							$('.mCustomScrollbar').mCustomScrollbar({
								theme:"minimal"
							});
						}, 500);
					}
					infor_windows.open(mapaAss, this);
				});
		} else {
			var content = content_infoWindow(infor, 'default');
			options = {
				map: mapaAss,
				position: infor.position,
				animation: google.maps.Animation.DROP,
				title: infor.title,
				icon: image,
				html: content
			}
			window.setTimeout(function () {
				marker = (new google.maps.Marker(options));
				markers[controller] = marker;
				google.maps.event.addListener(marker, 'click', function () {
					if (this.html !== undefined) {
						infor_windows.setContent(this.html);
					} else {
						var inner_content = content_infoWindow(this.rel, 'inline');
						infor_windows.setContent(inner_content);
						setTimeout(function(){
							$('.mCustomScrollbar').mCustomScrollbar({
								theme:"minimal"
							});
						}, 500);
					}
					infor_windows.open(mapaAss, this);
				});
			}, (controller*100));
		}

	},
	clear_map = function () {
		for (var i = 0; i < markers.length; i++) {
			if (typeof markers[i] !== 'undefined' ) {
				markers[i].setMap(null);
			}
		}
		markers = [];
		infor_address_controll = [];
		infor_address = [];
		infor_content = [];
	},
	on_click_filter = function() {
		var $target = $('#associates_result_stage');
		var result_html = '';
		$('.accordion-content__list_item').on('click', 'a', function(event) {
			event.preventDefault();
			var current_type = $(this).data('type');
			var current_associates = $(this).data('associate');


			if (current_associates != associates) {
				filter = [];
				associates = current_associates;
			}
			if (current_type === 'all') {
				filter = [];
				$(this).parent('li').parent('ul').find('li > a').removeClass('active');
				$('[data-type="all"]').addClass('active');
				toggle_all = false;
			} else {
				toggle_all = true;
				console.log("Remove");
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
	empresas_filter= function(){
		$('.dropdown-content__list').mCustomScrollbar({
			theme:"minimal"
		});

		$('.checkbox-container').on('change','input[type="radio"]', function() {
			var tipo = ($(this).val());
			$('.menu-tipo-child').removeClass('visible');
			$('.menu-tipo-' + tipo).addClass('visible');
			console.log(tipo);
			$('.associate_item').each(function(i, val) {
				if ($(this).data('type') !== tipo) {
					$(this).fadeOut();
				} else {
					$(this).fadeIn();
				}
			});
		});

		$('.dropdown-content__list_item').on('click','a', function() {
			var rel 	= $(this).data('type');
			var text 	= $(this).text();
			var filter 	= $(this).data('filter_child');

			$('[name="filter-'+rel+'"]').val(text);
			$('.associate_item').each(function(i, val) {
				if ($(this).data('type_rel') !== filter && filter !== 'all') {
					$(this).fadeOut();
				} else {
					$(this).fadeIn();
				}
			});
		});

	},
	get_json_associates = function(posts_per_page, paged) {
		posts_per_page = typeof posts_per_page !== 'undefined' ?  posts_per_page : -1;
		paged = typeof paged !== 'undefined' ?  paged : 1;

		var html_out = '';
		var post = '';
		var xhr = '';
		$('.associate_loading').fadeIn();

		$.getJSON(
			url_associates,
			{
				"types": associates,
				"filter": {
					"terms": filter,
					"posts_per_page": posts_per_page
				}
			}
		).done(function(data){
			if (data.posts !== null){
				post = data.posts;

				for (var i = 0; i < post.length; i++) {
					if (post[i].relation_type !== null && post[i].type === 'empresas') {
						html_out += "<div class=\"associate_item load col-xs-3 col-sm-3 col-md-3\" data-type=\""+post[i].relation_type_slug+"\" data-type_rel=\""+post[i].relation_title_slug+"\">";
					} else {
						html_out += "<div class=\"associate_item load col-xs-3 col-sm-3 col-md-3\">";
					}
						html_out += "<div class=\"item-container "+post[i].type +" \">";
							html_out += "<a class=\"link\" href=\""+post[i].link+"\">";
								if(post[i].logotipo.thumbnail){
									html_out += "<img src=\""+post[i].logotipo.thumbnail+"\" alt=\""+post[i].title+"\">";
								} else {
									html_out += "<img src=\"http://www.reinc.org.br/wp-content/themes/reinc/assets/img/thumb-default-150.png\"  alt=\""+post.title+"\">"; 							}
								html_out += "<h3 class=\"h3\">"+post[i].title+"</h3>";
								if (post[i].relation_type !== null && post[i].type === 'empresas') {
									html_out += "<span class=\"type\">"+post[i].relation_type+"</span>";
								}
							html_out += "</a>";
						html_out += "</div>";
					html_out += "</div>";
				}

				result.json = post;
				result.html = html_out;

				$('#associates_result_stage').html('');
				$('.associate_loading').fadeOut();
				$('#associates_result_stage').append(html_out);

				setTimeout(function(){
					clear_map();
					$('#associates_result_stage').fadeIn();
					$('[name="imagem"]').fadeOut();
					$('#mapa-container').fadeOut();
					$('[name="mapa"]').fadeIn();
					loadCascade($('#associates_result_stage > div'));
				}, 500);

			} else {
				var out;
				out += '<div class="associate_loading">';
					out += '<button class="btn btn-lg" disabled>Nenhum resultado encontrado</button>';
				out += '</div>';
				$('#associates_result_stage').html('');
				$('.associate_loading').fadeOut();
				$('#associates_result_stage').append(out);
			}
		});

		if (toggle_all === false) {
			$('[data-associate="'+associates+'"][data-type="all"]').addClass('active');
		}

	};
	associados.load_associados = function () {
		var result_posts = result.json;
		var current = [];
		var image;
		switch (associates) {
			case 'Incubadoras':
				image = template_url + '/assets/img/icones/marker-incubadora.png';
			break;
			case 'Parques':
				image = template_url + '/assets/img/icones/marker-parque-tecnologico.png';
			break;
			case 'Empresas':
				image = template_url + '/assets/img/icones/marker-empresa.png';
			break;
		}
		var controll_empresa = 0;
		var count = 0;
		for (var controller = 0; controller < result_posts.length; controller++) {
			if (!(result_posts[controller].geolocation === '' || result_posts[controller].geolocation === undefined || result_posts[controller].geolocation == null)) {
				current.lat = parseFloat(result_posts[controller].geolocation.lat);
				current.lng = parseFloat(result_posts[controller].geolocation.lng);
				current.end = result_posts[controller].geolocation.address;
				current.type = associates;
				current.title = result_posts[controller].title;
				current.link = result_posts[controller].link;
				current.logo = result_posts[controller].logotipo;
				current.position = {lat: current.lat, lng: current.lng};
				if (associates === 'Empresas') {
					var addres_position = '[lat:'+current.lat.toFixed(7)+'||lng:'+current.lng.toFixed(7)+']';
					var content = '';
					var html 	= '';
					var index_of = infor_address_controll.indexOf(addres_position);
					if (index_of === -1) {
						var key = (infor_address_controll.length === 0) ? 0 : infor_address_controll.length;
						current.rel = key;
						++controll_empresa;
						infor_content[key] = set_line(current, html);
						infor_address[key] = current.end;
						infor_address_controll[key] = addres_position;
						set_markers(current, controll_empresa, image);
					} else {
					 	html = infor_content[index_of];
					 	infor_content[index_of] = set_line(current, html);
					}

				} else {
					set_markers(current, controller, image);
				}
			}
		}
	};
	associados.initMap = function () {
		mapaAss = null;
		mapaAss = new google.maps.Map(document.getElementById('mapa-associados'), {
			center: {lat: -22.9068467, lng: -43.1728965},
			scrollwheel: false,
			streetViewControl: false,
			zoomControlOptions: {
        		position: google.maps.ControlPosition.RIGHT_TOP
    		},
			zoom: 8
		});
		infor_windows = new google.maps.InfoWindow ({
			content: "segurando ..."
		});
	};
	associados.init = function(){
		console.log("[ASSOCIADOS] : Init");

		template_url = $("body").data("theme");

		$(".accordion-container").accordion({
			collapsible: false,
			heightStyle: "content",
			activate: function( event, ui ) {
				var $old_panel = $(ui.oldPanel[0]);
				var $new_panel = $(ui.newPanel[0]);
				$old_panel.find('.accordion-content__list > li > a').removeClass('active');
				$new_panel.find('.accordion-content__list > li > a[data-type="all"]').addClass('active');
				associates = $new_panel.find('.accordion-content__list > li > a[data-type="all"]').attr('data-associate');
				if (associates === 'Empresas') {
					$('.checkbox-container').find('input[type="radio"]').prop('checked', false);
					$('.filter-empresas').fadeIn();
				} else {
					$('.filter-empresas').fadeOut();
				}
				get_json_associates();
			}
		});
		empresas_filter();
		type_content();
		filter_map();
		on_click_filter();
		get_json_associates();
	};
	return associados;
}(jQuery, window, document));

ASSOCIADOS.init();
