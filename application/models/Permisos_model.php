<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Permisos_model extends CI_Model{

    public function construct() {
        parent::__construct();        
    }

    public function get_permisos(){
        $sql = "SELECT 
                permiso_id,
                modulo,
                nombre,
                {$this->input->post('perfil')},
                grupo
                FROM permisos";

        $query = $this->db->query($sql);
        $permisos = $query->result_array(); 
        return $permisos;
    }

    public function cambiar_estatus(){
        $data = array(
            ''.$this->input->post('perfil').'' => $this->input->post('estatus')
        );

        $this->db->where('permiso_id', $this->input->post('permiso_id'));
        $this->db->update('permisos', $data);

        return true;
    }

    public function get_permiso_id(){
        $sql = "SELECT 
                permiso_id,
                modulo,
                nombre,
                {$this->input->post('perfil')},
                grupo
                FROM permisos
                WHERE permiso_id = ".$this->input->post('permiso_id')." ";

        $query = $this->db->query($sql);
        $permisos = $query->result_array(); 
        return $permisos;   
    }

    public function get_perfiles(){
        $this->db->from('perfiles p');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();    
    }

}
