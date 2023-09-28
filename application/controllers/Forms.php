<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forms extends CI_Controller {

    public function __construct(){
        parent::__construct();       
        $this->load->model('forms_model');
    }

    public function index(){        
        $data['title']            = 'Formulario de registro'; 
        $data['breadcrumb_title'] = 'Formulario de registro';
        $data['breadcrumb_sub']   = 'Formulario de registro'; 
        $data['custom']           = 'forms'; 
        $this->load->view('templates/formularios/form_view',$data);
    }

    public function validar_form(){

        $response = array();

        if(!$this->input->post()){
            $response['estatus'] = "ERROR";
            $response['message'] = "No tiene permiso para entrar.";
            exit(json_encode($response));
        }

        $this->form_validation->set_rules('nombre', 'Nombre completo', 'required|trim');

        if($this->input->post('participante_id') < 0){
            $this->form_validation->set_rules('telefono', 'Whatsapp', 'required|numeric|trim|is_unique[participantes.telefono]');
            $this->form_validation->set_rules('correo_electronico', 'Correo electrónico', 'required|valid_email|trim|is_unique[participantes.correo_electronico]');
        }

        $this->form_validation->set_rules('universidad', 'Universidad', 'required|trim');
        $this->form_validation->set_rules('carrera', 'Carrera', 'required|trim');
        $this->form_validation->set_rules('area_interes', 'Área de interes', 'required|trim');

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

    public function form_registro(){

        $session_usuario = $this->session->userdata('_USER_APP_');

        if($this->input->post('participante_id') > 0){
            $_POST['modificado_por'] = $session_usuario['usuario_id'];
            $_POST['fecha_modificacion'] = date('y-m-d H:i:s');
            $res = $this->forms_model->update_registro($this->input->post());
        }else{
            $_POST['creado_por'] = $session_usuario['usuario_id'];
            $res = $this->forms_model->add_registro($this->input->post());
        }
        exit(json_encode($res));
    }

}



