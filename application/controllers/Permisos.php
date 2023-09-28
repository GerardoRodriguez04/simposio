<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Permisos extends MY_Controller {
    
    public function __construct(){
        parent::__construct();     
        $user = $this->session->userdata('_USER_APP_');  
        $this->load->model('permisos_model');
        if($user['is_logued_in'] != 1){
            redirect('./auth', 'location');
        }
    }

    public function index(){
        if(!have_permission('Permisos-Edit')){            
            redirect('./Dashboard', 'location');           
        }
        $data['perfil'] = $this->permisos_model->get_perfiles();
        $data['controller'] = base_url().$this->uri->segment(1);
        $data['title'] = 'Permisos'; 
        $data['sub_title'] = 'Lista de Permisos'; 
        $data['custom'] = 'permisos'; 
        $data['content'] = 'permisos/permisos_view';
        $this->load->view('templates/common/Layout_view',$data);
    }

    public function get_permisos(){
        $res = $this->permisos_model->get_permisos($this->input->post());
        exit(json_encode($res));
    }

    public function cambiar_estatus(){
        $this->permisos_model->cambiar_estatus($this->input->post());
        $res = $this->permisos_model->get_permiso_id($this->input->post());
        exit(json_encode($res));
    }

}
