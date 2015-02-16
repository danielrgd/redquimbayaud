<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_m extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}
	
	function consultar_usuario($usuario){
	
		$resultado = $this->db->db->query("select * from usuarios where id_usuario =".$usuario);
		return $resultado;
	
	}
	
	function consultar_usuarios(){
	
		$resultado = $this->db->db->query("select * from usuarios ");
		return $resultado;
	
	}
	
	function consultar_proyectos($id_usuario){
	
		$resultado = array();
		
//		$resultado['propietario'] = $this->db->db->query("select * from proyectos where propietarios contains key ".$id_usuario.";");
//		$resultado['integrante'] = $this->db->db->query("select * from proyectos where integrantes contains key ".$id_usuario.";"); 
		
		$resultado['propietario'] = $this->db->db->query("SELECT id_proyecto, nombre_proyecto, rol, fecha_inicio, fecha_fin from usuarios_proyectos WHERE id_usuario=".$id_usuario." AND es_propietario=true;");
		$resultado['integrante'] = $this->db->db->query("select id_proyecto, nombre_proyecto, rol, fecha_inicio, fecha_fin from usuarios_proyectos where id_usuario = ".$id_usuario); 
		
				
		return $resultado;
	
	}

	function consultar_comentarios($usuario){
	
		$resultado = $this->db->db->query("select * from usuarios_comentarios_usuarios WHERE id_usuario_to=".$usuario." ALLOW FILTERING;");
		return $resultado;
	
	}
	
	function consultar_calificacion_hecha($id_usuario_from, $id_usuario_to){
	
		$resultado = $this->db->db->query("select calificacion from usuarios_calificaciones_usuarios WHERE id_usuario_from=".$id_usuario_from." AND id_usuario_to=".$id_usuario_to);
		if(isset($resultado[0]))
			return $resultado[0]['calificacion'];
		return 0;
	
	}

	function consultar_calificacion_promedio($id_usuario_to){
	
		$total_calificaciones=0;
		$cantidad_calificaciones=$this->db->db->query("select count(*) from usuarios_calificaciones_usuarios WHERE id_usuario_to=".$id_usuario_to);
		$cantidad_calificaciones=$cantidad_calificaciones[0]['count'];
 		if($cantidad_calificaciones==0)
			return 0; 
		$calificaciones=$this->db->db->query("select calificacion from usuarios_calificaciones_usuarios WHERE id_usuario_to=".$id_usuario_to);
		foreach($calificaciones as $calificaciona){
			$total_calificaciones=$total_calificaciones+$calificaciona['calificacion'];
		} 
		$promedio_actual=$total_calificaciones/$cantidad_calificaciones;
		
		return $promedio_actual;
	
	}

	function consultar_usuarios_mejor_valorados(){

		$resultado = $this->db->db->query("SELECT * FROM top_usuarios where criterio='calificacion' limit 10;"); 				
		return $resultado;
	
	}
	
	function consultar_usuarios_mas_comentados(){
	
		$resultado = $this->db->db->query("SELECT * FROM top_usuarios where criterio='comentarios' limit 10;"); 				
		return $resultado;
	
	}
	
	function insertar_usuario($datos_personales,$llave_validacion){
		
		$datos_personales['llave_validacion'] = $llave_validacion;
			
 		$this->db->db->query(
            "INSERT INTO usuarios (\"".implode("\",\"",array_keys($datos_personales))."\") VALUES (:".implode(",:",array_keys($datos_personales)).");",
            $datos_personales
        );
		
		//Conflicto BD- Reinsertar fechas
		$this->db->db->query(
            "UPDATE usuarios SET fecha_nacimiento = '".$datos_personales['fecha_nacimiento']."' WHERE id_usuario=".$datos_personales['id_usuario']
        );

		//Insertar temas de interés
		$datos=$datos_personales;
		$usuario=$datos_personales['id_usuario'];
		foreach ($datos['temas_interes'] as $tema){
			$this->db->db->query("UPDATE temas_interes SET asociados[".$usuario."]='".$datos['nombre_completo']."' WHERE descripcion='".$tema."' AND tipo='usuario'");
		}
		//$result = $this->db->db->applyBatch(); 
		 
		return true;
	
	}
	//TODO revisar si se usa el mismo metodo para actualizar perfil y cuenta
	function actualizar_cuenta($usuario,$datos){
			
		$arreglo_llaves = array();
		foreach($datos as $key => $field ){
			
			array_push($arreglo_llaves,$key." = :".$key);
			
		}
		
		//Tomar anteriores Temas de interés para eliminar en temas_interes
		$array_temas_interes_anteriores=$this->db->db->query("select temas_interes from usuarios where id_usuario=".$usuario);
		
		$this->db->db->query(
            "UPDATE usuarios SET ".implode(",",$arreglo_llaves)." where id_usuario = ".$usuario,
			$datos
        );
		
		//Conflicto BD- Reinsertar fechas
		$this->db->db->query(
            "UPDATE usuarios SET fecha_nacimiento = '".$datos['fecha_nacimiento']."' WHERE id_usuario=".$usuario
        );
		
		//actualizar temas de interes
			//Borrar existentes
			foreach($array_temas_interes_anteriores[0]['temas_interes'] as $tema){
				$this->db->db->query("DELETE asociados[".$usuario ."] FROM temas_interes WHERE descripcion='".$tema."' AND tipo='usuario';");
			}
			
			//insertar nuevos
			foreach ($datos['temas_interes'] as $tema){
				$this->db->db->query("UPDATE temas_interes SET asociados[".$usuario."]='".$datos['nombre_completo']."' WHERE descripcion='".$tema."' AND tipo='usuario'");
			}
		
		return true;
	
	}
	
	function actualizar_estado($usuario){
	
		$resultado = $this->db->db->query("UPDATE usuarios SET estado_cuenta ='Activa' where id_usuario =".$usuario);
		return $resultado;
	
	}
	
	function buscar_usuarios_por_palabras_clave($palabra_clave){
		$resultado = $this->db->db->query("select id_usuario, nombre_completo from usuarios WHERE keywords contains '".$palabra_clave."';"); 				
		return $resultado;
	}
	
	function insertar_comentario_usuario($usuario_from,$usuario_to,$comentario){
				
		//Insertar comentario
 		$this->db->db->query(
            "INSERT INTO usuarios_comentarios_usuarios (id_usuario_from, nombre_completo_from, ruta_foto, id_usuario_to, fecha, comentario)
			VALUES (".$usuario_from['id_usuario'].",'".$usuario_from['nombre_completo']."','".$usuario_from['ruta_foto_perfil']."',".$usuario_to['id_usuario'].",dateof(now()),'".$comentario."');"
		);
		 
		//Actualizar TopUsuarios
			//Consultar cantidad actual
			$cantidad_comentarios=$this->db->db->query("select COUNT(*) from usuarios_comentarios_usuarios WHERE id_usuario_to=".$usuario_to['id_usuario']." ALLOW FILTERING;");
			$cantidad_comentarios_antes=$cantidad_comentarios[0]['count']-1;
			$cantidad_comentarios=$cantidad_comentarios_antes+1;//LOL
			//Borrar registro actual del top
			$this->db->db->query("DELETE FROM top_usuarios WHERE criterio='comentarios' AND valor = ".$cantidad_comentarios_antes ." AND id_usuario = ".$usuario_to['id_usuario'].";");
			//Insertar registro actual
			$this->db->db->query("insert into top_usuarios (criterio, valor, id_usuario, nombre_completo) values ('comentarios',".$cantidad_comentarios.",".$usuario_to['id_usuario'].",'".$usuario_to['nombre_completo']."');");
		//Fin TopUsuarios
		return true;
	}
		
	function actualizar_calificacion_usuario($id_usuario_from,$usuario_to,$calificacion){
		
		//calcular promedio actual
		$promedio_actual=$this->consultar_calificacion_promedio($usuario_to['id_usuario']);
		//actualizar calificacion
		$this->db->db->query("UPDATE usuarios_calificaciones_usuarios SET calificacion = ".$calificacion." WHERE id_usuario_from=".$id_usuario_from." AND id_usuario_to=".$usuario_to['id_usuario']);
		//calcular promedio nuevo
		$promedio_nuevo=$this->consultar_calificacion_promedio($usuario_to['id_usuario']);
		
		//actualizar TopUsuarios
		$this->db->db->query("DELETE FROM top_usuarios WHERE criterio='calificacion' AND valor = ".$promedio_actual." AND id_usuario = ".$usuario_to['id_usuario']);
		$this->db->db->query("insert into top_usuarios (criterio, valor, id_usuario, nombre_completo) values ('calificacion',".$promedio_nuevo.",".$usuario_to['id_usuario'].",'".$usuario_to['nombre_completo']."')");

		return true;
	}
	
}