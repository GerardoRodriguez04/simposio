<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model{

    public function construct() {
        parent::__construct();
    }

    public function select_count(){
        if(!empty($this->input->get('nombre'))){
            $this->db->where('nombre LIKE', '%'.$this->input->get('nombre').'%');
        }

        if(!empty($this->input->get('telefono'))){
            $this->db->where('telefono LIKE', '%'.$this->input->get('telefono').'%');
        }

        if(!empty($this->input->get('correo_electronico'))){
            $this->db->where('correo_electronico LIKE', '%'.$this->input->get('correo_electronico').'%');
        }

        if(!empty($this->input->get('universidad'))){
            $this->db->where('universidad LIKE', '%'.$this->input->get('universidad').'%');
        }

        if(!empty($this->input->get('carrera'))){
            $this->db->where('carrera LIKE', '%'.$this->input->get('carrera').'%');
        }

        if(!empty($this->input->get('area_interes'))){
            $this->db->where('area_interes LIKE', '%'.$this->input->get('area_interes').'%');
        }

        if(!empty($this->input->get('tipo'))){
            $this->db->where('tipo', $this->input->get('tipo'));
        }

        $this->db->from('participantes p');
        $this->db->select('COUNT(*) total');
        $resp = $this->db->get();
        $resp = $resp->result_array();
        return $resp[0]['total'];
    }

    public function select_all($limit, $pagina){
        if(!empty($this->input->get('nombre'))){
            $this->db->where('nombre LIKE', '%'.$this->input->get('nombre').'%');
        }

        if(!empty($this->input->get('telefono'))){
            $this->db->where('telefono LIKE', '%'.$this->input->get('telefono').'%');
        }

        if(!empty($this->input->get('correo_electronico'))){
            $this->db->where('correo_electronico LIKE', '%'.$this->input->get('correo_electronico').'%');
        }

        if(!empty($this->input->get('universidad'))){
            $this->db->where('universidad LIKE', '%'.$this->input->get('universidad').'%');
        }

        if(!empty($this->input->get('carrera'))){
            $this->db->where('carrera LIKE', '%'.$this->input->get('carrera').'%');
        }

        if(!empty($this->input->get('area_interes'))){
            $this->db->where('area_interes LIKE', '%'.$this->input->get('area_interes').'%');
        }

        if(!empty($this->input->get('tipo'))){
            $this->db->where('tipo', $this->input->get('tipo'));
        }

        $this->db->limit($limit, $pagina);
        $this->db->from('participantes p');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();
    }

    public function select_list(){
        $this->db->from('participantes');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();
    }
}