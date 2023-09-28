<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	
    public function __construct(){
        parent::__construct();
        $this->load->model('dashboard_model');
        $this->load->library('excel'); 
        $this->load->library('pagination');
        $this->load->helper('download');
        $user = $this->session->userdata('_USER_APP_');  
        if($user['is_logued_in'] != 1){
            redirect('./auth', 'location');
        }
    }

	public function index(){
        $data['controller'] = base_url().$this->uri->segment(1);
        $data['title'] = 'Participantes'; 
        $data['sub_title'] = 'Participantes'; 
		$data['custom'] = 'dashboard'; 
        $data['content'] = 'dashboard/dashboard_view';
        $this->load->view('templates/common/Layout_view',$data);
	}

    public function get_participantes($pagina = 0, $nombre = ''){

        $limit = 500;

        if($pagina != 0){
          $pagina = ($pagina-1) * $limit;
        }

        $total_dashboard = $this->dashboard_model->select_count();
        $dashboard = $this->dashboard_model->select_all($limit, $pagina);

        $config['base_url'] = base_url().'index.php/dashboard/get_dashboard';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_dashboard;
        $config['per_page'] = $limit;

        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';

        $this->pagination->initialize($config);

        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $dashboard;
        $data['row'] = $pagina;

        exit(json_encode($data));
    }

    public function reporte_excel(){
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Reporte participantes');

        //Le aplicamos ancho las columnas.
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
        //Definimos los títulos de la cabecera.
        $this->excel->getActiveSheet()->setCellValue("A1", 'Nombre completo');
        $this->excel->getActiveSheet()->setCellValue("B1", 'Correo electrónico');
        $this->excel->getActiveSheet()->setCellValue("C1", 'Whatsapp');
        $this->excel->getActiveSheet()->setCellValue("D1", 'Universidad');
        $this->excel->getActiveSheet()->setCellValue("E1", 'Carrera');
        $this->excel->getActiveSheet()->setCellValue("F1", 'Área de interes');
        $this->excel->getActiveSheet()->setCellValue("G1", 'Tipo');
        // Definimos el background de la cabezera y el color de las letras
        $this->excel->getActiveSheet()
        ->getStyle('A1:G1')
        ->applyFromArray(
            array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '01308f')
                ),
                'font'  => array(
                    'bold'  => false,
                    'color' => array('rgb' => 'ffffff'),
                    'name'  => 'Verdana'
                )
            )
        );


        $list = $this->dashboard_model->select_list();

        $i = 2;
        $i_abc = 0;
        $abc = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

        foreach ($list as $l) {
            $i_abc=0;
            $ii_abc = 0;

            if($l['tipo'] == 1){
                $l['tipo'] = 'Presencial';
            }else if($l['tipo'] == 2){
                $l['tipo'] = 'En línea';
            }else{
                $l['tipo'] == 'S/D';
            }

            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['nombre']);
            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['correo_electronico']);
            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['telefono']);
            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['universidad']);
            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['carrera']);
            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['area_interes']);
            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['tipo']);

            $i++;
        }

        //Le ponemos un nombre al archivo que se va a generar.
        $archivo = "Reporte.xlsx";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
    }

    public function enviar_correo(){
        $list = $this->dashboard_model->select_list();
        print_r($list[0]['nombre']);
        print_r($list[0]['telefono']);
        print_r($list[0]['universidad']);
        print_r($list[0]['carrera']);
        print_r($list[0]['area_interes']);

       //Cargamos la librería email
       $this->load->library('email');
        
       //Indicamos el protocolo a utilizar
        $config['protocol'] = 'smtp';
         
       //El servidor de correo que utilizaremos
        $config["smtp_host"] = 'mail.sysdqm.com';
         
       //Nuestro usuario
        $config["smtp_user"] = 'notificaciones@sysdqm.com';
         
       //Nuestra contraseña
        $config["smtp_pass"] = 'Dqm#1tmZ';   
         
       //El puerto que utilizará el servidor smtp
        $config["smtp_port"] = '465';
        
       //El juego de caracteres a utilizar
        $config['charset'] = 'utf-8';
 
       //Permitimos que se puedan cortar palabras
        $config['wordwrap'] = TRUE;
         
       //El email debe ser valido 
       $config['validate'] = true;
       
        $this->email->initialize($config);
 
      //Ponemos la dirección de correo que enviará el email y un nombre
        $this->email->from('gfro04@gmail.com', 'Gerardo Rodriguez');
         
        // $this->email->to('correo@gmail.com', 'Víctor Robles');
         
      //Definimos el asunto del mensaje
        $this->email->subject($this->input->post("asunto"));
         
      //Definimos el mensaje a enviar
        $this->email->message(
            "Email: ".$this->input->post("email").
            " Mensaje: ".$this->input->post("mensaje")
        );
         
        //Enviamos el email y si se produce bien o mal que avise con una flasdata
        if($this->email->send()){
            $mensaje = 'Email enviado correctamente';
        }else{
            $mensaje = 'No se a enviado el email';
        }

        exit;
    }

}
