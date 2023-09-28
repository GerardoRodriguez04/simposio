<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Clientes_model extends CI_Model{

    public function construct() {
        parent::__construct();        
    }


    public function cambiar_estatus(){
    	$estatus = 1;

    	if($this->input->post('activo') == 1){
    		$estatus = 0;
    	}

    	$data = array(
    		'activo' => $estatus
    	);

        $this->db->where('cliente_id', $this->input->post('cliente_id'));
        $this->db->update('clientes', $data);

        return true;
    }

    public function add_cliente(){

        $data = array(
            'principal_id' => $this->input->post('principal_id'),
            'imagen' => $this->input->post('imagen'),
            'nombre' => $this->input->post('nombre'),
            'direccion' => $this->input->post('direccion'),
            'creado_por' => $this->input->post('creado_por'),
        );

        $this->db->insert('clientes', $data);

        return 'El cliente se agrego correctamente.';    
    }

    public function update_cliente(){
        $data = array(
            'principal_id' => $this->input->post('principal_id'),
            'imagen' => $this->input->post('imagen'),
            'nombre' => $this->input->post('nombre'),
            'direccion' => $this->input->post('direccion'),
            'modificado_por' => $this->input->post('modificado_por'),
            'fecha_modificacion'=> $this->input->post('fecha_modificacion'),
        );

        $this->db->where('cliente_id', $this->input->post('cliente_id'));
        $this->db->update('clientes', $data);   

        return 'El cliente se actualizo correctamente.';    
    }

    public function select_principales(){
        $session_usuario = $this->session->userdata('_USER_APP_');

        $this->db->from('principales');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();
    }

    public function select_list(){
        $session_usuario = $this->session->userdata('_USER_APP_');

        $this->db->from('clientes');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();
    }

    public function get_cliente(){
        $this->db->where('cliente_id', $this->input->post('cliente_id'));
        $this->db->from('clientes');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();    
    }

    public function eliminar_registro(){
        $this->db->where('cliente_id', $this->input->post('cliente_id'));
        $this->db->delete('clientes');
        return true;  
    }
}
