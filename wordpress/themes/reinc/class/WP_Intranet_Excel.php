<?php
/**
 * Class que implementa recursos utilizados pela categoria associados
 * @author Lucas Ramos
 */
require_once 'PHPExcel.php';
class WP_Intranet_Excel{

    function __construct($argument =  null) {


    }

    public function gen_planilha_incubadora () {
     	$Incubadora_PHPExcel = new PHPExcel();
     	$Incubadora_PHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true); //1
     	$Incubadora_PHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true); //2
     	$Incubadora_PHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true); //3
     	$Incubadora_PHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true); //4
     	$Incubadora_PHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true); //5
     	$Incubadora_PHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true); //6
     	$Incubadora_PHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true); //7

     	$Incubadora_PHPExcel->setActiveSheetIndex(0)
             ->setCellValue('A1', 'LOGOTIPO' )
             ->setCellValue('B1', "NOME" )
             ->setCellValue('C1', "TIPO " )
             ->setCellValue("D1", "CONTATOS" )
             ->setCellValue("E1", "TELEFONES" )
             ->setCellValue("F1", "E-MAIL" )
             ->setCellValue("G1", "ENDEREÇO" )
             ->setCellValue("H1", "SITE" );

        foreach(range('B','H') as $columnID){
			$Incubadora_PHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		$Incubadora_PHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
		$Incubadora_PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);

        $row_controll = 2;
     	$incubadoras = new WP_Query( array('post_type' => 'incubadoras', 'posts_per_page' => -1, 'post_status' => 'publish' ) );
     	while ( $incubadoras->have_posts() ) :
    		$incubadoras->the_post();

     		$type = 'incubadoras';
     		$prefix_field =  WP_Associados::get_prefix_field($type);

     		$contatos = get_field("incubadora_contatos", get_the_ID());
     		$contatos_row = array();
			if ($contatos) :
					foreach($contatos as $item) {
						$contato_name = $item["contato_nome"];
						$contato_cargo = $item["contato_cargo"];
						if ($contato_name) {
							$contatos_row[] = $contato_cargo .': '. $contato_name;
						}
					}
			endif;

			$tipos = get_field('tipo_de_incubadora', get_the_ID());
			if ($tipos) :
				$current = array();
				foreach($tipos as $item) {
					$current[] = $item->name;
				}
				$tipos = join(' | ', $current);
			endif;

			$titulo = get_the_title(get_the_ID());
			$contatos = join(' | ', $contatos_row);
			$telefone = get_field('incubadora_telefone', get_the_ID());
			$email = get_field('incubadora_email', get_the_ID());
			$endereco = get_field('incubadora_endereco', get_the_ID());
			$site = get_field('incubadora_site', get_the_ID());

    		//LOGOTIPO
    		$path = WP_Associados::get_path_thumb($type, get_the_ID());
    		$Logotipo = new PHPExcel_Worksheet_Drawing();
    		$Logotipo->setName('Logotipo - '.$row_controll);
    		$Logotipo->setDescription('Logo - '.$row_controll);
    		$Logotipo->setPath($path);
    		$Logotipo->setHeight(100); // logo height
    		$Logotipo->setResizeProportional(true);
    		$Logotipo->setCoordinates('A'.$row_controll);
    		$Logotipo->setWorksheet($Incubadora_PHPExcel->getActiveSheet());

    		/**
    		 *
    		 */
    		//NOME
			$Incubadora_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				1,
				$row_controll,
				$titulo
			);

    		//TIPO
			$Incubadora_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				2,
				$row_controll,
				$tipos
			);

			//CONTATOS
			$Incubadora_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				3,
				$row_controll,
				$contatos
			);

			//TELEFONES
    		$Incubadora_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
    			4,
    			$row_controll,
    			$telefone
    		);

    		//E-MAIL
			$Incubadora_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				5,
				$row_controll,
				$email
			);

			//ENDEREÇO
			$Incubadora_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				6,
				$row_controll,
				$endereco
			);

			//SITE
			$Incubadora_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				7,
				$row_controll,
				$site
			);

			$Incubadora_PHPExcel->getActiveSheet()->getRowDimension($row_controll)->setRowHeight(80);
			++$row_controll;
     	endwhile;
     	wp_reset_query();
     	$Incubadora_PHPExcel->getActiveSheet()->setTitle('Credenciamento para o Evento');

		// Cabeçalho do arquivo para ele baixar
		header('Pragma: public');
		header('Content-Description: File Transfer');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="incubadoras.xls"');
		header('Cache-Control: max-age=0');
		header('Content-Transfer-Encoding: binary');

		// Acessamos o 'Writer' para poder salvar o arquivo
		$Download_Writer = PHPExcel_IOFactory::createWriter($Incubadora_PHPExcel, 'Excel5');

		// // Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
		ob_end_clean();
		$Download_Writer->save('php://output');

		exit();
    }

    public function gen_planilha_parques () {
     	$Parques_PHPExcel = new PHPExcel();
     	$Parques_PHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true); //1
     	$Parques_PHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true); //2
     	$Parques_PHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true); //3
     	$Parques_PHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true); //4
     	$Parques_PHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true); //5
     	$Parques_PHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true); //6
     	$Parques_PHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true); //7

     	$Parques_PHPExcel->setActiveSheetIndex(0)
             ->setCellValue('A1', 'LOGOTIPO' )
             ->setCellValue('B1', "NOME" )
             ->setCellValue('C1', "TIPO " )
             ->setCellValue("D1", "CONTATOS" )
             ->setCellValue("E1", "TELEFONES" )
             ->setCellValue("F1", "E-MAIL" )
             ->setCellValue("G1", "ENDEREÇO" )
             ->setCellValue("H1", "SITE" );

        foreach(range('B','H') as $columnID){
			$Parques_PHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		$Parques_PHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
		$Parques_PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);

        $row_controll = 2;
     	$parques_tecnologicos = new WP_Query( array('post_type' => 'parques_tecnologicos', 'posts_per_page' => -1, 'post_status' => 'publish' ) );
     	while ( $parques_tecnologicos->have_posts() ) :
    		$parques_tecnologicos->the_post();

     		$type = 'parques_tecnologicos';
     		$prefix_field =  WP_Associados::get_prefix_field($type);

     		$contatos = get_field("parque_tecnologico_contatos", get_the_ID());
     		$contatos_row = array();
			if ($contatos) :
					foreach($contatos as $item) {
						$contato_name = $item["contato_nome"];
						$contato_cargo = $item["contato_cargo"];
						if ($contato_name) {
							$contatos_row[] = $contato_cargo .': '. $contato_name;
						}
					}
			endif;

			$tipos = get_field('tipo_de_parque_tecnologico', get_the_ID());
			if ($tipos) :
				$current = array();
				foreach($tipos as $item) {
					$term = get_term((int)$item);
					$current[] = $term->name;
				}
				$tipos = join(' | ', $current);
			endif;

			$titulo = get_the_title(get_the_ID());
			$contatos = join(' | ', $contatos_row);
			$telefone = get_field('parque_tecnologico_telefone', get_the_ID());
			$email = get_field('parque_tecnologico_email', get_the_ID());
			$endereco = get_field('parque_tecnologico_endereco', get_the_ID());
			$site = get_field('parque_tecnologico_site', get_the_ID());

    		//LOGOTIPO
    		$path = WP_Associados::get_path_thumb($type, get_the_ID());
    		$Logotipo = new PHPExcel_Worksheet_Drawing();
    		$Logotipo->setName('Logotipo - '.$row_controll);
    		$Logotipo->setDescription('Logo - '.$row_controll);
    		$Logotipo->setPath($path);
    		$Logotipo->setHeight(100); // logo height
    		$Logotipo->setResizeProportional(true);
    		$Logotipo->setCoordinates('A'.$row_controll);
    		$Logotipo->setWorksheet($Parques_PHPExcel->getActiveSheet());

    		/**
    		 *
    		 */
    		//NOME
			$Parques_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				1,
				$row_controll,
				$titulo
			);

    		//TIPO
			$Parques_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				2,
				$row_controll,
				$tipos
			);

			//CONTATOS
			$Parques_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				3,
				$row_controll,
				$contatos
			);

			//TELEFONES
    		$Parques_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
    			4,
    			$row_controll,
    			$telefone
    		);

    		//E-MAIL
			$Parques_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				5,
				$row_controll,
				$email
			);

			//ENDEREÇO
			$Parques_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				6,
				$row_controll,
				$endereco
			);

			//SITE
			$Parques_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				7,
				$row_controll,
				$site
			);

			$Parques_PHPExcel->getActiveSheet()->getRowDimension($row_controll)->setRowHeight(80);
			++$row_controll;
     	endwhile;

     	$Parques_PHPExcel->getActiveSheet()->setTitle('Parques');

		// Cabeçalho do arquivo para ele baixar
		header('Pragma: public');
		header('Content-Description: File Transfer');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="parques_tecnologicos.xls"');
		header('Cache-Control: max-age=0');
		header('Content-Transfer-Encoding: binary');

		// Acessamos o 'Writer' para poder salvar o arquivo
		$Download_Writer = PHPExcel_IOFactory::createWriter($Parques_PHPExcel, 'Excel5');

		// // Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
		ob_end_clean();
		$Download_Writer->save('php://output');

		exit();
    }

    public function gen_planilha_empresas() {
     	$Empresas_PHPExcel = new PHPExcel();
     	$Empresas_PHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true); //1
     	$Empresas_PHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true); //2
     	$Empresas_PHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true); //3
     	$Empresas_PHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true); //4
     	$Empresas_PHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true); //5
     	$Empresas_PHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true); //6
     	$Empresas_PHPExcel->getActiveSheet()->getStyle('G1')->getFont()->setBold(true); //7
        $Empresas_PHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true); //8
        $Empresas_PHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true); //9
        $Empresas_PHPExcel->getActiveSheet()->getStyle('J1')->getFont()->setBold(true); //10
        $Empresas_PHPExcel->getActiveSheet()->getStyle('K1')->getFont()->setBold(true); //11
        $Empresas_PHPExcel->getActiveSheet()->getStyle('L1')->getFont()->setBold(true); //12
        $Empresas_PHPExcel->getActiveSheet()->getStyle('M1')->getFont()->setBold(true); //12

     	$Empresas_PHPExcel->setActiveSheetIndex(0)
             ->setCellValue('A1', 'LOGOTIPO' )
             ->setCellValue('B1', "NOME" )
             ->setCellValue('C1', "TIPO " )
             ->setCellValue('D1', "TIPO SEC " )
             ->setCellValue("E1", "CONTATOS" )
             ->setCellValue("F1", "TELEFONES" )
             ->setCellValue("G1", "E-MAIL" )
             ->setCellValue("H1", "ENDEREÇO" )
             ->setCellValue("I1", "SITE" )
             ->setCellValue("J1", "REL." )
             ->setCellValue("K1", "REL. TIPO" )
             ->setCellValue("L1", "STATUS" )
             ->setCellValue("M1", "URL LOGOTIPO" );

        foreach(range('B','L') as $columnID){
			$Empresas_PHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		}
		$Empresas_PHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(false);
		$Empresas_PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);

        $row_controll = 2;
     	$empresas = new WP_Query( array('post_type' => 'empresas', 'posts_per_page' => -1, 'post_status' => 'publish' ) );
     	while ( $empresas->have_posts() ) :
    		$empresas->the_post();

     		$type = 'empresas';
     		$prefix_field =  WP_Associados::get_prefix_field($type);

     		$contatos = get_field("empresa_contatos", get_the_ID());
     		$contatos_row = array();
			if ($contatos) :
					foreach($contatos as $item) {
						$contato_name = $item["contato_nome"];
						$contato_cargo = $item["contato_cargo"];
						if ($contato_name) {
							$contatos_row[] = $contato_cargo .': '. $contato_name;
						}
					}
			endif;

			$tipos = get_field('tipo_de_empresa', get_the_ID());
			if ($tipos) :
                $term = get_term((int)$tipos);
				$tipos = $term->name;
			endif;

            $tipos_sec = get_field('tipo_de_empresa_sec', get_the_ID());
			if ($tipos_sec) :
                $term = get_term((int)$tipos_sec);
				$tipos_sec = $term->name;
			endif;

			$titulo = get_the_title(get_the_ID());
			$contatos = join(' | ', $contatos_row);
			$telefone = get_field('empresa_telefone', get_the_ID());
			$email = get_field('empresa_email', get_the_ID());
			$endereco = get_field('empresa_endereco', get_the_ID());
			$site = get_field('empresa_site', get_the_ID());

            $status = get_field('status_da_empresa', get_the_ID());
            $status = $status->name;

            $rel = array();
            $types = array();
            if (get_field('empresa_incubadora', get_the_ID())) :
                $id = get_field('empresa_incubadora', get_the_ID());
                $rel[] = get_the_title($id[0]);
                $types[] = 'Incubadora';
            endif;
            if (get_field('empresa_parque', get_the_ID())) :
                $id = get_field('empresa_parque', get_the_ID());
                $rel[] = get_the_title($id[0]);
                $types[] = 'Parque Tecnológico';
            endif;
            $rel = join(', ', $rel);
            $types = join(', ', $types);




    		//LOGOTIPO
    		$path = WP_Associados::get_thumb_type($type, get_the_ID());
    		$Logotipo = new PHPExcel_Worksheet_Drawing();
    		$Logotipo->setName('Logotipo - '.$row_controll);
    		$Logotipo->setDescription('Logo - '.$row_controll);
    		//$Logotipo->setPath($path);
    		// $Logotipo->setHeight(100); // logo height
    		// $Logotipo->setResizeProportional(true);
    		// $Logotipo->setCoordinates('A'.$row_controll);
    		// $Logotipo->setWorksheet($Empresas_PHPExcel->getActiveSheet());

    		/**
    		 *
    		 */
    		//NOME
			$Empresas_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				1,
				$row_controll,
				$titulo
			);

    		//TIPO
			$Empresas_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				2,
				$row_controll,
				$tipos
			);

            //TIPO SEC
			$Empresas_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				3,
				$row_controll,
				$tipos_sec
			);

			//CONTATOS
			$Empresas_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				4,
				$row_controll,
				$contatos
			);

			//TELEFONES
    		$Empresas_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
    			5,
    			$row_controll,
    			$telefone
    		);

    		//E-MAIL
			$Empresas_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				6,
				$row_controll,
				$email
			);

			//ENDEREÇO
			$Empresas_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				7,
				$row_controll,
				$endereco
			);

			//SITE
			$Empresas_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				8,
				$row_controll,
				$site
			);
            //REL
			$Empresas_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				9,
				$row_controll,
				$rel
			);
            //REL TIPO
			$Empresas_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				10,
				$row_controll,
				$types
			);
            //STATUS
			$Empresas_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				11,
				$row_controll,
				$status
			);
			//URL LOGO
			$Empresas_PHPExcel->getActiveSheet()->setCellValueByColumnAndRow(
				12,
				$row_controll,
				$path
			);

			//$Empresas_PHPExcel->getActiveSheet()->getRowDimension($row_controll)->setRowHeight(80);
			++$row_controll;
     	endwhile;

     	$Empresas_PHPExcel->getActiveSheet()->setTitle('Empresas');

		// Cabeçalho do arquivo para ele baixar
		header('Pragma: public');
		header('Content-Description: File Transfer');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="empresas.xls"');
		header('Cache-Control: max-age=0');
		header('Content-Transfer-Encoding: binary');

		// Acessamos o 'Writer' para poder salvar o arquivo
		$Download_Writer = PHPExcel_IOFactory::createWriter($Empresas_PHPExcel, 'Excel5');

		// // Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
		ob_end_clean();
		$Download_Writer->save('php://output');

		exit();
    }
}
