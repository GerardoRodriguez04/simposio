<?php defined('BASEPATH') OR exit('No direct script access allowed');

class General extends MY_Controller {
	
    public function __construct(){
        parent::__construct();     
        $this->load->model('general_model');
        $this->load->library('pagination');
        $user = $this->session->userdata('_USER_APP_');  
        // if($user['is_logued_in'] != 1 || $user['perfil'] == 'Quimico' || $user['perfil'] == 'Recepción'){
            redirect('./auth', 'location');
        // }
    }

    public function eliminar_registro(){
        $res = $this->general_model->eliminar_registro($this->input->post());
        exit(json_encode($res));
    }

    public function get_total_notificaciones_solicitudes(){
        $res = $this->general_model->get_total_notificaciones_solicitudes($this->input->post());
        exit(json_encode($res));
    }

    public function get_notificaciones(){
        $res = $this->general_model->get_notificaciones($this->input->post());
        exit(json_encode($res));
    }
}
