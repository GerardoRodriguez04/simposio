<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Departamentos_model extends CI_Model{

    public function construct() {
        parent::__construct();
    }

    public function select_count(){
        if(!empty($this->input->get('departamento'))){
            $this->db->where('d.departamento LIKE', '%'.$this->input->get('departamento').'%');
        }
        if($this->input->get('activo') != 'todos'){
            $this->db->where('d.activo', $this->input->get('activo'));
        }

        $this->db->join('usuarios u', 'u.usuario_id = d.creado_por', 'left');
        $this->db->from('departamentos d');
        $this->db->select('COUNT(*) total');
        $resp = $this->db->get();
        $resp = $resp->result_array();
        return $resp[0]['total'];
    }

    public function select_all($limit, $pagina){
        if(!empty($this->input->get('departamento'))){
            $this->db->where('d.departamento LIKE', '%'.$this->input->get('departamento').'%');
        }
        if($this->input->get('activo') != 'todos'){
            $this->db->where('d.activo', $this->input->get('activo'));
        }

        $this->db->limit($limit, $pagina);
        $this->db->join('usuarios u', 'u.usuario_id = d.creado_por', 'left');
        $this->db->from('departamentos d');
        $this->db->select('d.*');
        $resp = $this->db->get();
        return $resp->result_array();
    }

    public function cambiar_estatus(){
        $estatus = 1;

        if($this->input->post('activo') == 1){
            $estatus = 0;
        }

        $data = array(
            'activo' => $estatus,
            'modificado_por' => $this->input->post('modificado_por'),
            'fecha_modificacion' => $this->input->post('fecha_modificacion')
        );

        $this->db->where('departamento_id', $this->input->post('departamento_id'));
        $this->db->update('departamentos', $data);

        return true;
    }

    public function cambiar_visibilidad(){
        $visible = 1;

        if($this->input->post('visible') == 1){
            $visible = 0;
        }

        $data = array(
            'visible' => $visible,
            'modificado_por' => $this->input->post('modificado_por'),
            'fecha_modificacion' => $this->input->post('fecha_modificacion')
        );

        $this->db->where('departamento_id', $this->input->post('departamento_id'));
        $this->db->update('departamentos', $data);

        return true;
    }

    public function get_departamento(){
        $this->db->where('d.departamento_id', $this->input->post('departamento_id'));
        $this->db->join('usuarios u', 'u.usuario_id = d.creado_por', 'left');
        $this->db->from('departamentos d');
        $this->db->select('d.*, u.nombre, u.apellido');
        $resp = $this->db->get();
        return $resp->result_array();
    }

    public function get_servicios(){
        $this->db->where('s.departamento_id', $this->input->post('departamento_id'));
        $this->db->from('servicios s');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();
    }

    public function get_usuarios(){
        $this->db->join('perfiles p', 'p.perfil_id = u.perfil_id', 'left');
        $this->db->where('d.departamento_id', $this->input->post('departamento_id'));
        $this->db->join('usuario_departamentos ud', 'ud.usuario_id = u.usuario_id', 'left');
        $this->db->join('departamentos d', 'd.departamento_id = ud.departamento_id', 'left');
        $this->db->from('usuarios u');
        $this->db->select('u.*, p.perfil');
        $resp = $this->db->get();
        return $resp->result_array();
    }

    public function add_departamento(){
        $data = array(
            'departamento' => $this->input->post('departamento'),
            'descripcion' => $this->input->post('descripcion'),
            'activo'      => 1,
            'creado_por'  => $this->input->post('creado_por')
        );

        $this->db->insert('departamentos', $data);

        return 'El departamento se agrego correctamente.';
    }

    public function update_departamento(){
        $data = array(
            'departamento' => $this->input->post('departamento'),
            'descripcion'        => $this->input->post('descripcion'),
            'modificado_por'     => $this->input->post('modificado_por'),
            'fecha_modificacion' => $this->input->post('fecha_modificacion')
        );

        $this->db->where('departamento_id', $this->input->post('departamento_id'));
        $this->db->update('departamentos', $data);

        return 'El departamento se actualizo correctamente.';
    }

    public function add_servicio(){
        $data = array(
            'servicio' => $this->input->post('servicio'),
            'descripcion' => $this->input->post('descripcion'),
            'departamento_id' => $this->input->post('departamento_id'),
            'activo'      => 1,
            'creado_por'  => $this->input->post('creado_por')
        );

        $this->db->insert('servicios', $data);

        return 'El servicio se agrego correctamente.';
    }

    public function get_perfiles(){
        $this->db->from('perfiles p');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();    
    }

    public function add_usuario(){
        $data = array(
            'nombre'          => $this->input->post('nombre'),
            'apellido'        => $this->input->post('apellido'),
            'email'           => $this->input->post('email'),
            'perfil_id'       => $this->input->post('perfil_id'),
            'telefono'        => $this->input->post('telefono'),
            'password'        => $this->input->post('password'),
            'creado_por'      => $this->input->post('creado_por'),
            'activo'          => ($this->input->post('activo') == 1) ? 1 : 0
        );

        $data['password'] = md5($this->input->post('password'));
        $this->db->insert('usuarios', $data);

        $usuario_id = $this->db->insert_id();

        $datos = array(
            'departamento_id' => $_POST['departamento_id'],
            'usuario_id'      => $usuario_id,
            'creado_por'      =>  $this->input->post('creado_por')
        );

        $this->db->insert('usuario_departamentos', $datos);          

        return 'El usuario se agrego correctamente.';    
    }

    public function eliminar_departamento(){

        $this->db->where('s.departamento_asignado_id', $this->input->post('departamento_id'));
        $this->db->from('solicitudes s');
        $this->db->select('COUNT(solicitud_id) as total');
        $departamento_asignado_id = $this->db->get();
        $departamento_asignado_id = $departamento_asignado_id->result_array();

        $this->db->where('s.departamento_solicitante_id', $this->input->post('departamento_id'));
        $this->db->from('solicitudes s');
        $this->db->select('COUNT(solicitud_id) as total');
        $departamento_solicitante_id = $this->db->get();
        $departamento_solicitante_id = $departamento_solicitante_id->result_array();

        $this->db->where('s.departamento_id', $this->input->post('departamento_id'));
        $this->db->from('servicios s');
        $this->db->select('COUNT(servicio_id) as total');
        $departamento_id = $this->db->get();
        $departamento_id = $departamento_id->result_array();

        if($departamento_asignado_id[0]['total'] == 0 && $departamento_solicitante_id[0]['total'] == 0 && $departamento_id[0]['total'] == 0){
            $this->db->where('departamento_id', $this->input->post('departamento_id'));
            $this->db->delete('departamentos');
            return true;
        }

        return false;
    }

    public function select_list(){
        $session_usuario = $this->session->userdata('_USER_APP_');

        if($session_usuario['perfil_id'] < 4){
            $where_or = '';

            if(!empty($session_usuario['departamentos'])){            
                foreach ($session_usuario['departamentos'] as $d) {
                    $where_or .= ' d.departamento_id ='.$d['departamento_id'].' OR ';
                }

                $where_or = rtrim($where_or, "OR  ");

                $this->db->where('('.$where_or.')');
            }
        }

        $this->db->join('usuarios u', 'u.usuario_id = d.creado_por', 'left');
        $this->db->from('departamentos d');
        $this->db->select('d.*');
        $resp = $this->db->get();
        return $resp->result_array();
    }
}
