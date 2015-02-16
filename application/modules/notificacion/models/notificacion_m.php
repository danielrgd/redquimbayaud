<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notificacion_m extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}
	
	function insertar_notificacion($datos_notificacion){
//		var_dump($datos_notificacion); exit();
		$conteo = $this->db->db->query("select count(*) from usuarios_notificaciones"); 
		$datos_notificacion['id_notificacion']=$conteo[0]['count']+1;
		
  		$this->db->db->query(
            "INSERT INTO usuarios_notificaciones (\"".implode("\",\"",array_keys($datos_notificacion))."\") VALUES (:".implode(",:",array_keys($datos_notificacion)).");",
            $datos_notificacion
        );
		
		//reinsertar fecha
		$this->db->db->query(
            "UPDATE usuarios_notificaciones SET fecha = '".$datos_notificacion['fecha']."' WHERE id_notificacion=".$datos_notificacion['id_notificacion']
        );
	}
	
	function insertar_relacion_asociacion($datos_asociacion){
//		var_dump($datos_asociacion); exit();
		
/* 		INSERT INTO usuarios_proyectos (id_usuario,id_proyecto,rol,nombre_proyecto,fecha_inicio,fecha_fin)
		VALUES (1077084815,1,'Desarrollador','prueba 1','2014-05-27','2015-03-25');

		INSERT INTO proyectos_usuarios (id_proyecto,id_usuario,rol,nombre_completo,fecha_inicio,fecha_fin)
		VALUES (1,1077084815,'Desarrollador','Andrés Ricardo Campos','2014-05-27','2015-03-25'); 

		UPDATE usuarios_proyectos SET es_propietario = true
		WHERE id_proyecto=1 AND id_usuario=1;

		UPDATE proyectos_usuarios SET es_propietario = true
		WHERE id_proyecto=1 AND id_usuario=1;
*/

		//Insertar relación usuarios_proyectos
   		$this->db->db->query(
            "INSERT INTO usuarios_proyectos (id_usuario,id_proyecto,rol,nombre_proyecto,fecha_inicio,fecha_fin)
			VALUES (".$datos_asociacion['id_usuario'].",".$datos_asociacion['id_proyecto'].",'".$datos_asociacion['rol']."','".$datos_asociacion['nombre_proyecto']."','".$datos_asociacion['fecha_inicio']."','".$datos_asociacion['fecha_fin']."')"
        ); 
		
		//Insertar relación proyectos_usuarios
   		$this->db->db->query(
            "INSERT INTO proyectos_usuarios (id_proyecto,id_usuario,rol,nombre_completo,fecha_inicio,fecha_fin)
			VALUES (".$datos_asociacion['id_proyecto'].",".$datos_asociacion['id_usuario'].",'".$datos_asociacion['rol']."','".$datos_asociacion['nombre_completo']."','".$datos_asociacion['fecha_inicio']."','".$datos_asociacion['fecha_fin']."')"
        );
		 
		//Insertar propietario
		if($datos_asociacion['es_propietario']){
 			$this->db->db->query(
				"UPDATE usuarios_proyectos SET es_propietario = true
				WHERE id_proyecto=".$datos_asociacion['id_proyecto']." AND id_usuario=".$datos_asociacion['id_usuario']
			);
			
			$this->db->db->query(
				"UPDATE proyectos_usuarios SET es_propietario = true
				WHERE id_proyecto=".$datos_asociacion['id_proyecto']." AND id_usuario=".$datos_asociacion['id_usuario']
			);
		}

	}

	function consultar_notificaciones($id_usuario){

		$resultado = $this->db->db->query("select * from usuarios_notificaciones where id_usuario_to contains ".$id_usuario.";"); 
		
		return $resultado;
	}
	
	function marcar_notificacion($notificacion){

		 $this->db->db->query(
            "UPDATE usuarios_notificaciones SET leida = true WHERE id_notificacion=".$notificacion['id_notificacion'].";"
        ); 
	}

}