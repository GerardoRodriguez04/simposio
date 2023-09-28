<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuarios extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('usuarios_model');
        $this->load->library('excel');
        $this->load->library('pagination');
        $this->load->helper('download');    
        $user = $this->session->userdata('_USER_APP_');  
        if($user['is_logued_in'] != 1){
            redirect('./auth', 'location');
        }
    }

    public function index(){

        if(!have_permission('Usuarios-List')){            
            redirect('./Dashboard', 'location');           
        }

        $data['perfiles'] = $this->usuarios_model->get_perfiles();
        $data['departamentos'] = $this->usuarios_model->get_departamentos();
        $data['empresas'] = $this->usuarios_model->get_empresas();

        $data['controller'] = base_url().$this->uri->segment(1);
        $data['title'] = 'Usuarios'; 
        $data['sub_title'] = 'Lista de Usuarios'; 
        $data['custom'] = 'usuarios'; 
        $data['content'] = 'usuarios/usuarios_view';
        $this->load->view('templates/common/Layout_view',$data);
    }

    public function perfil_view(){
        $data['controller'] = base_url().$this->uri->segment(1);

        $_POST['usuario_id'] = $this->uri->segment(3);

        $data['data'] = $this->usuarios_model->get_usuario($this->input->post());
        $data['title'] = 'Usuarios'; 
        $data['sub_title'] = 'Perfil del Usuario'; 
        $data['custom'] = 'usuarios'; 
        $data['content'] = 'usuarios/perfil_view';
        $this->load->view('templates/common/Layout_view',$data);
    }

    public function cambiar_estatus(){
        $res = $this->usuarios_model->cambiar_estatus($this->input->post());
        $res = $this->usuarios_model->get_usuario($this->input->post());
        exit(json_encode($res));
    }

    public function get_usuarios($pagina = 0, $nombre = '', $apellido = '', $email = '', $perfil_id = ''){

        $limit = 25;

        if($pagina != 0){
          $pagina = ($pagina-1) * $limit;
        }
  
        $total_usuarios = $this->usuarios_model->select_count();
        $usuarios = $this->usuarios_model->select_all($limit, $pagina);

        $config['base_url'] = base_url().'index.php/usuarios/get_usuarios';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_usuarios;
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
        $data['result'] = $usuarios;
        $data['row'] = $pagina;

        exit(json_encode($data));

    }

    public function form_view(){
        $_POST['usuario_id'] = $this->uri->segment(3);

        $data['controller'] = base_url().$this->uri->segment(1);
        $data['perfiles'] = $this->usuarios_model->get_perfiles();
        $data['empresas'] = $this->usuarios_model->get_empresas();
        $data['departamentos'] = $this->usuarios_model->get_departamentos();
        $data['departamentos_usuario'] = $this->usuarios_model->get_departamentos_usuario();


        $res = $this->usuarios_model->get_usuario($this->input->post());

        if(!empty($res)){
            if(!have_permission('Usuarios-Edit')){            
                redirect('./Dashboard', 'location');           
            }
            $data['button'] = 'Actualizar';
            $data['data'] = $res[0];
        }else{
            if(!have_permission('Usuarios-Add')){            
                redirect('./Dashboard', 'location');           
            }
            $data['button'] = 'Agregar';
            $data['data'] = array(
                'usuario_id'      => 0,
                'perfil_id'       => '',
                'empresa_id'      => '',
                'departamento_id' => '',
                'nombre'          => '',
                'apellido'        => '',
                'telefono'        => '',
                'email'           => '',
                'activo'          => '',
                'perfil'          => ''
            );
        }

        $data['title'] = 'Usuarios'; 
        $data['sub_title'] = 'Formulario de Usuarios'; 
        $data['custom'] = 'usuarios'; 
        $data['content'] = 'usuarios/form_view';
        $this->load->view('templates/common/Layout_view',$data);
    }

    public function validar_form(){

        $response = array();

        if(!$this->input->post()){
            $response['estatus'] = "ERROR";
            $response['message'] = "No tiene permiso para entrar.";
            exit(json_encode($response));
        }

        $this->form_validation->set_rules('nombre', 'Nombre', 'required|trim'); 
        $this->form_validation->set_rules('apellido', 'Apellido', 'required|trim');          
        $this->form_validation->set_rules('perfil_id', 'Perfiles', 'required|trim');
        $this->form_validation->set_rules('empresa_id', 'Empresa', 'required|trim');
        $this->form_validation->set_rules('departamento_id[]', 'Departamentos', 'required|numeric|trim');
        $this->form_validation->set_rules('telefono', 'Telefono', 'required|numeric|trim');
        if ($this->input->post('usuario_id') == 0) {
            $this->form_validation->set_rules('password', 'password', 'required|trim');                
            $this->form_validation->set_rules('email', 'Correo Electrónico', 'trim|required|valid_email|is_unique[usuarios.email]');
        }else{
            $email_post = $this->input->post('email');
            $usuarios = $this->usuarios_model->get_usuario($this->input->post('usuario_id'));
            if ($usuarios[0]['email'] != $email_post) {
               $this->form_validation->set_rules('email', 'Correo Electrónico', 'trim|required|valid_email|is_unique[usuarios.email]');
            }
        }

        if (!empty($this->input->post('password'))) {
            $this->form_validation->set_rules('password', 'Contraseña', 'trim|min_length[8]');
            $this->form_validation->set_rules('confirmar_password', 'Confirmar Contraseña', 'trim|matches[password]');
        }

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

    public function form_usuario(){

        $session_usuario = $this->session->userdata('_USER_APP_');

        if($this->input->post('usuario_id') > 0){
            $_POST['modificado_por'] = $session_usuario['usuario_id'];
            $_POST['fecha_modificacion'] = date('y-m-d H:i:s');
            $res = $this->usuarios_model->update_usuario($this->input->post());
        }else{
            $_POST['creado_por'] = $session_usuario['usuario_id'];
            $res = $this->usuarios_model->add_usuario($this->input->post());
        }
        exit(json_encode($res));
    }

    public function validar_password(){

        $response = array();

        if(!$this->input->post()){
            $response['estatus'] = "ERROR";
            $response['message'] = "No tiene permiso para entrar.";
            exit(json_encode($response));
        }

        $this->form_validation->set_rules('password', 'Contraseña', 'required|trim|min_length[8]');
        $this->form_validation->set_rules('confirmar_password', 'Confirmar Contraseña', 'required|trim|matches[password]');

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

    public function update_password(){
        $session_usuario = $this->session->userdata('_USER_APP_');

        $_POST['modificado_por'] = $session_usuario['usuario_id'];
        $_POST['fecha_modificacion'] = date('y-m-d H:i:s');
        $this->usuarios_model->update_password($this->input->post());

        $response['estatus'] = "OK";    
        $response['message'] = "Actualización Exitosa.";

        exit(json_encode($response));
    }

    public function reporte_excel(){
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Reporte usuarios');

        //Le aplicamos ancho las columnas.
        $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
        //Definimos los títulos de la cabecera.
        $this->excel->getActiveSheet()->setCellValue("A1", 'Nombre');
        $this->excel->getActiveSheet()->setCellValue("B1", 'Apellido');
        $this->excel->getActiveSheet()->setCellValue("C1", 'Telefono');
        $this->excel->getActiveSheet()->setCellValue("D1", 'Correo');
        $this->excel->getActiveSheet()->setCellValue("E1", 'Perfil');
        // Definimos el background de la cabezera y el color de las letras
        $this->excel->getActiveSheet()
        ->getStyle('A1:E1')
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

        $list = $this->usuarios_model->select_list();

        $i = 2;
        $i_abc = 0;
        $abc = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

        foreach ($list as $l) {
            $i_abc=0;
            $ii_abc = 0;

            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['nombre']);
            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['apellido']);
            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['telefono']);
            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['email']);
            $this->excel->setActiveSheetIndex(0)->setCellValue($abc[$i_abc++].$i, $l['perfil']);

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
