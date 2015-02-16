<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proyecto_c extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('proyecto_m');
	}
	
	function _consultar_proyectos_mejor_valorados(){
		$resultado = $this->proyecto_m->consultar_proyectos_mejor_valorados();
		return $resultado;
	}
	
	function _consultar_proyectos_mas_comentados(){
		$resultado = $this->proyecto_m->consultar_proyectos_mas_comentados();
		return $resultado;
	}

	function _buscar_proyectos_por_palabras_clave($palabras_clave){
		$palabras_clave_array=explode(" ",$palabras_clave);
		$resultado=array();
		foreach ($palabras_clave_array as $palabra){
			$resultado_parcial=$this->proyecto_m->buscar_proyectos_por_palabras_clave(strtolower($palabra));
			$resultado=array_merge($resultado, $resultado_parcial);
		}
		
		$resultado=$this->eliminar_duplicados($resultado, 'id_proyecto');

		return $resultado;
	}
	
	private function eliminar_duplicados($array, $campo){
		foreach ($array as $sub){
			$cmp[] = $sub[$campo];
		}
		$unique = array_unique($cmp);
		foreach ($unique as $k => $campo){
			$resultado[] = $array[$k];
		}
		return $resultado;
	}

	function _comentar_proyecto($proyecto_to,$comentario){
		
		$usuario_from= $this->session->userdata('id_usuario');
		
		$datos_usuario_from = modules::run('usuario/usuario_c/_consultar_usuario',$usuario_from);
		$datos_proyecto_to = $this->proyecto_m->consultar_proyecto($proyecto_to);
		
		$resultado = $this->proyecto_m->insertar_comentario_proyecto($datos_usuario_from[0],$datos_proyecto_to[0],$comentario);
		
		//Creacion de la notificaion
		$mensaje = "Nuevo comentario de ".$datos_usuario_from[0]['nombre_completo']." al proyecto ".$datos_proyecto_to[0]['nombre_proyecto'].": ".$comentario;
		modules::run('notificacion/notificacion_c/_crear_notificacion_proyecto',$datos_proyecto_to[0]['id_proyecto'],$datos_proyecto_to[0]['nombre_proyecto'],$mensaje,$datos_usuario_from[0]['id_usuario']);

		return $resultado;
		
	}
	
	function _calificar_proyecto($proyecto_to,$calificacion){
		
		$id_usuario_from= $this->session->userdata('id_usuario');
		$datos_usuario_from = modules::run('usuario/usuario_c/_consultar_usuario',$usuario_from);

		$datos_proyecto_to = $this->proyecto_m->consultar_proyecto($proyecto_to);

		$resultado = $this->proyecto_m->actualizar_calificacion_proyecto($id_usuario_from,$datos_proyecto_to[0],$calificacion);
	
		//Creacion de la notificacion
		$mensaje = "El usuario ".$datos_usuario_from[0]['nombre_completo']." ha calificado el proyecto ".$datos_proyecto_to[0]['nombre_proyecto'].": ".$calificacion;
		modules::run('notificacion/notificacion_c/_crear_notificacion_proyecto',$datos_proyecto_to[0]['id_proyecto'],$datos_proyecto_to[0]['nombre_proyecto'],$mensaje,$datos_usuario_from[0]['id_usuario']);

		return $resultado;
		
	}
	
	function _crear_proyecto($datos_proyecto){

		$keywords =array();
		$keywords_segmentado =array();
		$sesion = $this->session->all_userdata();
		$datos_proyecto['temas_interes'] = explode("|", $datos_proyecto['temas_interes']);
		
		//Creador inicia como único propietario
		$datos_proyecto['id_creador']=$sesion['id_usuario'];
		$datos_proyecto['nombre_completo_creador']=$sesion['nombre_completo'];
		
		//Creación palabras clave
		array_push($keywords, $datos_proyecto['nombre_proyecto'] );
		$keywords = array_merge( $keywords, $datos_proyecto['temas_interes']);
		
		if(isset($datos_proyecto['descripcion_general'] )) array_push($keywords, $datos_proyecto['descripcion_general']);
		if(isset($datos_proyecto['objetivo'] )) array_push($keywords, $datos_proyecto['objetivo']);
		if(isset($datos_proyecto['sector'] ))array_push($keywords, $datos_proyecto['sector']);
		if(isset($datos_proyecto['servicios_productos'] )) array_push($keywords, $datos_proyecto['servicios_productos']);
		if(isset($datos_proyecto['tipo_proyecto'] ))array_push($keywords, $datos_proyecto['tipo_proyecto']);
		if(isset($datos_proyecto['fuente_financiacion'] ))array_push($keywords, $datos_proyecto['fuente_financiacion']);
		if(isset($datos_proyecto['poblacion_objetivo'] ))array_push($keywords, $datos_proyecto['poblacion_objetivo']);
		if(isset($datos_proyecto['institucion'] ))array_push($keywords, $datos_proyecto['institucion']);
		if(isset($datos_proyecto['pais'] ))array_push($keywords, $datos_proyecto['pais']);
		if(isset($datos_proyecto['ciudad'] ))array_push($keywords, $datos_proyecto['ciudad']);$datos_proyecto;
		if(isset($datos_proyecto['adicionales'] ))array_push($keywords, array_keys($datos_proyecto['adicionales']),array_values($datos_proyecto['adicionales']));
	
		foreach($keywords as $keyword){

			$keywords_segmentado =array_merge($keywords_segmentado, explode(" ",$keyword));
		}
		$datos_proyecto['keywords'] = array_map('strtolower',$keywords_segmentado);

		//Creacion del proyecto
		$proyecto['id_proyecto'] = $this->proyecto_m->insertar_proyecto($datos_proyecto);
		$proyecto['nombre_proyecto'] = $datos_proyecto['nombre_proyecto'];

		//no hay usuarios por asociar
		if(in_array("",array_values($datos_proyecto['id_usuario_integrantes']))){
			return array('status'=>1, 'msg'=>"El proyecto ha sido creado exitosamente");
			//FIXME cuando se ingresa un solo usuario y luego se borra el campo, persiste el id_usuario
		}
		else
			{
			$num_integrantes=count($datos_proyecto['id_usuario_integrantes']);			
			
			//re-llenar propietarios
			for($i=0;$i<$num_integrantes;$i++){
				if(in_array($datos_proyecto['id_usuario_integrantes'][$i], $datos_proyecto['propietario'])){
					$es_propietario[$i]=true;
				}
				else{
					$es_propietario[$i]=false;
				}
			}
			
			
			//para cada id_usuario crear asociación
			for($i=0;$i<$num_integrantes;$i++){
				
				$datos_asociacion=array();

				$datos_asociacion['id_usuario']=$datos_proyecto['id_usuario_integrantes'][$i];
				$datos_asociacion['nombre_completo']=$datos_proyecto['integrantes'][$i];
				$datos_asociacion['id_proyecto']=$proyecto['id_proyecto'];
				$datos_asociacion['nombre_proyecto']=$proyecto['nombre_proyecto'];
				$datos_asociacion['rol']=$datos_proyecto['roles'][$i];
				$datos_asociacion['es_propietario']=$es_propietario[$i];
				$datos_asociacion['fecha_inicio']=$datos_proyecto['fecha_inicio'][$i];
				$datos_asociacion['fecha_fin']=$datos_proyecto['fecha_fin'][$i];
				
				modules::run('notificacion/notificacion_c/_crear_invitacion',$sesion['id_usuario'],$datos_asociacion);
			}
		}
		return array('status'=>1, 'msg'=>"El proyecto ha sido creado exitosamente");

	}
	
	function _consultar_comentarios($id_proyecto){
		$resultado = $this->proyecto_m->consultar_comentarios($id_proyecto);
		
		return $resultado;
	}
	
	function _consultar_calificacion_promedio($id_proyecto){
		$resultado = $this->proyecto_m->consultar_calificacion_promedio($id_proyecto);
		
		return $resultado;
	}
	
	function _consultar_calificacion_hecha($id_usuario_from,$id_proyecto){
		$resultado = $this->proyecto_m->consultar_calificacion_hecha($id_usuario_from,$id_proyecto);
		
		return $resultado;
	}
	
	function _consultar_proyecto($id_proyecto){
		
		$resultado = $this->proyecto_m->consultar_proyecto($id_proyecto);
		
		return $resultado;
	}
	
	function _modificar_proyecto($id_proyecto, $datos_proyecto){
	
		$datos_proyecto['temas_interes'] = explode("|", $datos_proyecto['temas_interes']);
		
		$keywords = array();
		$keywords_segmentado = array();
		//Creación palabras clave
		array_push($keywords, $datos_proyecto['nombre_proyecto'] );
		$keywords = array_merge( $keywords, $datos_proyecto['temas_interes']);
		if(isset($datos_proyecto['descripcion_general'] )) array_push($keywords, $datos_proyecto['descripcion_general']);
		if(isset($datos_proyecto['objetivo'] )) array_push($keywords, $datos_proyecto['objetivo']);
		if(isset($datos_proyecto['sector'] ))array_push($keywords, $datos_proyecto['sector']);
		if(isset($datos_proyecto['servicios_productos'] )) array_push($keywords, $datos_proyecto['servicios_productos']);
		if(isset($datos_proyecto['tipo_proyecto'] ))array_push($keywords, $datos_proyecto['tipo_proyecto']);
		if(isset($datos_proyecto['fuente_financiacion'] ))array_push($keywords, $datos_proyecto['fuente_financiacion']);
		if(isset($datos_proyecto['poblacion_objetivo'] ))array_push($keywords, $datos_proyecto['poblacion_objetivo']);
		if(isset($datos_proyecto['institucion'] ))array_push($keywords, $datos_proyecto['institucion']);
		if(isset($datos_proyecto['pais'] ))array_push($keywords, $datos_proyecto['pais']);
		if(isset($datos_proyecto['ciudad'] ))array_push($keywords, $datos_proyecto['ciudad']);$datos_proyecto;
		if(isset($datos_proyecto['adicionales'] ))array_push($keywords, array_keys($datos_proyecto['adicionales']),array_values($datos_proyecto['adicionales']));
	
		
		//Creación de la invitación para la asociación de nuevos integrantes
		//no hay usuarios por asociar
		if(in_array("",array_values($datos_proyecto['id_usuario_integrantes']))){
			return array('status'=>1, 'msg'=>"El proyecto ha sido creado exitosamente");
			//FIXME cuando se ingresa un solo usuario y luego se borra el campo, persiste el id_usuario
		}
		else
			{
			$num_integrantes=count($datos_proyecto['id_usuario_integrantes']);			
			
			//re-llenar propietarios
			for($i=0;$i<$num_integrantes;$i++){
				if(in_array($datos_proyecto['id_usuario_integrantes'][$i], $datos_proyecto['propietario'])){
					$es_propietario[$i]=true;
				}
				else{
					$es_propietario[$i]=false;
				}
			}
			
			//para cada id_usuario crear asociación
			for($i=0;$i<$num_integrantes;$i++){
				
				$datos_asociacion=array();

				$datos_asociacion['id_usuario']=$datos_proyecto['id_usuario_integrantes'][$i];
				$datos_asociacion['nombre_completo']=$datos_proyecto['integrantes'][$i];
				$datos_asociacion['id_proyecto']=$id_proyecto;
				$datos_asociacion['nombre_proyecto']=$datos_proyecto['nombre_proyecto'];
				$datos_asociacion['rol']=$datos_proyecto['roles'][$i];
				$datos_asociacion['es_propietario']=$es_propietario[$i];
				$datos_asociacion['fecha_inicio']=$datos_proyecto['fecha_inicio'][$i];
				$datos_asociacion['fecha_fin']=$datos_proyecto['fecha_fin'][$i];
				
				modules::run('notificacion/notificacion_c/_crear_invitacion',$sesion['id_usuario'],$datos_asociacion);
			}
		}
		//Fin Crear invitaciones
		
		foreach($keywords as $keyword){

			$keywords_segmentado =array_merge($keywords_segmentado, explode(" ",$keyword));
		}
		$datos_proyecto['keywords'] = array_map('strtolower',$keywords_segmentado);

		$proyecto['id_proyecto'] = $this->proyecto_m->actualizar_proyecto($id_proyecto,$datos_proyecto);
		
		return array('status'=>1, 'msg'=>"El proyecto ha sido actualizado exitosamente");
		
	}
		
	function _crear_seguimiento($id_proyecto,$datos){

		//Creacion del seguimiento
		$datos['id_proyecto']= $id_proyecto;
		$datos['creado_por']=$this->session->userdata('id_usuario');
		//$datos['fecha_seguimiento']=$this->session->userdata('id_usuario');
		$this->proyecto_m->insertar_seguimiento($id_proyecto,$datos);

		return array('status'=>1, 'msg'=>"El seguimiento ha sido creado exitosamente");

	}
	
	function _crear_contabilidad($id_proyecto,$datos){

		//Creacion de la contabilidad
		$datos['id_proyecto']= $id_proyecto;
		$datos['creado_por']=$this->session->userdata('id_usuario');
		$this->proyecto_m->insertar_contabilidad($id_proyecto,$datos);

		return array('status'=>1, 'msg'=>"La contabilidad ha sido creada exitosamente");

	}
	
	function _consultar_seguimientos($id_proyecto){
		
		$resultado = $this->proyecto_m->consultar_seguimientos($id_proyecto);
		
		return $resultado;
	}
	
	function _consultar_contabilidad($id_proyecto){
		
		$resultado = $this->proyecto_m->consultar_contabilidad($id_proyecto);
		
		return $resultado;
	}

	function _consultar_usuarios_proyecto($id_proyecto){
		
		$resultado = $this->proyecto_m->consultar_usuarios_proyecto($id_proyecto);
		
		return $resultado;
	}

}