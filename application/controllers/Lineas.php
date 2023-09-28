<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Lineas extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('lineas_model');
        $this->load->library('excel');
        $this->load->library('pagination');
        $this->load->helper('download');    
        $user = $this->session->userdata('_USER_APP_');  
        if($user['is_logued_in'] != 1){
            redirect('./auth', 'location');
        } 
    }

    public function index(){

        // if(!have_permission('lineas-List')){            
            // redirect('./Dashboard', 'location');           
        // }

        // $_POST['linea_id'] = $this->uri->segment(3);
        // $_POST['linea_id'] = 1;

        $data['controller'] = base_url().$this->uri->segment(1);

        $data['lineas'] = $this->lineas_model->select_list($this->input->post());

        // print_r($data);
        // exit();

        $res = $this->lineas_model->get_linea($this->input->post());

        if(!empty($res)){
            $data['button'] = 'Actualizar';
            $data['data'] = $res[0];
        }else{
            $data['button'] = 'Agregar';
            $data['data'] = array(
                'linea_id'      => 0,
                'principal_id'      => 1,
                'año' => '',
                'descripcion' => '',
                'modificado_por' => '',
                'fecha_modificacion'=> '',
            );
        }

        $data['title'] = 'Datos del sistema'; 
        $data['sub_title'] = 'Formulario de datos lineas del tiempo'; 
        $data['custom'] = 'lineas'; 
        $data['content'] = 'sistema/linea_view';
        $this->load->view('templates/common/Layout_view',$data);
    }

    public function validar_form(){

        $response = array();

        if(!$this->input->post()){
            $response['estatus'] = "ERROR";
            $response['message'] = "No tiene permiso para entrar.";
            exit(json_encode($response));
        }

        $this->form_validation->set_rules('año', 'Año', 'required|trim');
        $this->form_validation->set_rules('descripcion', 'Descripción', 'required|trim');

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

    public function form_linea(){

        $session_usuario = $this->session->userdata('_USER_APP_');

        if($this->input->post('linea_id') > 0){
            $_POST['modificado_por'] = $session_usuario['usuario_id'];
            $_POST['fecha_modificacion'] = date('y-m-d H:i:s');
            $res = $this->lineas_model->update_linea($this->input->post());
        }else{
            $_POST['creado_por'] = $session_usuario['usuario_id'];
            $res = $this->lineas_model->add_linea($this->input->post());
        }

        exit(json_encode($res));
    }

    public function eliminar_registro(){
        $res = $this->lineas_model->eliminar_registro($this->input->post());
        exit(json_encode($res));
    }
}

