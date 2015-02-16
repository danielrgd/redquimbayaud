<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_c extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('usuario_m');
	}
	
    /**
    * Se hace el llamado a la base de datos para 
    * verificar el usuario y la contraseña
    * @return void
    */	
	function _validar_usuario($usuario,$contrasena){		
		
		$resultado = $this->usuario_m->consultar_usuario($usuario);
	
		//Si existe una coincidencia se crea la sesión y se retorna a la página principal
		
		if(!isset($resultado[0]) || $resultado[0]['contrasena'] != do_hash($contrasena, 'md5')){

			return array('status'=>0, 'msg'=>"Acceso Incorrecto");
		}
		if($resultado[0]['estado_cuenta'] == "Pendiente por activar"){

			return array('status'=>0, 'msg'=>"La cuenta aún no ha sido activada");
		}
		else{
				$datos['id_usuario'] = $resultado[0]['id_usuario'];
				$datos['nombre_completo'] = $resultado[0]['nombre_completo'];
				$datos['ruta_foto_perfil'] = $resultado[0]['ruta_foto_perfil'];
				$datos['idioma_perfil'] = $resultado[0]['idioma_perfil'];

				modules::run('sesion/sesion_c/_crear_sesion',$datos);
		}
	}
		
	function _modificar_cuenta($usuario,$datos){
		
		if($usuario == $this->session->userdata('id_usuario')){
			$this->usuario_m->actualizar_cuenta($usuario,$datos);
			
		}
	}
	
	function _modificar_perfil($usuario,$datos){
		
		$keywords =array();
		$keywords_segmentado = array();
		
			
		$datos['fecha_nacimiento'] = $datos['fecha_nacimiento'];
		$datos['idiomas'] = explode("|", $datos['idiomas']);
		$datos['temas_interes'] = explode("|", $datos['temas_interes']);

		//Creación palabras clave
		array_push($keywords, $datos['nombre_completo']);
		array_push($keywords, $datos['profesion']);
		$keywords = array_merge( $keywords,$datos['idiomas'] );
		array_push($keywords, $datos['pais'] );
		array_push($keywords, $datos['ciudad'] );
		$keywords = array_merge( $keywords, $datos['temas_interes']);
		array_push($keywords, $datos['correo']);
		$keywords = array_merge( $keywords, array_keys($datos['estudios']),array_values($datos['estudios']));
		if(isset($datos['ciudad'] ))array_push($keywords, $datos['ciudad']);$datos_proyecto;
		if(isset($datos['adicionales'] ))array_push($keywords, array_keys($datos['adicionales']),array_values($datos['adicionales']));
	

		foreach($keywords as $keyword){

			$keywords_segmentado =array_merge($keywords_segmentado, explode(" ",$keyword));

		}

		$datos['keywords'] = array_map('strtolower',$keywords_segmentado);

		$this->usuario_m->actualizar_cuenta($usuario,$datos);
			
	}
	
	function _crear_cuenta($datos){
		
		$usuario = $this->input->post('id_usuario');			
		//Se valida que el usuario no ha sido creado previamente
		$encontrado = $this->usuario_m->consultar_usuario($usuario);
		$keywords =array();
		$keywords_segmentado =array();

		if($encontrado == true){

			return array('status'=>0, 'msg'=>"El usuario ha sido registrado previamente");
			//echo json_encode(array('status'=>0, 'msg'=>"El usuario ha sido registrado previamente"));
		}
		else{

			if(!isset($datos['ruta_foto_perfil'] )) $datos['ruta_foto_perfil'] = "default.jpg";
			//$datos['fecha_nacimiento'] = strtotime($datos['fecha_nacimiento']);
			$datos['fecha_nacimiento'] = $datos['fecha_nacimiento'];
			$datos['idiomas'] = explode("|", $datos['idiomas']);
			$datos['temas_interes'] = explode("|", $datos['temas_interes']);
			$datos['estado_cuenta'] = "Pendiente por activar";

			//Creación palabras clave
			array_push($keywords, $datos['nombre_completo']);
			array_push($keywords, $datos['profesion']);
			$keywords = array_merge( $keywords,$datos['idiomas'] );
			array_push($keywords, $datos['pais'] );
			array_push($keywords, $datos['ciudad'] );
			$keywords = array_merge( $keywords, $datos['temas_interes']);
			array_push($keywords, $datos['correo']);
			$keywords = array_merge( $keywords, array_keys($datos['estudios']));
			$keywords = array_merge( $keywords, array_values($datos['estudios']));
			$keywords = array_merge( $keywords,array_keys($datos['adicionales']));
			$keywords = array_merge( $keywords,array_values($datos['adicionales']));

			foreach($keywords as $keyword){
				
				$keywords_segmentado =array_merge($keywords_segmentado, explode(" ",$keyword));
				
			}
			
			$datos['keywords'] = array_map('strtolower',$keywords_segmentado);
			
			//Se genera la llave de confirmación
			$ip = $this->session->userdata('ip_address');
			$uniqid = uniqid(mt_rand(), true);
			$llave_confirmacion = md5($ip.$uniqid);

			//Creacion del usuario
			$this->usuario_m->insertar_usuario($datos,$llave_confirmacion);

			//Envia correo de activacion
			$URL_activacion=site_url() ."/interfaz/activar_cuenta/".$datos['id_usuario']."/".$llave_confirmacion;
			
			$variables=array('{nombre_completo}','{id_usuario}','{URL_activacion}');
			$reemplazos=array($datos['nombre_completo'],$datos['id_usuario'],$URL_activacion);
			$mensaje_activacion=str_replace($variables,$reemplazos,$this->lang->line('msg_mensaje_activar_cuenta'));
			modules::run('correo/correo_c/_enviar_correo',$datos['correo'],$this->lang->line('msg_asunto_activar_cuenta'),$mensaje_activacion);
			
			
			$this->session->set_flashdata('notificacion', 'Recuerde realizar la activación del usuario');
			return array('status'=>1, 'msg'=>"El usuario ha sido creado exitosamente");

		}
	}
	
	function _consultar_comentarios($usuario){
		$resultado = $this->usuario_m->consultar_comentarios($usuario);
		
		return $resultado;
	}
	
	function _consultar_calificacion_promedio($id_usuario_to){
		$resultado = $this->usuario_m->consultar_calificacion_promedio($id_usuario_to);
		
		return $resultado;
	}
	
	function _consultar_calificacion_hecha($id_usuario_from,$id_usuario_to){
		$resultado = $this->usuario_m->consultar_calificacion_hecha($id_usuario_from,$id_usuario_to);
		
		return $resultado;
	}
	
	function _consultar_usuario($usuario){
		$resultado = $this->usuario_m->consultar_usuario($usuario);
		
		return $resultado;
	}
	
	function _consultar_usuarios(){
		
		$resultado = $this->usuario_m->consultar_usuarios();
		
		return $resultado;
	}
	
	function _consultar_usuarios_mejor_valorados(){
		$resultado = $this->usuario_m->consultar_usuarios_mejor_valorados();
		return $resultado;
	}
	
	function _consultar_usuarios_mas_comentados(){
		$resultado = $this->usuario_m->consultar_usuarios_mas_comentados();
		return $resultado;
	}

	function _buscar_usuarios_por_palabras_clave($palabras_clave){
		
		$palabras_clave_array=explode(" ",$palabras_clave);
		$resultado=array();
		
		foreach ($palabras_clave_array as $palabra){
			$resultado_parcial=$this->usuario_m->buscar_usuarios_por_palabras_clave(strtolower($palabra));
			$resultado=array_merge($resultado, $resultado_parcial);
		}
		
		$resultado=$this->eliminar_duplicados($resultado, 'id_usuario');

		return $resultado;
	}
	
	function _activar_cuenta($usuario,$llave_validacion){
		
		$usuario_resultado=$this->usuario_m->consultar_usuario($usuario);
		
		if(!isset($usuario_resultado[0]) || ($usuario_resultado[0]['llave_validacion'] != $llave_validacion )){
			
			return array('status'=>0, 'msg'=>"Error realizando la activacion de la cuenta");
		}
		else if($usuario_resultado[0]['estado_cuenta'] == "Activo"){
			
			return array('status'=>1, 'msg'=>"El usuario ya había sido activado previamente");
		}
		else{
			
			$this->usuario_m->actualizar_estado($usuario);
			
			$datos['id_usuario'] = $usuario_resultado[0]['id_usuario'];
			$datos['nombre_completo'] = $usuario_resultado[0]['nombre_completo'];
			$datos['ruta_foto_perfil'] = $usuario_resultado[0]['ruta_foto_perfil'];
			$datos['idioma_perfil'] = $usuario_resultado[0]['idioma_perfil'];

			modules::run('sesion/sesion_c/_crear_sesion',$datos);
			
			redirect('interfaz');
			
		}
		
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

	function _comentar_usuario($id_usuario_to,$comentario){
		
		$id_usuario_from= $this->session->userdata('id_usuario');
		
		$datos_usuario_from = $this->usuario_m->consultar_usuario($id_usuario_from);
		$datos_usuario_to = $this->usuario_m->consultar_usuario($id_usuario_to);
		
		$resultado = $this->usuario_m->insertar_comentario_usuario($datos_usuario_from[0],$datos_usuario_to[0],$comentario);
		
		//Creacion de la notificaion
		$mensaje = "Nuevo comentario de ".$datos_usuario_from[0]['nombre_completo'].": ".$comentario;
		modules::run('notificacion/notificacion_c/_crear_notificacion_usuario',$datos_usuario_to[0]['id_usuario'],$mensaje,$datos_usuario_from[0]['id_usuario']);

		return $resultado;
		
	}
	
	function _calificar_usuario($id_usuario_to,$calificacion){
		
		$id_usuario_from= $this->session->userdata('id_usuario');
		$datos_usuario_from = $this->usuario_m->consultar_usuario($id_usuario_from);
		$datos_usuario_to = $this->usuario_m->consultar_usuario($id_usuario_to);
		
		$resultado = $this->usuario_m->actualizar_calificacion_usuario($id_usuario_from,$datos_usuario_to[0],$calificacion);
		
		//Creacion de la notificacion
		$mensaje = "El usuario ".$datos_usuario_from[0]['nombre_completo']." lo ha calificado: ".$calificacion;
		modules::run('notificacion/notificacion_c/_crear_notificacion_usuario',$datos_usuario_to[0]['id_usuario'],$mensaje,$datos_usuario_from[0]['id_usuario']);

		return $resultado;
		
	}
	
	function _consultar_proyectos($id_usuario){
		
		$proyectos = $this->usuario_m->consultar_proyectos($id_usuario);
		
		return $proyectos;
		
	}
		
	
}