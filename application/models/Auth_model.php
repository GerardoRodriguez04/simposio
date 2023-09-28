<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model{

    public function construct() {
        parent::__construct();        
    }

    public function auth_user($email, $password){
        if ($email != "") {
            $this->db->where('u.email', $email);
        }
        // $this->db->where('u.password', $password);
        $this->db->select('u.*,p.perfil');
        $this->db->from('usuarios u');
        $this->db->join('perfiles p', 'p.perfil_id = u.perfil_id', 'left');
        // $this->db->join('modulos m', 'm.usuario_id = u.usuario_id', 'left');
        $resp['usuario'] = $this->db->get();
        $resp['usuario'] = $resp['usuario']->result_array();

        for ($i=0; $i < count($resp['usuario']); $i++) {
            $this->db->where('ud.usuario_id', $resp['usuario'][$i]['usuario_id']);
            $this->db->join('usuario_departamentos ud', 'ud.departamento_id = d.departamento_id', 'left');
            $this->db->from('departamentos d');
            $this->db->select('d.*');
            $departamentos = $this->db->get();
            $resp['usuario'][$i]['departamentos'] = $departamentos->result_array();
        }

        if(!empty($resp['usuario'])){
            $resp = $resp['usuario'][0];
        }else{
            $resp = 'ERROR';
        }

        return $resp;
    }

    public function get_permisos($perfil_id){
        $profile_key = 'perfil_' . $perfil_id;
        $this->db->select("modulo");
        $this->db->where($profile_key, 1);
        $this->db->order_by("modulo", "asc");
        $query = $this->db->get('permisos');
        $permisos = array();
        foreach ($query->result_array() as $row){
            $permisos[] =  $row['modulo'];
        }
        return  $permisos;
    }


}
