<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();       
        $this->load->model('auth_model');
    }

    public function index(){        
        $user = $this->session->userdata('_USER_APP_');
        if (isset($user)){
            if ($user['is_logued_in'] == 1 && $user['perfil'] != 'Colaborador' && $user['perfil'] != 'Recepcion') {
                redirect('./dashboard', 'location'); 
            }else if($user['is_logued_in'] == 1 && $user['perfil'] == 'Colaborador'){
                redirect('./turnos/turno_asignar_view', 'location'); 
            }else if($user['is_logued_in'] == 1 && $user['perfil'] == 'Recepcion'){
                redirect('./turnos', 'location'); 
            }
        }
        // ====================================
        // DATA
        // ====================================
        $data['title']            = 'Iniciar Sesión'; 
        $data['breadcrumb_title'] = 'Iniciar Sesión';
        $data['breadcrumb_sub']   = 'Iniciar Sesión'; 
        $data['custom']           = 'auth'; 
        $this->load->view('templates/auth/login_view',$data);
    } 

    public function login_auth(){
        $response = array();
  
        if($this->input->post()){  
            $this->form_validation->set_rules('email',      'Correo Electrónico',      'trim|required|valid_email');
            $this->form_validation->set_rules('password',   'Contraseña',              'required|trim');
            // $this->form_validation->set_rules('g-recaptcha-response', 'reCAPTCHA', 'required|callback_validate_captcha');
            $this->form_validation->set_message('required','El campo<strong> %s </strong>es obligatorio'); 
            $this->form_validation->set_message('is_unique', 'El %s ya está registrado.'); 
            $this->form_validation->set_message('numeric','El campo<strong> %s </strong>solo acepta números');    
            $this->form_validation->set_message('min_length','El campo<strong> %s </strong> acepta mínimo %s carácteres');
            $this->form_validation->set_message('max_length','El campo<strong> %s </strong> acepta máximo %s carácteres');
            $this->form_validation->set_message('valid_email','El campo<strong> %s </strong>no tiene un formato valido');  
            $this->form_validation->set_message('matches','Las <strong>Contraseñas</strong> no coinciden');
            $this->form_validation->set_message('validate_captcha', 'Se requiere la verificación de <strong>%s</strong>');          

            if($this->form_validation->run() == false){ 
                $response['status'] = "ERROR";
                $response['message'] = validation_errors();
            }else{
                $email = $this->input->post('email');
                $password = md5($this->input->post('password'));
                $user = $this->auth_model->auth_user($email, $password);

                if ($user != "ERROR") {
                    if ($user['activo'] == 1) {
                        $data = array(
                            'is_logued_in'    => 1,
                            'usuario_id'      => $user['usuario_id'],
                            'user_encrypt'    => replace_encrypt($user['usuario_id']),
                            'perfil_id'       => $user['perfil_id'],
                            'empresa_id'      => $user['empresa_id'],
                            'departamentos'   => $user['departamentos'],
                            'perfil'          => $user['perfil'],
                            'nombre'          => $user['nombre'],
                            'apellido'        => $user['apellido'],
                            'telefono'        => $user['telefono'],
                            'email'           => $user['email'],
                            'modulo'          => '',
                            'categoria_modulo_id' => '',
                            'activo'          => $user['activo']
                        ); 

                        $data['permisos'] = $this->auth_model->get_permisos($user['perfil_id']);
                        $this->session->set_userdata(array("_USER_APP_" => $data));  
                        $response['status'] = "OK";  
                        $response['message'] = $data['perfil'];  
                    } else {
                        $response['status'] = "ERROR";
                        $response['message'] = "Su cuenta se encuentra desactivada.";
                    }
                } else {
                    $response['status'] = "ERROR";
                    $response['message'] = "El usuario o contraseña es incorrecto";
                }
            }
        }else{
            $response['status'] = "ERROR";
            $response['message'] = "No tiene permiso para entrar.";
        }
        exit(json_encode($response));
    } 

    public function logout(){
        $this->session->sess_destroy();
        redirect('./auth', 'location');
    }

}



