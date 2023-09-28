<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class General_model extends CI_Model{

    public function construct() {
        parent::__construct();        
    }

    public function eliminar_registro(){
        $this->db->where(''.$this->input->post('campo').'', $this->input->post('id'));
        $this->db->from(''.$this->input->post('table').'');
        $this->db->select('*');
        $resp = $this->db->get();
        $resp = $resp->result_array();

        if(!empty($resp[0]['cliente_id'])){
        	return false;
        }else{
			$this->db->where(''.$this->input->post('campo').'', $this->input->post('id'));
			$this->db->delete(''.$this->input->post('table').'');
			return true;
        }
    }

    public function get_total_notificaciones_solicitudes(){
        $session_usuario = $this->session->userdata('_USER_APP_');

        $this->db->where('sc.creado_por !=', $session_usuario['usuario_id']);
        $this->db->where('sc.visto', 0);
        $this->db->where('s.creado_por', $session_usuario['usuario_id']);
        $this->db->join('solicitud_comentarios sc', 'sc.solicitud_id = s.solicitud_id', 'left');
        $this->db->from('solicitudes s');
        $this->db->select('COUNT(*) total');
        $solicitudes = $this->db->get();
        $solicitudes = $solicitudes->result_array();

        $this->db->where('sc.creado_por !=', $session_usuario['usuario_id']);
        $this->db->where('sc.visto', 0);
        $this->db->where('s.usuario_asignado_id', $session_usuario['usuario_id']);
        $this->db->join('solicitud_comentarios sc', 'sc.solicitud_id = s.solicitud_id', 'left');
        $this->db->from('solicitudes s');
        $this->db->select('COUNT(*) total');
        $asignaciones = $this->db->get();
        $asignaciones = $asignaciones->result_array();

        $this->db->where('s.estatus_id', 0);
        $this->db->where('oas.usuario_autoriza_id', $session_usuario['usuario_id']);
        $this->db->join('opcion_servicios os', 'os.opcion_servicio_id = s.opcion_servicio_id', 'left');
        $this->db->join('opcion_autoriza_servicios oas', 'oas.opcion_servicio_id = os.opcion_servicio_id', 'left');
        $this->db->join('usuarios u', 'u.usuario_id = s.creado_por', 'left');
        $this->db->from('solicitudes s');
        $this->db->select('COUNT(*) total');
        $autorizaciones = $this->db->get();
        $autorizaciones = $autorizaciones->result_array();

        return $solicitudes[0]['total'] + $asignaciones[0]['total'] + $autorizaciones[0]['total'];
    }

    public function get_notificaciones(){
        $resp = array();
        $session_usuario = $this->session->userdata('_USER_APP_');

        $this->db->order_by("sc.comentario_id", "Desc");
        $this->db->where('sc.creado_por !=', $session_usuario['usuario_id']);
        $this->db->where('sc.visto', 0);
        $this->db->where('s.creado_por', $session_usuario['usuario_id']);
        $this->db->join('solicitud_comentarios sc', 'sc.solicitud_id = s.solicitud_id', 'left');
        $this->db->join('usuarios u', 'u.usuario_id = sc.creado_por', 'left');
        $this->db->from('solicitudes s');
        $this->db->select('sc.*, s.creado_por solicitante_id, s.usuario_asignado_id responsable_id,  u.nombre, u.apellido');
        $resp['solicitudes'] = $this->db->get();
        $resp['solicitudes'] = $resp['solicitudes']->result_array();

        $this->db->order_by("sc.comentario_id", "Desc");
        $this->db->where('sc.creado_por !=', $session_usuario['usuario_id']);
        $this->db->where('sc.visto', 0);
        $this->db->where('s.usuario_asignado_id', $session_usuario['usuario_id']);
        $this->db->join('solicitud_comentarios sc', 'sc.solicitud_id = s.solicitud_id', 'left');
        $this->db->join('usuarios u', 'u.usuario_id = sc.creado_por', 'left');
        $this->db->from('solicitudes s');
        $this->db->select('sc.comentario_id, sc.solicitud_id, sc.comentario, sc.fecha_creacion, s.creado_por solicitante_id, s.usuario_asignado_id responsable_id,  u.nombre, u.apellido');
        $resp['asignaciones'] = $this->db->get();
        $resp['asignaciones'] = $resp['asignaciones']->result_array();

        $this->db->order_by("s.solicitud_id", "Asc");
        $this->db->where('s.estatus_id', 0);
        $this->db->where('oas.usuario_autoriza_id', $session_usuario['usuario_id']);
        $this->db->join('opcion_servicios os', 'os.opcion_servicio_id = s.opcion_servicio_id', 'left');
        $this->db->join('opcion_autoriza_servicios oas', 'oas.opcion_servicio_id = os.opcion_servicio_id', 'left');
        $this->db->join('usuarios u', 'u.usuario_id = s.creado_por', 'left');
        $this->db->from('solicitudes s');
        $this->db->select('s.solicitud_id, s.fecha_creacion, s.creado_por solicitante_id, s.usuario_asignado_id responsable_id,  u.nombre, u.apellido');
        $resp['autorizaciones'] = $this->db->get();
        $resp['autorizaciones'] = $resp['autorizaciones']->result_array();

        $notificaciones = array();

        $i = 0;

        foreach ($resp['solicitudes'] as $s) {
            $notificaciones['notificaciones']['tipo'][$i] =  'Solicitud';
            $notificaciones['notificaciones']['controller'][$i] =  'Solicitudes';
            $notificaciones['notificaciones']['comentario_id'][$i] =  $s['comentario_id'];
            $notificaciones['notificaciones']['solicitud_id'][$i] =  $s['solicitud_id'];
            $notificaciones['notificaciones']['usuario'][$i] =  $s['nombre'].' '.$s['apellido'];
            $notificaciones['notificaciones']['fecha_creacion'][$i] =  $s['fecha_creacion'];
            $notificaciones['notificaciones']['comentario'][$i] =  $s['comentario'];
            $i++;
        }

        foreach ($resp['asignaciones'] as $a) {
            $notificaciones['notificaciones']['tipo'][$i] =  'Asignacion';
            $notificaciones['notificaciones']['controller'][$i] =  'Asignaciones';
            $notificaciones['notificaciones']['comentario_id'][$i] =  $a['comentario_id'];
            $notificaciones['notificaciones']['solicitud_id'][$i] =  $a['solicitud_id'];
            $notificaciones['notificaciones']['usuario'][$i] =  $a['nombre'].' '.$a['apellido'];
            $notificaciones['notificaciones']['fecha_creacion'][$i] =  $a['fecha_creacion'];
            $notificaciones['notificaciones']['comentario'][$i] =  $a['comentario'];
            $i++;
        }

        foreach ($resp['autorizaciones'] as $a) {
            $notificaciones['notificaciones']['tipo'][$i] =  'Autorización';
            $notificaciones['notificaciones']['controller'][$i] =  'Asignaciones';
            $notificaciones['notificaciones']['comentario_id'][$i] =  0;
            $notificaciones['notificaciones']['solicitud_id'][$i] =  $a['solicitud_id'];
            $notificaciones['notificaciones']['usuario'][$i] =  $a['nombre'].' '.$a['apellido'];
            $notificaciones['notificaciones']['fecha_creacion'][$i] =  $a['fecha_creacion'];
            $notificaciones['notificaciones']['comentario'][$i] =  'Se creo una solicitud que requiere autorización.';
            $i++;
        }

        return $notificaciones;
    }

}
