<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Empresas_model extends CI_Model{

    public function construct() {
        parent::__construct();        
    }

    public function select_count(){
        if(!empty($this->input->get('razon_social'))){
            $this->db->where('e.razon_social LIKE', '%'.$this->input->get('razon_social').'%');
        }

        if($this->input->get('activo') != 'todos'){
            $this->db->where('e.activo', $this->input->get('activo'));
        }
        
        $this->db->from('empresas e');
        $this->db->select('COUNT(*) total');
        $resp = $this->db->get(); 
        $resp = $resp->result_array();
        return $resp[0]['total'];
    }

    public function select_all($limit, $pagina){
        if(!empty($this->input->get('razon_social'))){
            $this->db->where('e.razon_social LIKE', '%'.$this->input->get('razon_social').'%');
        }

        if($this->input->get('activo') != 'todos'){
            $this->db->where('e.activo', $this->input->get('activo'));
        }

        $this->db->limit($limit, $pagina);
        $this->db->from('empresas e');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();    
    }

    public function cambiar_estatus(){
    	$estatus = 1;

    	if($this->input->post('activo') == 1){
    		$estatus = 0;
    	}

    	$data = array(
    		'activo' => $estatus
    	);

        $this->db->where('empresa_id', $this->input->post('empresa_id'));
        $this->db->update('empresas', $data);

        return true;
    }

    public function add_empresa(){

        $data = array(
            'razon_social'          => $this->input->post('razon_social'),
            'direccion'        => $this->input->post('direccion'),
            'telefono'           => $this->input->post('telefono'),
            'creado_por'      => $this->input->post('creado_por'),
            'activo'          => ($this->input->post('activo') == 1) ? 1 : 0
        );

        $this->db->insert('empresas', $data);

        return 'La empresa se agrego correctamente.';    
    }

    public function update_empresa(){
        $data = array(
            'razon_social'          => $this->input->post('razon_social'),
            'direccion'        => $this->input->post('direccion'),
            'telefono'           => $this->input->post('telefono'),
            'creado_por'      => $this->input->post('creado_por'),
            'activo'          => ($this->input->post('activo') == 1) ? 1 : 0
        );

        $this->db->where('empresa_id', $this->input->post('empresa_id'));
        $this->db->update('empresas', $data);   

        return 'La empresa se actualizo correctamente.';    
    }

    public function select_list(){
        $session_usuario = $this->session->userdata('_USER_APP_');

        $this->db->from('empresas e');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();
    }

    public function get_empresa(){
        $this->db->where('empresa_id', $this->input->post('empresa_id'));
        $this->db->from('empresas e');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();    
    }
}
