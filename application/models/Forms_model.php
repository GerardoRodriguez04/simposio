<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Forms_model extends CI_Model{

    public function construct() {
        parent::__construct();        
    }

    public function add_registro(){
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'correo_electronico' => $this->input->post('correo_electronico'),
            'telefono' => $this->input->post('telefono'),
            'universidad' => $this->input->post('universidad'),
            'carrera' => $this->input->post('carrera'),
            'area_interes' => $this->input->post('area_interes'),
            'tipo' => $this->input->post('tipo'),
        );

        $this->db->insert('participantes', $data);

        return 'Gracias por tu registro! Aquí mismo podrás descargar tu constancia posterior al evento';
    }

    public function update_registro(){
        $data = array(
            'nombre' => $this->input->post('nombre'),
            'correo_electronico' => $this->input->post('correo_electronico'),
            'telefono' => $this->input->post('telefono'),
            'universidad' => $this->input->post('universidad'),
            'carrera' => $this->input->post('carrera'),
            'area_interes' => $this->input->post('area_interes'),
            'tipo' => $this->input->post('tipo'),
            'modificado_por'     => $this->input->post('modificado_por'),
            'fecha_modificacion' => $this->input->post('fecha_modificacion')
        );

        $this->db->where('participante_id', $this->input->post('participante_id'));
        $this->db->update('participantes', $data);

        return 'El participante se actualizo correctamente.';
    }
}
