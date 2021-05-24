function generateContentGrid(associate_type, paged, associate_category){
	
	if(typeof associate_type === 'undefined')return false;
	var postsPerPage = "<?php echo $maxPageRestAPI; ?>";
	var paged=(isNaN(paged) || paged==0)?1:paged;
	
	jQuery("#associate_loading").show();
	
	switch(associate_type){
		case 'Incubadoras':
			var wpCollections = new wp.api.collections.Incubadoras;
			var urlParamsObj = {"per_page":postsPerPage, page: paged,"filter":{taxonomy:"tipo_incubadora",term:associate_category}};
		break;
		case 'Parques':
			var wpCollections = new wp.api.collections.Parques_tecnologicos;
			var urlParamsObj = {"per_page":postsPerPage, page: paged,"filter":{taxonomy:"tipo_parques",term:associate_category}};
		break;
		case 'Empresas':
			var wpCollections = new wp.api.collections.Empresas;
			var urlParamsObj = {"per_page":postsPerPage, page: paged,"filter":{taxonomy:"tipo_empresas", term:associate_category}};
		break;
		default:
			return false;
		break;
	}
	
	wpCollections.fetch({ data: urlParamsObj}).done(function(data) {
	
	var currentPage = wpCollections.state.currentPage;
	var hasMore = wpCollections.hasMore();
		
	var nextLink = hasMore?paged+1:false; //currentPage+1
	var prevLink = paged>=1?paged-1:false; //currentPage-1
		
	if(wpCollections.size() <= 0){
	
		jQuery("#associate_results").append("<div class=\"col-xs-12 col-sm-12 col-md-12 associates_not_found\"><button class=\"btn btn-lg\" disabled><span class=\"fa fa-close\"></span> <?php echo __("Nenhum resultado encontrado."); ?></button></div>");
		jQuery(".requestMoreAssociate").hide();
		jQuery("#associate_loading").hide();
		return false;
	}
		
	wpCollections.each( function( post ) {
		if(post.attributes.logotipo_hover.thumbnail){
			var hoverContent = "<img src=\""+post.attributes.logotipo_hover.thumbnail+"\" alt=\""+post.attributes.title.rendered+"\"/>";
		}else{
			var hoverContent = "<h3 class=\"hover-title-associate\">"+post.attributes.title.rendered+"</h3>";
		}
			
		if(post.attributes.logotipo.thumbnail){
			var frontContent = "<img src=\""+post.attributes.logotipo.thumbnail+"\" alt=\""+post.attributes.title.rendered+"\"/>";
		}else{
			var frontContent = "<h3 class=\"hover-title-associate\">"+post.attributes.title.rendered+"</h3>";
		}
						
		jQuery("#associate_results").append("<div class=\"associate_item col-xs-3 col-sm-3 col-md-3\"><div class=\"flip-container\" ontouchstart=\"this.classList.toggle('hover');\"><div class=\"flipper\"><div class=\"front\"><a class=\"link\" href=\""+post.attributes.link+"\">"+frontContent+"</a></div><div class=\"back\"><a class=\"link\" href=\""+post.attributes.link+"\">"+hoverContent+"</a></div></div></div><a class=\"link\" href=\""+post.attributes.link+"\"><h3 class=\"h3\">"+post.attributes.title.rendered+"</h3></a></div>");
		});
		
		if(hasMore){
			jQuery("#associate_pagination").empty().append("<div class=\"col-xs-12 col-sm-12 col-md-12\"><button type=\"button\" class=\"btn btn-default btn-lg requestMoreAssociate\" data-associate_type=\""+associate_type+"\" data-associate_category=\""+associate_category+"\" data-paged=\""+nextLink+"\"><?php echo __("Carregar mais resultados"); ?></button></div>");
		}else{
			jQuery(".requestMoreAssociate").hide();
		}
	
		jQuery("#associate_loading").hide();
	
	});
	
}

jQuery(document).ready(function(){
	
	generateContentGrid("Incubadoras", 0, "");
	jQuery("#Incubadora-").closest("li").addClass("in");
	jQuery("#incubadoraChooseOptions").addClass("collapse-in");
	jQuery("#incubadora_subitens").addClass("collapse in");
	
	jQuery("body").on("shown.bs.collapse hidden.bs.collapse", "#empresa_subitens, #parque_subitens, #incubadora_subitens", function(){
		console.log("Show Collapse fields");
		jQuery(".collapse-in").removeClass("collapse-in");
		jQuery(this).closest(".associate_type").addClass("collapse-in");
		jQuery(".associate_type").not(".collapse-in").find(".retractileIcon i").removeClass("fa-minus-circle").addClass("fa-plus-circle");
		jQuery(".associate_type.collapse-in").find(".retractileIcon i").addClass("fa-minus-circle").removeClass("fa-plus-circle");
		jQuery(".associate_type").not(".collapse-in").find(".in").removeClass("in");
	}).on("hidden.bs.collapse", '#empresa_subitens, #parque_subitens, #incubadora_subitens', function () {
		console.log("Hide Collapse fields");
		jQuery(".collapse-in").removeClass("collapse-in");
		jQuery(".associate_type").not(".collapse-in").find(".retractileIcon i").removeClass("fa-minus-circle").addClass("fa-plus-circle");
		jQuery(this).closest(".associate_type").removeClass("collapse-in");
	});
	
	jQuery("body").on("click", ".requestMoreAssociate", function(event){
		event.preventDefault();
		
		var associate_type = jQuery(this).data('associate_type');
		var associate_category = jQuery(this).data('associate_category');
		var paged_associate = (isNaN(jQuery(this).data('paged')))?0:jQuery(this).data('paged');
		
		console.log("Requesting content for "+associate_type+". Category "+associate_category);
		
		generateContentGrid(associate_type, paged_associate, associate_category);
	});
	
	jQuery("body").on("click", ".requestAssociate", function(event){
		event.preventDefault();
		
		jQuery(".requestAssociate").closest("li").removeClass("in");
		jQuery(this).closest("li").addClass("in");
		var associate_type = jQuery(this).data('associate_type');
		var associate_category = jQuery(this).data('associate_category');
		var paged_associate = (isNaN(jQuery(this).data('paged')))?0:jQuery(this).data('paged');
		
		console.log("Requesting content for "+associate_type+". Category "+associate_category);
		
		jQuery("#associate_results").empty();
		
		generateContentGrid(associate_type, paged_associate, associate_category);
		
	});
	
});

