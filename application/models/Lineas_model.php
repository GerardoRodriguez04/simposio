<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lineas_model extends CI_Model{

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

        $this->db->where('linea_id', $this->input->post('linea_id'));
        $this->db->update('linea_tiempo', $data);

        return true;
    }

    public function add_linea(){

        $data = array(
            'año' => $this->input->post('año'),
            'principal_id' => $this->input->post('principal_id'),
            'descripcion' => $this->input->post('descripcion'),
            'creado_por' => $this->input->post('creado_por'),
        );

        $this->db->insert('linea_tiempo', $data);

        return 'La linea se agrego correctamente.';    
    }

    public function update_linea(){
        $data = array(
            'año' => $this->input->post('año'),
            'principal_id' => $this->input->post('principal_id'),
            'descripcion' => $this->input->post('descripcion'),
            'modificado_por' => $this->input->post('modificado_por'),
            'fecha_modificacion'=> $this->input->post('fecha_modificacion'),
        );

        $this->db->where('linea_id', $this->input->post('linea_id'));
        $this->db->update('linea_tiempo', $data);   

        return 'La linea se actualizo correctamente.';    
    }

    public function select_list(){
        $session_usuario = $this->session->userdata('_USER_APP_');

        $this->db->order_by('año', 'DESC');
        $this->db->from('linea_tiempo');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();
    }

    public function get_linea(){
        $this->db->where('linea_id', $this->input->post('linea_id'));
        $this->db->from('linea_tiempo');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();    
    }

    public function eliminar_registro(){
        $this->db->where('linea_id', $this->input->post('linea_id'));
        $this->db->delete('linea_tiempo');
        return true;  
    }
}
