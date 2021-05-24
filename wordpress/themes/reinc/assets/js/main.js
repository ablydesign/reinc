jQuery(document).ready(function ($) {
    $(function () {
        /* --------------------------------------------
         Accordion
         -------------------------------------------- */
         console.log("Accordion");
        $( "#accordion" ).accordion({
        	heightStyle: "content",
        	collapsible: true,
        	active: false
        });
    });
    /* --------------------------------------------
     Tab
     -------------------------------------------- */
    $(function() {
        $( "#tabs" ).tabs();
    });
    /* --------------------------------------------
     Scroll Button
     -------------------------------------------- */
    $(function() {
        $(window).scroll(function(){
            ( $(this).scrollTop() > 300 ) ? $('.cd-top').addClass('cd-is-visible') : $('.cd-top').removeClass('cd-is-visible cd-fade-out');
            if( $(this).scrollTop() > 300 ) {
                $('.cd-top').addClass('cd-fade-out');
            }
        });

        //smooth scroll to top
        $('.cd-top').on('click', function(event){
            event.preventDefault();
            $('body,html').animate({
                scrollTop: 0 ,
                }, 800);
        });
    });

    /* --------------------------------------------
     Fancybox
     -------------------------------------------- */
    $(function() {
       $(".fancybox").fancybox({
            tpl: {
                closeBtn : '<a title="fechar" class="fancybox-item fancybox-close" href="javascript:;"><span class="dashicons dashicons-no-alt"></span></a>',
                next : '<a class="fancybox-nav fancybox-next" href="javascript:;"><span class="dashicons dashicons-arrow-right-alt2"></span></a>',
                prev : '<a class="fancybox-nav fancybox-prev" href="javascript:;"><span class="dashicons dashicons-arrow-left-alt2"></span></a>'
            }
       });
    });
    /* --------------------------------------------
     Slide Home
     -------------------------------------------- */
    $(function(){
        $('.owl-carousel').owlCarousel({
             autoplay:true,
            autoplayTimeout:4000,
            autoplayHoverPause:true,
            loop:true,
            margin:0,
            nav:true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:4
                }
            }
        })
    });
	/*jQuery("[data-toggle=tooltip]").tooltip();*/
    $(function(){
        $("#mapaReINC").mapster({
        	fillOpacity: 1,
        	render_highlight: {
        		fillColor: 'CE2B2B',
        		stroke: true,
        	},
        	render_select: {
        		fillColor: 'CE2B2B',
        		stroke: true,
        	},
        	fadeInterval: 50,
        	mapKey: 'data-zona',
        	showToolTip: true,
        	toolTipContainer: "<div class=\"tooltip in top reinc-tooltip\"><div class=\"tooltip-arrow\"></div> </div> </dteniv>",/* */

        	areas:  [{
        		   key: "norte",
        		   toolTip: "Regi&atilde;o norte"
        		},
        		{
        		   key: "medioparaiba",
        		   toolTip: "Regi&atilde;o M&eacute;dio Para&iacute;ba"
        		},
        		{
        		   key: "serrana",
        		   toolTip: "Regi&atilde;o Serrana"
        		},
        		{
        			key: "metropolitana",
        			toolTip: "Regi&atilde;o Metropolitana"
        		}

        	]
        });
        console.log("Mapa");
    });
});
