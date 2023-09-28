<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends MY_Controller {
    
    public function __construct(){
        parent::__construct();
        $this->load->model('clientes_model');
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

        $data['principales'] = $this->clientes_model->select_principales($this->input->post());
        $data['clientes'] = $this->clientes_model->select_list($this->input->post());

        $res = $this->clientes_model->get_cliente($this->input->post());

        if(!empty($res)){
            $data['button'] = 'Actualizar';
            $data['data'] = $res[0];
        }else{
            $data['button'] = 'Agregar';
            $data['data'] = array(
                'cliente_id'      => 0,
                'principal_id'      => 1,
                'nombre' => '',
                'imagen' => '',
                'direccion' => '',
                'modificado_por' => '',
                'fecha_modificacion'=> '',
            );
        }

        $data['title'] = 'Datos del sistema'; 
        $data['sub_title'] = 'Formulario de datos del cliente'; 
        $data['custom'] = 'clientes'; 
        $data['content'] = 'sistema/cliente_view';
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
        $this->form_validation->set_rules('direccion', 'Direccion', 'required|trim');

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

    public function form_cliente(){

        if(!empty($_FILES['imagen']['name'])){
            $carpeta = './web/assets/img/clients/';

            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }

            $extension = new SplFileInfo($_FILES['imagen']['name']);
            $extension = $extension->getExtension();
            $fecha = date("d-m-Y H:i:s");
            $fecha = strtotime($fecha);
            $name_foto = 'client-'.$fecha.'.'.$extension;

            $config['upload_path']   = './web/assets/img/clients/';
            $config['allowed_types'] = '*';
            $config['max_size']      = 2048;
            $config['max_width']     = 0;
            $config['max_height']    = 0;
            $config['file_name']     = $name_foto;
            $this->load->library('upload', $config);
            
            if (!$this->upload->do_upload('imagen')) {
                $res = $this->upload->display_errors();
            }else {
                $resp['infoImagen'] = $this->upload->data();
                $_POST['imagen'] = $resp['infoImagen']['file_name'];
            }
        }else{
            $_POST['imagen'] = $this->input->post('nombre_imagen');
            $res = 'El cliente no se cargo correctamente.';
        }

        $session_usuario = $this->session->userdata('_USER_APP_');

        if($this->input->post('cliente_id') > 0){
            $_POST['modificado_por'] = $session_usuario['usuario_id'];
            $_POST['fecha_modificacion'] = date('y-m-d H:i:s');
            $res = $this->clientes_model->update_cliente($this->input->post());
        }else{
            $_POST['creado_por'] = $session_usuario['usuario_id'];
            $res = $this->clientes_model->add_cliente($this->input->post());
        }

        exit(json_encode($res));
    }

    public function eliminar_registro(){
        $res = $this->clientes_model->eliminar_registro($this->input->post());
        exit(json_encode($res));
    }
}

