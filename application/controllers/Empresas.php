<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Empresas extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('empresas_model');
        $this->load->library('excel');
        $this->load->library('pagination');
        $this->load->helper('download');    
        $user = $this->session->userdata('_USER_APP_');  
        if($user['is_logued_in'] != 1){
            redirect('./auth', 'location');
        } 
    }

    public function index(){

        if(!have_permission('Empresas-List')){            
            redirect('./Dashboard', 'location');           
        }

        $data['controller'] = base_url().$this->uri->segment(1);
        $data['title'] = 'Empresas'; 
        $data['sub_title'] = 'Lista de Empresas'; 
        $data['custom'] = 'empresas'; 
        $data['content'] = 'empresas/empresas_view';
        $this->load->view('templates/common/Layout_view',$data);
    }

    public function cambiar_estatus(){
        $res = $this->empresas_model->cambiar_estatus($this->input->post());
        $res = $this->empresas_model->get_empresa($this->input->post());
        exit(json_encode($res));
    }

    public function get_empresas($pagina = 0, $nombre = '', $apellido = '', $email = '', $perfil_id = ''){

        $limit = 25;

        if($pagina != 0){
          $pagina = ($pagina-1) * $limit;
        }
  
        $total_empresas = $this->empresas_model->select_count();
        $empresas = $this->empresas_model->select_all($limit, $pagina);

        $config['base_url'] = base_url().'index.php/empresas/get_empresas';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_empresas;
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
        $data['result'] = $empresas;
        $data['row'] = $pagina;

        exit(json_encode($data));

    }

    public function form_view(){
        $_POST['empresa_id'] = $this->uri->segment(3);

        $data['controller'] = base_url().$this->uri->segment(1);

        $res = $this->empresas_model->get_empresa($this->input->post());

        if(!empty($res)){
            if(!have_permission('Empresas-Edit')){            
                redirect('./Dashboard', 'location');           
            }
            $data['button'] = 'Actualizar';
            $data['data'] = $res[0];
        }else{
            if(!have_permission('Empresas-Add')){            
                redirect('./Dashboard', 'location');           
            }
            $data['button'] = 'Agregar';
            $data['data'] = array(
                'empresa_id'      => 0,
                'razon_social'    => '',
                'direccion'       => '',
                'telefono'        => '',
                'telefono'        => '',
                'activo'          => '',
            );
        }

        $data['title'] = 'Empresas'; 
        $data['sub_title'] = 'Formulario de Empresas'; 
        $data['custom'] = 'empresas'; 
        $data['content'] = 'empresas/form_view';
        $this->load->view('templates/common/Layout_view',$data);
    }

    public function validar_form(){

        $response = array();

        if(!$this->input->post()){
            $response['estatus'] = "ERROR";
            $response['message'] = "No tiene permiso para entrar.";
            exit(json_encode($response));
        }

        $this->form_validation->set_rules('razon_social', 'Razón social', 'required|trim'); 
        $this->form_validation->set_rules('telefono', 'Teléfono', 'required|trim');          
        $this->form_validation->set_rules('direccion', 'Dirección', 'required|trim');

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

    public function form_empresa(){

        $session_usuario = $this->session->userdata('_USER_APP_');

        if($this->input->post('empresa_id') > 0){
            $_POST['modificado_por'] = $session_usuario['usuario_id'];
            $_POST['fecha_modificacion'] = date('y-m-d H:i:s');
            $res = $this->empresas_model->update_empresa($this->input->post());
        }else{
            $_POST['creado_por'] = $session_usuario['usuario_id'];
            $res = $this->empresas_model->add_empresa($this->input->post());
        }

        exit(json_encode($res));
    }

    public function reporte_excel(){
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Reporte empresas');

        //Le aplicamos ancho las columnas.
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(50);

        //Definimos los títulos de la cabecera.
        $this->excel->getActiveSheet()->setCellValue("A1", 'Razón social');
        $this->excel->getActiveSheet()->setCellValue("B1", 'Dirección');
        $this->excel->getActiveSheet()->setCellValue("C1", 'Teléfono');

        // Definimos el background de la cabezera y el color de las letras
        $this->excel->getActiveSheet()
        ->getStyle('A1:C1')
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

        $list = $this->empresas_model->select_list();

        $i = 2;
        $i_abc = 0;
        $abc = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

        foreach ($list as $l) {
            $i_abc=0;
            $ii_abc = 0;

            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['razon_social']);
            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['direccion']);
            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['telefono']);

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

    public function validar_form_categoria(){

        $response = array();

        if(!$this->input->post()){
            $response['estatus'] = "ERROR";
            $response['message'] = "No tiene permiso para entrar.";
            exit(json_encode($response));
        }

        $this->form_validation->set_rules('clave', 'Clave', 'required|trim'); 
        $this->form_validation->set_rules('categoria', 'Categoría', 'required|trim'); 
        $this->form_validation->set_rules('modulo', 'Módulo(s)', 'required|trim|numeric');          

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

    public function form_categoria(){

        $session_usuario = $this->session->userdata('_USER_APP_');

        if($this->input->post('categoria_modulo_id') > 0){
            $_POST['modificado_por'] = $session_usuario['usuario_id'];
            $_POST['fecha_modificacion'] = date('y-m-d H:i:s');
            $res = $this->empresas_model->update_categoria($this->input->post());
        }else{
            $_POST['creado_por'] = $session_usuario['usuario_id'];
            $res = $this->empresas_model->add_categoria($this->input->post());
        }
        exit(json_encode($res));
    }
}

