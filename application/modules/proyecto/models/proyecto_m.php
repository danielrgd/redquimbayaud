<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proyecto_m extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}
	
	function consultar_proyecto($proyecto){

		$resultado = $this->db->db->query("select * from proyectos where id_proyecto =".$proyecto.";"); 
	
		return $resultado;
	
	}
	
	function consultar_comentarios($proyecto){
	
		$resultado = $this->db->db->query("select * from usuarios_comentarios_proyectos WHERE id_proyecto=".$proyecto." ALLOW FILTERING;");
		return $resultado;
	
	}
	
	function consultar_calificacion_hecha($id_usuario_from, $id_proyecto){
	
		$resultado = $this->db->db->query("select calificacion from usuarios_calificaciones_proyectos WHERE id_usuario_from=".$id_usuario_from." AND id_proyecto=".$id_proyecto);
		if(isset($resultado[0]))
			return $resultado[0]['calificacion'];
		return 0;
	
	}

	function consultar_calificacion_promedio($id_proyecto){
	
		$total_calificaciones=0;
		$cantidad_calificaciones=$this->db->db->query("select count(*) from usuarios_calificaciones_proyectos WHERE id_proyecto=".$id_proyecto);
		$cantidad_calificaciones=$cantidad_calificaciones[0]['count'];
 		if($cantidad_calificaciones==0)
			return 0; 
		$calificaciones=$this->db->db->query("select calificacion from usuarios_calificaciones_proyectos WHERE id_proyecto=".$id_proyecto);
		foreach($calificaciones as $calificaciona){
			$total_calificaciones=$total_calificaciones+$calificaciona['calificacion'];
		} 
		$promedio_actual=$total_calificaciones/$cantidad_calificaciones;
		
		return $promedio_actual;
	
	}

	function consultar_proyectos_mejor_valorados(){
	
		$resultado = $this->db->db->query("SELECT * FROM top_proyectos where criterio='calificacion' limit 10;"); 
		return $resultado;
	
	}
	
	function consultar_proyectos_mas_comentados(){

		$resultado = $this->db->db->query("SELECT * FROM top_proyectos where criterio='comentarios' limit 10;"); 
		return $resultado;
	
	}
	
	function buscar_proyectos_por_palabras_clave($palabra_clave){
		$resultado = $this->db->db->query("select id_proyecto, nombre_proyecto from proyectos WHERE keywords contains '".$palabra_clave."';"); 				
		return $resultado;
	}
	
	function insertar_proyecto($datos_proyecto){

		$conteo = $this->db->db->query("select count(*) from proyectos"); 
		$datos_proyecto['id_proyecto'] = $conteo[0]['count']+1;
		
		$id_creador=$datos_proyecto['id_creador'];
		$nombre_completo_creador=$datos_proyecto['nombre_completo_creador'];
		
		//Conflicto nombres fechas
		$datos_proyecto['fecha_inicio']=$datos_proyecto['fecha_inicio_p'];
		$datos_proyecto['fecha_fin']=$datos_proyecto['fecha_fin_p'];


		//Datos que no hacen parte de la tabla proyectos 
		unset($datos_proyecto['id_creador']);
		unset($datos_proyecto['nombre_completo_creador']);
		unset($datos_proyecto['integrantes']);
		unset($datos_proyecto['id_usuario_integrantes']);
		unset($datos_proyecto['roles']);
		unset($datos_proyecto['fecha_inicio_p']);
		unset($datos_proyecto['fecha_fin_p']);
		unset($datos_proyecto['propietario']);
		
		$this->db->db->query(
            "INSERT INTO proyectos (\"".implode("\",\"",array_keys($datos_proyecto))."\") VALUES (:".implode(",:",array_keys($datos_proyecto)).");",
            $datos_proyecto
        );
		
		//Conflicto BD- Reinsertar fechas
		$this->db->db->query(
            "UPDATE proyectos SET fecha_inicio = '".$datos_proyecto['fecha_inicio']."', fecha_fin= '".$datos_proyecto['fecha_fin']."' WHERE id_proyecto=".$datos_proyecto['id_proyecto']
        );
		 
		//Insertar primer propietario/creador
		$this->db->db->query(
            "INSERT INTO usuarios_proyectos (id_usuario,id_proyecto,rol,nombre_proyecto,es_propietario,fecha_inicio,fecha_fin)
		VALUES (".$id_creador.",".$datos_proyecto['id_proyecto'].",'Owner','".$datos_proyecto['nombre_proyecto']."',true,dateof(now()),'".$datos_proyecto['fecha_fin']."')"
        );
		
		$this->db->db->query(
            "INSERT INTO proyectos_usuarios (id_proyecto,id_usuario,rol,nombre_completo,es_propietario,fecha_inicio,fecha_fin)
		VALUES (".$datos_proyecto['id_proyecto'].",".$id_creador.",'Owner','".$nombre_completo_creador."',true,dateof(now()),'2020-12-31')"
        );
		
		
		//Insertar temas de interés
		foreach ($datos_proyecto['temas_interes'] as $tema){
			$this->db->db->query("UPDATE temas_interes SET asociados[".$datos_proyecto['id_proyecto']."]='".$datos_proyecto['nombre_proyecto']."' WHERE descripcion='".$tema."' AND tipo='proyecto'");
		}
		return $datos_proyecto['id_proyecto'];
	
	}
	
	function insertar_comentario_proyecto($usuario_from,$proyecto_to,$comentario){
				
		//Insertar comentario
 		$this->db->db->query(
            "INSERT INTO usuarios_comentarios_proyectos (id_usuario_from, nombre_completo_from, ruta_foto, id_proyecto, fecha, comentario)
			VALUES (".$usuario_from['id_usuario'].",'".$usuario_from['nombre_completo']."','".$usuario_from['ruta_foto_perfil']."',".$proyecto_to['id_proyecto'].",dateof(now()),'".$comentario."');"
		);
		 
		//Actualizar TopProyectos
			//Consultar cantidad actual
			$cantidad_comentarios=$this->db->db->query("select COUNT(*) from usuarios_comentarios_proyectos WHERE id_proyecto=".$proyecto_to['id_proyecto']." ALLOW FILTERING;");
			$cantidad_comentarios_antes=$cantidad_comentarios[0]['count']-1;
			$cantidad_comentarios=$cantidad_comentarios_antes+1;//LOL
			//Borrar registro actual del top
			$this->db->db->query("DELETE FROM top_proyectos WHERE criterio='comentarios' AND valor = ".$cantidad_comentarios_antes ." AND id_proyecto = ".$proyecto_to['id_proyecto'].";");
			//Insertar registro actual
			$this->db->db->query("insert into top_proyectos (criterio, valor, id_proyecto, nombre_proyecto) values ('comentarios',".$cantidad_comentarios.",".$proyecto_to['id_proyecto'].",'".$proyecto_to['nombre_proyecto']."');");
		//Fin TopProyectos
		return true;
	}

	function actualizar_calificacion_proyecto($id_usuario_from,$proyecto_to,$calificacion){
		
		//calcular promedio actual
		$promedio_actual=$this->consultar_calificacion_promedio($proyecto_to['id_proyecto']);
		//actualizar calificacion
		$this->db->db->query("UPDATE usuarios_calificaciones_proyectos SET calificacion = ".$calificacion." WHERE id_usuario_from=".$id_usuario_from." AND id_proyecto=".$proyecto_to['id_proyecto']);
		//calcular promedio nuevo
		$promedio_nuevo=$this->consultar_calificacion_promedio($proyecto_to['id_proyecto']);
		
		//actualizar TopUsuarios
		$this->db->db->query("DELETE FROM top_proyectos WHERE criterio='calificacion' AND valor = ".$promedio_actual." AND id_proyecto = ".$proyecto_to['id_proyecto']);
		$this->db->db->query("insert into top_proyectos (criterio, valor, id_proyecto, nombre_proyecto) values ('calificacion',".$promedio_nuevo.",".$proyecto_to['id_proyecto'].",'".$proyecto_to['nombre_proyecto']."')");

		return true;
	}
	
	function actualizar_proyecto($id_proyecto,$datos_proyecto){
	
		//Conflicto nombres fechas
		$datos_proyecto['fecha_inicio']=$datos_proyecto['fecha_inicio_p'];
		$datos_proyecto['fecha_fin']=$datos_proyecto['fecha_fin_p'];


		//Datos que no hacen parte de la tabla proyectos 
		unset($datos_proyecto['id_creador']);
		unset($datos_proyecto['nombre_completo_creador']);
		unset($datos_proyecto['integrantes']);
		unset($datos_proyecto['id_usuario_integrantes']);
		unset($datos_proyecto['roles']);
		unset($datos_proyecto['fecha_inicio_p']);
		unset($datos_proyecto['fecha_fin_p']);
		unset($datos_proyecto['propietario']);
		
		$arreglo_llaves = array();
		foreach($datos_proyecto as $key => $field ){
			
			array_push($arreglo_llaves,$key." = :".$key);
			
		}
		//Tomar anteriores Temas de interés para eliminar en temas_interes
		$array_temas_interes_anteriores=$this->db->db->query("select temas_interes from proyectos where id_proyecto=".$id_proyecto);
		//var_dump($datos_proyecto); exit();
		$this->db->db->query(
            "UPDATE proyectos SET ".implode(",",$arreglo_llaves)." where id_proyecto = ".$id_proyecto,
			$datos_proyecto
        );
		
 		//Conflicto BD- Reinsertar fechas
		$this->db->db->query(
            "UPDATE proyectos SET fecha_inicio = '".$datos_proyecto['fecha_inicio']."', fecha_fin= '".$datos_proyecto['fecha_fin']."' WHERE id_proyecto=".$id_proyecto
        );
		 

		//actualizar temas de interes
			//Borrar existentes
			foreach($array_temas_interes_anteriores[0]['temas_interes'] as $tema){
				$this->db->db->query("DELETE asociados[".$id_proyecto."] FROM temas_interes WHERE descripcion='".$tema."' AND tipo='proyecto';");
			}
			
			//insertar nuevos
			foreach ($datos_proyecto['temas_interes'] as $tema){
				$this->db->db->query("UPDATE temas_interes SET asociados[".$id_proyecto."]='".$datos_proyecto['nombre_proyecto']."' WHERE descripcion='".$tema."' AND tipo='proyecto'");
			}
		
		return true;
	}
	
	function insertar_seguimiento($id_proyecto, $datos){
			
		$conteo = $this->db->db->query("select count(*) from proyectos_seguimientos"); 
		$datos['id_seguimiento'] = $conteo[0]['count']+1;
		
		//Se inserta el seguimiento
		$this->db->db->query(
            "INSERT INTO proyectos_seguimientos (\"".implode("\",\"",array_keys($datos))."\") VALUES (:".implode(",:",array_keys($datos)).");",
            $datos
        ); 
		
		//Se inserta la información del seguimiento en el proyecto
		$this->db->db->query("UPDATE proyectos SET seguimientos[".$datos['id_seguimiento']."]='".$datos['descripcion']."' WHERE id_proyecto=".$id_proyecto.";");
	
	}	
	
	function insertar_contabilidad($id_proyecto, $datos){
			
		$conteo = $this->db->db->query("select count(*) from proyectos_contabilidad"); 
		$datos['id_contabilidad'] = $conteo[0]['count']+1;

		//Se inserta la contabilidad
		$this->db->db->query(
            "INSERT INTO proyectos_contabilidad (\"".implode("\",\"",array_keys($datos))."\") VALUES (:".implode(",:",array_keys($datos)).");",
            $datos
        ); 
	}	
	
	function consultar_seguimientos($id_proyecto){
		
		$resultado = $this->db->db->query("select * from proyectos_seguimientos WHERE id_proyecto =".$id_proyecto.";"); 				
		
		return $resultado;
	}
		
	function consultar_contabilidad($id_proyecto){
		
		$resultado = $this->db->db->query("select * from proyectos_contabilidad WHERE id_proyecto =".$id_proyecto.";"); 				
		
		return $resultado;
	}
	
	function consultar_usuarios_proyecto($id_proyecto){
		
		$resultado['propietario'] = $this->db->db->query("SELECT * from proyectos_usuarios WHERE id_proyecto=".$id_proyecto." AND es_propietario=true;");
		$resultado['integrante'] = $this->db->db->query("SELECT * from proyectos_usuarios where id_proyecto = ".$id_proyecto); 
		
		return $resultado;
		
	}
	
}