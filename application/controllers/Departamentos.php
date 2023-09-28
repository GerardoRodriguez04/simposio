<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Departamentos extends MY_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('departamentos_model');
        $this->load->library('excel'); 
        $this->load->library('pagination');
        $this->load->helper('download');
        $user = $this->session->userdata('_USER_APP_');
        if($user['is_logued_in'] != 1){
            redirect('./auth', 'location');
        }
    }

	public function index(){

        if(!have_permission('Departamentos-List')){            
            redirect('./Dashboard', 'location');           
        }

        $data['perfiles'] = $this->departamentos_model->get_perfiles();
        $data['controller'] = base_url().$this->uri->segment(1);
        $data['title'] = 'Departamentos';
        $data['sub_title'] = 'Departamentos';
		$data['custom'] = 'departamentos';
        $data['content'] = 'departamentos/departamentos_view';
        $this->load->view('templates/common/Layout_view',$data);
	}

    public function cambiar_estatus(){
        $session_usuario = $this->session->userdata('_USER_APP_');
        $_POST['modificado_por'] = $session_usuario['usuario_id'];
        $_POST['fecha_modificacion'] = date('y-m-d H:i:s');

        $res = $this->departamentos_model->cambiar_estatus($this->input->post());
        $res = $this->departamentos_model->get_departamento($this->input->post());
        exit(json_encode($res));
    }

    public function cambiar_visibilidad(){ 
        $session_usuario = $this->session->userdata('_USER_APP_');
        $_POST['modificado_por'] = $session_usuario['usuario_id'];
        $_POST['fecha_modificacion'] = date('y-m-d H:i:s');

        $res = $this->departamentos_model->cambiar_visibilidad($this->input->post());
        $res = $this->departamentos_model->get_departamento($this->input->post());
        exit(json_encode($res));
    }

    public function get_departamentos($pagina = 0, $departamento = ''){

        $limit = 25;

        if($pagina != 0){
          $pagina = ($pagina-1) * $limit;
        }

        $total_departamentos = $this->departamentos_model->select_count();
        $departamentos = $this->departamentos_model->select_all($limit, $pagina);

        $config['base_url'] = base_url().'index.php/departamentos/get_departamentos';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_departamentos;
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
        $data['result'] = $departamentos;
        $data['row'] = $pagina;

        exit(json_encode($data));
    }

    public function validar_form(){

        $response = array();

        if(!$this->input->post()){
            $response['estatus'] = "ERROR";
            $response['message'] = "No tiene permiso para entrar.";
            exit(json_encode($response));
        }

        $this->form_validation->set_rules('departamento', 'Departamento', 'required|trim'); 

        // -- Mensajes de Error
        $this->form_validation->set_message('required','El campo<strong> %s </strong>es obligatorio');
        $this->form_validation->set_message('is_unique', 'El<strong> %s </strong>ya está registrado.');
        $this->form_validation->set_message('numeric','El campo<strong> %s </strong>solo acepta números');
        $this->form_validation->set_message('min_length','El campo<strong> %s </strong> acepta mínimo %s carácteres');
        $this->form_validation->set_message('max_length','El campo<strong> %s </strong> acepta máximo %s carácteres');
        $this->form_validation->set_message('valid_email','El campo<strong> %s </strong>no tiene un formato valido');
        $this->form_validation->set_message('matches','Las <strong>Contraseñas</strong> no coinciden');

        if($this->form_validation->run() == false){ 
            $response['estatus'] = "ERROR";
            $response['message'] = validation_errors();
        } else{
            $response['estatus'] = "OK";
            $response['message'] = "Validación Exitosa.";
        }

        exit(json_encode($response));
    }

    public function form_departamento(){

        $session_usuario = $this->session->userdata('_USER_APP_');

        if($this->input->post('departamento_id') > 0){
            $_POST['modificado_por'] = $session_usuario['usuario_id'];
            $_POST['fecha_modificacion'] = date('y-m-d H:i:s');
            $res = $this->departamentos_model->update_departamento($this->input->post());
        }else{
            $_POST['creado_por'] = $session_usuario['usuario_id'];
            $res = $this->departamentos_model->add_departamento($this->input->post());
        }
        exit(json_encode($res));
    }

    public function descargar_excel_servicios(){
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Formato de Servicios');
        //Contador de filas
        $contador = 1;
        //Le aplicamos ancho las columnas.
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        //Definimos los títulos de la cabecera.
        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Servicio');
        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Descripción');
        // Definimos el background de la cabezera y el color de las letras
        $this->excel->getActiveSheet()
        ->getStyle('A1:B1')
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

        //Le ponemos un nombre al archivo que se va a generar.
        $archivo = "Excel_Cargar_Servicios.xlsx";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
    }

    public function validar_servicios_excel(){
        $session_usuario = $this->session->userdata('_USER_APP_');

        $file = $_FILES['archivo_excel']['tmp_name'];
        $data = array();

        $file_excel = PHPExcel_IOFactory::identify($file);
        $file_reader = PHPExcel_IOFactory::createReader($file_excel);
        $objPHPExcel = $file_reader->load($file);
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow(); 
        $highestColumn = $sheet->getHighestColumn();
        $i = 0;
        for ($row = 2; $row <= $highestRow; $row++){
            $data[$i]['servicio_id'] = 0;
            $data[$i]['servicio'] = $sheet->getCell("A".$row)->getValue();
            $data[$i]['descripcion'] = $sheet->getCell("B".$row)->getValue();
            $data[$i]['creado_por'] = $session_usuario['usuario_id'];
            $data[$i]['total'] = $highestRow;
            $i++;
        }

        // exit();

        exit(json_encode($data));
    }

    public function form_servicios_masivo(){

        $response = array();

        $this->form_validation->set_rules('departamento_id', 'Departamento', 'required|trim');
        $this->form_validation->set_rules('servicio', 'Servicio', 'required|trim');
        // $this->form_validation->set_rules('dia', 'Dia(s)', 'required|numeric|trim');
        // $this->form_validation->set_rules('hora', 'Hora(s)', 'required|numeric|trim');
        // $this->form_validation->set_rules('minuto', 'Minuto(s)', 'required|numeric|trim');

        // -- Mensajes de Error
        $this->form_validation->set_message('required','El campo<strong> %s </strong>es obligatorio');
        $this->form_validation->set_message('is_unique', 'El<strong> %s </strong>ya está registrado.');
        $this->form_validation->set_message('numeric','El campo<strong> %s </strong>solo acepta números');
        $this->form_validation->set_message('min_length','El campo<strong> %s </strong> acepta mínimo %s carácteres');
        $this->form_validation->set_message('max_length','El campo<strong> %s </strong> acepta máximo %s carácteres');
        $this->form_validation->set_message('valid_email','El campo<strong> %s </strong>no tiene un formato valido');
        $this->form_validation->set_message('matches','Las <strong>Contraseñas</strong> no coinciden');           

        if($this->form_validation->run() == false){ 
            $res['estatus'] = "ERROR";
            $res['message'] = validation_errors();
            exit(json_encode($res));
        }else{
            $session_usuario = $this->session->userdata('_USER_APP_');
            $_POST['creado_por'] = $session_usuario['usuario_id'];
            $res = $this->departamentos_model->add_servicio($this->input->post());
            exit(json_encode($res));
        }
    }

    public function descargar_excel_usuarios(){
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Formato de Usuarios');
        //Contador de filas
        $contador = 1;
        //Le aplicamos ancho las columnas.
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        //Definimos los títulos de la cabecera.
        $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Nombre');
        $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Apellido');
        $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Telefono');
        $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Correo');
        // Definimos el background de la cabezera y el color de las letras
        $this->excel->getActiveSheet()
        ->getStyle('A1:D1')
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

        //Le ponemos un nombre al archivo que se va a generar.
        $archivo = "Excel_Cargar_Usuarios.xlsx";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$archivo.'"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        //Hacemos una salida al navegador con el archivo Excel.
        $objWriter->save('php://output');
    }

    public function validar_usuarios_excel(){
        $session_usuario = $this->session->userdata('_USER_APP_');
        $file = $_FILES['archivo_usuarios_excel']['tmp_name'];
        $data = array();

        $file_excel = PHPExcel_IOFactory::identify($file);
        $file_reader = PHPExcel_IOFactory::createReader($file_excel);
        $objPHPExcel = $file_reader->load($file);
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow(); 
        $highestColumn = $sheet->getHighestColumn();
        $i = 0;
        for ($row = 2; $row <= $highestRow; $row++){
            $data[$i]['usuario_id'] = 0;
            $data[$i]['nombre'] = $sheet->getCell("A".$row)->getValue();
            $data[$i]['apellido'] = $sheet->getCell("B".$row)->getValue();
            $data[$i]['perfil_id'] = 2;
            $data[$i]['telefono'] = $sheet->getCell("C".$row)->getValue();
            $data[$i]['email'] = $sheet->getCell("D".$row)->getValue();
            $data[$i]['password'] = 'amgdesarrollos2021%';
            $data[$i]['confirmar_password'] = 'amgdesarrollos2021%';
            $data[$i]['created'] = $session_usuario['usuario_id'];
            $data[$i]['total'] = $highestRow;
            $i++;
        }

        // exit();

        exit(json_encode($data));
    }

    public function form_usuarios_masivo(){


        $response = array();

        $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim'); 
        $this->form_validation->set_rules('apellido', 'Apellido', 'required|trim');          
        $this->form_validation->set_rules('perfil_id', 'Perfiles', 'required|trim');
        $this->form_validation->set_rules('departamento_id', 'Departamentos', 'required|numeric|trim');
        $this->form_validation->set_rules('telefono', 'Telefono', 'required|numeric|trim');
        $this->form_validation->set_rules('password', 'password', 'required|trim');                
        $this->form_validation->set_rules('email', 'Correo Electrónico', 'trim|required|valid_email|is_unique[usuarios.email]');

        // -- Mensajes de Error
        $this->form_validation->set_message('required','El campo<strong> %s </strong>es obligatorio');
        $this->form_validation->set_message('is_unique', 'El<strong> %s </strong>ya está registrado.');
        $this->form_validation->set_message('numeric','El campo<strong> %s </strong>solo acepta números');
        $this->form_validation->set_message('min_length','El campo<strong> %s </strong> acepta mínimo %s carácteres');
        $this->form_validation->set_message('max_length','El campo<strong> %s </strong> acepta máximo %s carácteres');
        $this->form_validation->set_message('valid_email','El campo<strong> %s </strong>no tiene un formato valido');
        $this->form_validation->set_message('matches','Las <strong>Contraseñas</strong> no coinciden');           

        if($this->form_validation->run() == false){ 
            $res['estatus'] = "ERROR";
            $res['message'] = validation_errors();
            exit(json_encode($res));
        }else{
            $session_usuario = $this->session->userdata('_USER_APP_');
            $_POST['creado_por'] = $session_usuario['usuario_id'];
            $res = $this->departamentos_model->add_usuario($this->input->post());
            exit(json_encode($res));
        }
    }

    public function detalles($departamento_id){
        $_POST['departamento_id'] = $departamento_id;
        $data['departamento'] = $this->departamentos_model->get_departamento($this->input->post('departamento_id'));
        $data['servicios'] = $this->departamentos_model->get_servicios($this->input->post('departamento_id'));
        $data['usuarios'] = $this->departamentos_model->get_usuarios($this->input->post('departamento_id'));
        $data['controller'] = base_url().$this->uri->segment(1);
        $data['title'] = 'Departamentos';
        $data['sub_title'] = 'Departamentos';
        $data['custom'] = 'departamentos';
        $data['content'] = 'departamentos/detalles_view';
        $this->load->view('templates/common/Layout_view',$data);
    }

    public function eliminar_departamento(){
        $res = $this->departamentos_model->eliminar_departamento($this->input->post('departamento_id'));
        exit(json_encode($res));
    }

    public function reporte_excel(){
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Reporte Departamentos');

        //Le aplicamos ancho las columnas.
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
        //Definimos los títulos de la cabecera.
        $this->excel->getActiveSheet()->setCellValue("A1", 'Departamento');
        $this->excel->getActiveSheet()->setCellValue("B1", 'Descripción');
        // Definimos el background de la cabezera y el color de las letras
        $this->excel->getActiveSheet()
        ->getStyle('A1:B1')
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

        $_GET['departamento_id'] = $this->uri->segment(3);

        $list = $this->departamentos_model->select_list();

        $i = 2;
        $i_abc = 0;
        $abc = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

        foreach ($list as $l) {
            $i_abc=0;
            $ii_abc = 0;

            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['departamento']);
            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['descripcion']);

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
}
