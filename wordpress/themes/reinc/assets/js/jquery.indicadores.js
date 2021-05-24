var INDICADORES = (function ($, window, document, undefined) {
	'use strict';
	var ind = {} || INDICADORES;

	var table_split = function ($table, chunkSize, container) {
        var cols = $("th", $table).length - 1;
        var n = cols / chunkSize;
        console.log('column:' + cols);

        console.log(n);
        if (n > 0){
            for (var i = 1; i <= n; i++) {
               var $newTable = $table.clone().appendTo(container);
               for (var j = cols + 1; j > 1; j--) {
                   if (j + chunkSize - 1 <= chunkSize * i || j > chunkSize * i + 1) {
                       $('td:nth-child(' + j + '),th:nth-child(' + j + ')', $newTable).remove();
                   }
               }
            }
            $table.fadeOut();
        }
    };

    var sortable = function() {
        console.log('sortable');
            $('table').DataTable( {
                "paging":   false,
                "info":     false,
                "searching": false,
                "order": [[ 0, 'asc' ]]
            });
    };

    var hover_select = function() {
        $('table').find('td').hover(
            function(){
                var row = $(this).attr('data-row');
                var column = $(this).attr('data-column');
                var table = $(this).closest('table');

                if (row !== undefined) {
                    $(this).closest('table').find('[data-row="'+row+'"]').addClass( "active" );
                }
                if (column !== undefined) {
                    $(this).closest('table').find('[data-column="'+column+'"]').addClass( "active" );
                }
                $(this).addClass('hover');
            },
            function() {
                var row = $(this).attr('data-row');
                var column = $(this).attr('data-column');
                if (row !== undefined) {
                    $(this).closest('table').find('[data-row="'+row+'"]').removeClass( "active" );
                }
                if (column !== undefined) {
                    $(this).closest('table').find('[data-column="'+column+'"]').removeClass( "active" );
                }
                $(this).removeClass('hover');
            }
        );
    };

	ind.init = function() {
        // table_split($("#incubadora-tipo_empresa > table"), 5, '#incubadora-tipo_empresa');
        // table_split($("#parques-tipo_empresa > table"), 5, '#parques-tipo_empresa');
        // table_split($("#programa-tipo_empresa > table"), 5, '#programa-tipo_empresa');
        // table_split($("#empresa_incubadora-tipo_empresa > table"), 5, '#empresa_incubadora-tipo_empresa');
        // table_split($("#empresa_parque-tipo_empresa > table"), 5, '#empresa_parque-tipo_empresa');
        // table_split($("#empresa_programa-tipo_empresa > table"), 5, '#empresa_programa-tipo_empresa');
        // table_split($("#localizacao_incubadora-tipo_empresa > table"), 5, '#localizacao_incubadora-tipo_empresa');
        // table_split($("#localizacao_parque-tipo_empresa > table"), 5, '#localizacao_parque-tipo_empresa');
        // table_split($("#localizacao_programa-tipo_empresa > table"), 5, '#localizacao_programa-tipo_empresa');
        //
        hover_select();
        sortable();
	}
	return ind;
}(jQuery, window, document));

INDICADORES.init();
