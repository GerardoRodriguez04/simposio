<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_model extends CI_Model{

    public function construct() {
        parent::__construct();        
    }

    public function select_count(){
        if(!empty($this->input->get('nombre'))){
            $this->db->where('u.nombre LIKE', '%'.$this->input->get('nombre').'%');
        }

        if(!empty($this->input->get('apellido'))){
            $this->db->where('u.apellido LIKE', '%'.$this->input->get('apellido').'%');
        }

        if(!empty($this->input->get('email'))){
            $this->db->where('u.email LIKE', '%'.$this->input->get('email').'%');
        }

        if(!empty($this->input->get('perfil_id'))){
            $this->db->where('u.perfil_id', $this->input->get('perfil_id'));
        }

        if(!empty($this->input->get('departamento_id'))){
            $this->db->where('u.departamento_id', $this->input->get('departamento_id'));
        }

        if($this->input->get('activo') != 'todos'){
            $this->db->where('u.activo', $this->input->get('activo'));
        }
        
        // $this->db->group_by('u.usuario_id');        
        // $this->db->join('usuario_departamentos ud', 'ud.usuario_id = u.usuario_id', 'left');
        // $this->db->join('departamentos d', 'd.departamento_id = ud.departamento_id', 'left');
        $this->db->join('empresas e', 'e.empresa_id = u.empresa_id', 'left');
        $this->db->join('perfiles p', 'p.perfil_id = u.perfil_id', 'left');
        $this->db->from('usuarios u');
        $this->db->select('COUNT(*) total');
        $resp = $this->db->get(); 
        $resp = $resp->result_array();
        return $resp[0]['total'];
    }

    public function select_all($limit, $pagina){
        if(!empty($this->input->get('nombre'))){
            $this->db->where('u.nombre LIKE', '%'.$this->input->get('nombre').'%');
        }

        if(!empty($this->input->get('apellido'))){
            $this->db->where('u.apellido LIKE', '%'.$this->input->get('apellido').'%');
        }

        if(!empty($this->input->get('email'))){
            $this->db->where('u.email LIKE', '%'.$this->input->get('email').'%');
        }

        if(!empty($this->input->get('perfil_id'))){
            $this->db->where('u.perfil_id', $this->input->get('perfil_id'));
        }

        if(!empty($this->input->get('departamento_id'))){
            $this->db->where('u.departamento_id', $this->input->get('departamento_id'));
        }

        // if($this->input->get('activo') != 'todos'){
        //     $this->db->where('u.activo', $this->input->get('activo'));
        // }

        $this->db->where('u.activo', 1);

        $this->db->limit($limit, $pagina);

        // $this->db->group_by('u.usuario_id');        
        // $this->db->join('usuario_departamentos ud', 'ud.usuario_id = u.usuario_id', 'left');
        // $this->db->join('departamentos d', 'd.departamento_id = ud.departamento_id', 'left');
        $this->db->join('empresas e', 'e.empresa_id = u.empresa_id', 'left');
        $this->db->join('perfiles p', 'p.perfil_id = u.perfil_id', 'left');
        $this->db->from('usuarios u');
        $this->db->select('u.*, e.razon_social, p.perfil');
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

        $this->db->where('usuario_id', $this->input->post('usuario_id'));
        $this->db->update('usuarios', $data);

        return true;
    }

    public function get_usuario(){
        $this->db->where('u.usuario_id', $this->input->post('usuario_id'));
        $this->db->join('perfiles p', 'p.perfil_id = u.perfil_id', 'left');
        $this->db->join('usuario_departamentos ud', 'ud.usuario_id = u.usuario_id', 'left');
        $this->db->join('departamentos d', 'd.departamento_id = ud.departamento_id', 'left');
        $this->db->from('usuarios u');
        $this->db->select('u.*, p.*, d.departamento');
        $resp = $this->db->get();
        return $resp->result_array();    
    }

    public function get_perfiles(){
        $this->db->from('perfiles p');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();    
    }

    public function get_departamentos(){
        $this->db->order_by("d.departamento", "Asc");
        $this->db->where('d.activo', 1);
        $this->db->from('departamentos d');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();    
    }

    public function get_empresas(){
        $this->db->order_by("e.razon_social", "Asc");
        $this->db->where('e.activo', 1);
        $this->db->from('empresas e');
        $this->db->select('*');
        $resp = $this->db->get();
        return $resp->result_array();    
    }

    public function get_departamentos_usuario(){
        $this->db->where('ud.usuario_id', $this->input->post('usuario_id'));
        $this->db->join('departamentos d', 'ud.departamento_id = d.departamento_id', 'left');
        $this->db->from('usuario_departamentos ud');
        $this->db->select('ud.*, d.departamento');
        $resp = $this->db->get();
        return $resp->result_array();    
    }

    public function add_usuario(){

        $data = array(
            'nombre'          => $this->input->post('nombre'),
            'apellido'        => $this->input->post('apellido'),
            'email'           => $this->input->post('email'),
            'perfil_id'       => $this->input->post('perfil_id'),
            'empresa_id'       => $this->input->post('empresa_id'),
            'telefono'        => $this->input->post('telefono'),
            'password'        => $this->input->post('password'),
            'creado_por'      => $this->input->post('creado_por'),
            'activo'          => ($this->input->post('activo') == 1) ? 1 : 0
        );

        $data['password'] = md5($this->input->post('password'));
        $this->db->insert('usuarios', $data);

        $usuario_id = $this->db->insert_id();

        foreach ($this->input->post('departamento_id') as $key => $mt) {
            $datos[] = array(
                'departamento_id' => $_POST['departamento_id'][$key],
                'usuario_id'      => $usuario_id,
                'creado_por'      =>  $this->input->post('creado_por')
            );
        }

        $this->db->insert_batch('usuario_departamentos', $datos);

        return 'El usuario se agrego correctamente.';    
    }

    public function update_usuario(){
        $data = array(
            'nombre'             => $this->input->post('nombre'),
            'apellido'           => $this->input->post('apellido'),
            'email'              => $this->input->post('email'),
            'perfil_id'          => $this->input->post('perfil_id'),
            'empresa_id'         => $this->input->post('empresa_id'),
            'telefono'           => $this->input->post('telefono'),
            'modificado_por'     => $this->input->post('modificado_por'),
            'fecha_modificacion' => $this->input->post('fecha_modificacion'),
            'activo'             => ($this->input->post('activo') == 1) ? 1 : 0
        );

        if(!empty($this->input->post('password'))){
            $data['password'] = md5($this->input->post('password'));
        }

        $this->db->where('usuario_id', $this->input->post('usuario_id'));
        $this->db->update('usuarios', $data);

        $this->db->where('usuario_id', $this->input->post('usuario_id'));
        $this->db->delete('usuario_departamentos');

        foreach ($this->input->post('departamento_id') as $key => $mt) {
            $datos[] = array(
                'departamento_id'      => $_POST['departamento_id'][$key],
                'usuario_id'           => $this->input->post('usuario_id'),
                'creado_por'           => $this->input->post('modificado_por'),
            );
        }

        $this->db->insert_batch('usuario_departamentos', $datos);    

        return 'El usuario se actualizo correctamente.';    
    }

    public function update_password(){
        $data = array(
            'modificado_por'     => $this->input->post('modificado_por'),
            'fecha_modificacion' => $this->input->post('fecha_modificacion')
        );

        if(!empty($this->input->post('password'))){
            $data['password'] = md5($this->input->post('password'));
        }

        $this->db->where('usuario_id', $this->input->post('usuario_id'));
        $this->db->update('usuarios', $data);        

        return 'El usuario se actualizo correctamente.';    
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

        $this->db->group_by('u.usuario_id');        
        $this->db->join('usuario_departamentos ud', 'ud.usuario_id = u.usuario_id', 'left');
        $this->db->join('departamentos d', 'd.departamento_id = ud.departamento_id', 'left');
        $this->db->join('perfiles p', 'p.perfil_id = u.perfil_id', 'left');
        $this->db->from('usuarios u');
        $this->db->select('u.*, p.perfil');
        $resp = $this->db->get();
        return $resp->result_array();
    }

}
