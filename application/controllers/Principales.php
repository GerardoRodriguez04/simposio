<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Principales extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('principales_model');
        $this->load->library('excel');
        $this->load->library('pagination');
        $this->load->helper('download');    
        $user = $this->session->userdata('_USER_APP_');  
        if($user['is_logued_in'] != 1){
            redirect('./auth', 'location');
        } 
    }

    public function index(){

        // if(!have_permission('Principales-List')){            
            // redirect('./Dashboard', 'location');           
        // }

        // $_POST['principal_id'] = $this->uri->segment(3);
        $_POST['principal_id'] = 1;

        $data['controller'] = base_url().$this->uri->segment(1);

        $res = $this->principales_model->get_principal($this->input->post());

        if(!empty($res)){
            $data['button'] = 'Actualizar';
            $data['data'] = $res[0];
        }else{
            $data['button'] = 'Agregar';
            $data['data'] = array(
                'principal_id'      => 0,
                'correo_principal' => '',
                'telefono_1' => '',
                'telefono_2' => '',
                'logo_inicio' => '',
                'mensaje_inicio_1' => '',
                'mensaje_inicio_2' => '',
                'mision_inicio' => '',
                'vision_inicio' => '',
                'giro_inicio' => '',
                'subtitulo_nosotros' => '',
                'descripcion_nosotros' => '',
                'imagen_nosotros_1' => '',
                'imagen_nosotros_2' => '',
                'subtitulo_linea' => '',
                'titulo_mantenimientos' => '',
                'subtitulo_mantenimientos' => '',
                'subtitulo_clientes' => '',
                'subtitulo_marcas' => '',
                'titulo_articulos' => '',
                'titulo_contactos' => '',
                'creado_por' => '',
                'fecha_creacion' => '',
                'modificado_por' => '',
                'fecha_modificacion'=> '',
            );
        }

        $data['title'] = 'Datos del sistema'; 
        $data['sub_title'] = 'Formulario de datos principales'; 
        $data['custom'] = 'principales'; 
        $data['content'] = 'sistema/principal_view';
        $this->load->view('templates/common/Layout_view',$data);
    }

    public function validar_form(){

        $response = array();

        if(!$this->input->post()){
            $response['estatus'] = "ERROR";
            $response['message'] = "No tiene permiso para entrar.";
            exit(json_encode($response));
        }

        $this->form_validation->set_rules('correo_principal', 'Correo electrónico', 'required|trim');
        $this->form_validation->set_rules('telefono_1', 'Teléfono 1', 'required|trim');
        $this->form_validation->set_rules('telefono_2', 'Teléfono 2', 'required|trim');
        // $this->form_validation->set_rules('logo_inicio', 'Logo inicio', 'required|trim');
        $this->form_validation->set_rules('mensaje_inicio_1', 'Mensaje Bienvenida 1', 'required|trim');
        $this->form_validation->set_rules('mensaje_inicio_2', 'Mensaje Bienvenida 2', 'required|trim');
        $this->form_validation->set_rules('mision_inicio', 'Misión', 'required|trim');
        $this->form_validation->set_rules('vision_inicio', 'Visión', 'required|trim');
        $this->form_validation->set_rules('giro_inicio', 'Giro', 'required|trim');
        $this->form_validation->set_rules('subtitulo_nosotros', 'Subtitulo nosotros*', 'required|trim');
        $this->form_validation->set_rules('descripcion_nosotros', 'Descripción nosotros', 'required|trim');
        // $this->form_validation->set_rules('imagen_nosotros_1', 'Imagen nosotros 1', 'required|trim');
        // $this->form_validation->set_rules('imagen_nosotros_2', 'Imagen nosotros 2', 'required|trim');

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

    public function form_principal(){

        $session_usuario = $this->session->userdata('_USER_APP_');

        if($this->input->post('principal_id') > 0){
            $_POST['modificado_por'] = $session_usuario['usuario_id'];
            $_POST['fecha_modificacion'] = date('y-m-d H:i:s');
            $res = $this->principales_model->update_principal($this->input->post());
        }else{
            $_POST['creado_por'] = $session_usuario['usuario_id'];
            $res = $this->principales_model->add_principal($this->input->post());
        }

        exit(json_encode($res));
    }
}

