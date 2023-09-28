<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Principales_model extends CI_Model{

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

        $this->db->where('principal_id', $this->input->post('principal_id'));
        $this->db->update('principales', $data);

        return true;
    }

    public function add_principal(){

        $data = array(
            'correo_principal' => $this->input->post('correo_principal'),
            'telefono_1' => $this->input->post('telefono_1'),
            'telefono_2' => $this->input->post('telefono_2'),
            'logo_inicio' => $this->input->post('logo_inicio'),
            'mensaje_inicio_1' => $this->input->post('mensaje_inicio_1'),
            'mensaje_inicio_2' => $this->input->post('mensaje_inicio_2'),
            'mision_inicio' => $this->input->post('mision_inicio'),
            'vision_inicio' => $this->input->post('vision_inicio'),
            'giro_inicio' => $this->input->post('giro_inicio'),
            'subtitulo_nosotros' => $this->input->post('subtitulo_nosotros'),
            'descripcion_nosotros' => $this->input->post('descripcion_nosotros'),
            'imagen_nosotros_1' => $this->input->post('imagen_nosotros_1'),
            'imagen_nosotros_2' => $this->input->post('imagen_nosotros_2'),
            'subtitulo_linea' => $this->input->post('subtitulo_linea'),
            'titulo_mantenimientos' => $this->input->post('titulo_mantenimientos'),
            'subtitulo_mantenimientos' => $this->input->post('subtitulo_mantenimientos'),
            'subtitulo_clientes' => $this->input->post('subtitulo_clientes'),
            'subtitulo_marcas' => $this->input->post('subtitulo_marcas'),
            'titulo_articulos' => $this->input->post('titulo_articulos'),
            'titulo_contactos' => $this->input->post('titulo_contactos'),
            'creado_por' => $this->input->post('creado_por'),
            'fecha_creacion' => $this->input->post('creado_por'),
        );

        $this->db->insert('principales', $data);

        return 'La principal se agrego correctamente.';    
    }

    public function update_principal(){
        $data = array(
            'correo_principal' => $this->input->post('correo_principal'),
            'telefono_1' => $this->input->post('telefono_1'),
            'telefono_2' => $this->input->post('telefono_2'),
            'logo_inicio' => $this->input->post('logo_inicio'),
            'mensaje_inicio_1' => $this->input->post('mensaje_inicio_1'),
            'mensaje_inicio_2' => $this->input->post('mensaje_inicio_2'),
            'mision_inicio' => $this->input->post('mision_inicio'),
            'vision_inicio' => $this->input->post('vision_inicio'),
            'giro_inicio' => $this->input->post('giro_inicio'),
            'subtitulo_nosotros' => $this->input->post('subtitulo_nosotros'),
            'descripcion_nosotros' => $this->input->post('descripcion_nosotros'),
            'imagen_nosotros_1' => $this->input->post('imagen_nosotros_1'),
            'imagen_nosotros_2' => $this->input->post('imagen_nosotros_2'),
            'subtitulo_linea' => $this->input->post('subtitulo_linea'),
            'titulo_mantenimientos' => $this->input->post('titulo_mantenimientos'),
            'subtitulo_mantenimientos' => $this->input->post('subtitulo_mantenimientos'),
            'subtitulo_clientes' => $this->input->post('subtitulo_clientes'),
            'subtitulo_marcas' => $this->input->post('subtitulo_marcas'),
            'titulo_articulos' => $this->input->post('titulo_articulos'),
            'titulo_contactos' => $this->input->post('titulo_contactos'),
            'modificado_por' => $this->input->post('modificado_por'),
            'fecha_modificacion'=> $this->input->post('fecha_modificacion'),
        );

        $this->db->where('principal_id', $this->input->post('principal_id'));
        $this->db->update('principales', $data);   

        return 'La principal se actualizo correctamente.';    
    }

    public function select_list(){
        $session_usuario = $this->session->userdata('_USER_APP_');

        $this->db->from('principales e');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();
    }

    public function get_principal(){
        $this->db->where('principal_id', $this->input->post('principal_id'));
        $this->db->from('principales e');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();    
    }
}
