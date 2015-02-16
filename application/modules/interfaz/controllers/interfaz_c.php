<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Interfaz_c extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		
		//Si el usuario inicia sesion se obtiene el idioma del perfil
		if($this->session->userdata('logged_in')){
				
			$this->lang->load('listas',$this->session->userdata('language'));
			$this->lang->load('msg',$this->session->userdata('language'));
			$this->lang->load('form_validation',$this->session->userdata('language'));
			
		}
		else{
			$this->lang->load('listas');
			$this->lang->load('msg');
			$this->lang->load('form_validation');
		}
		
	}
    /**
    * Se carga la pagina de inicial
    * 
    * @return void
    */
	function index(){		
		
		$data['titulo'] =   $this->lang->line('msg_label_inicio');

		$data['proyectos_mejor_valorados'] =modules::run('proyecto/proyecto_c/_consultar_proyectos_mejor_valorados');
		$data['proyectos_mas_comentados'] =modules::run('proyecto/proyecto_c/_consultar_proyectos_mas_comentados');
		$data['usuarios_mejor_valorados'] =modules::run('usuario/usuario_c/_consultar_usuarios_mejor_valorados');
		$data['usuarios_mas_comentados'] =modules::run('usuario/usuario_c/_consultar_usuarios_mas_comentados');
		
		$data['main_content'] = 'interfaz/index_v.php';
        $this->load->view('template', $data);
        
	}
	
	function buscar_perfiles_por_palabras_clave(){
		
		$palabras_clave= $this->input->post('palabras_clave');
		
		if($palabras_clave !=""){
			
			$data['titulo'] = $this->lang->line('msg_label_resultados');

			$data['usuarios']=modules::run('usuario/usuario_c/_buscar_usuarios_por_palabras_clave',$palabras_clave);			
			$data['proyectos']=modules::run('proyecto/proyecto_c/_buscar_proyectos_por_palabras_clave',$palabras_clave);			

			$data['busqueda'] = $palabras_clave;
			$data['main_content'] = 'interfaz/resultados_v.php';
			$this->load->view('template', $data);
			}

		else{
			
			$this->index();
			
			
		}
	}

	function iniciar_sesion(){		
	
		$this->form_validation->set_rules('id_usuario', $this->lang->line('msg_label_usuario'), 'trim|xss_cleanxss_clean|required');
		$this->form_validation->set_rules('contrasena', $this->lang->line('msg_label_contrasena'), 'trim|xss_clean|required');

    	if ($this->form_validation->run($this) == FALSE)
        {
			echo json_encode(array('status'=>0, 'msg'=>validation_errors()));

		}
		else{
		
			//Si los campos estan completos se valida el usuario y la contrasena
			$usuario = $this->input->post('id_usuario');
			$contrasena = $this->input->post('contrasena');		
			
			$mensaje = modules::run('usuario/usuario_c/_validar_usuario',$usuario,$contrasena);
					
			echo json_encode($mensaje);
		
		}	
	}
	
	function formulario_registro(){
		
		$data['titulo'] =  $this->lang->line('msg_label_inicio');
		$data['lista_paises'] = $this->lang->line('lista_paises');
		$data['lista_ciudades'] = $this->lang->line('lista_ejemplo');
		$data['lista_visibilidad'] = $this->lang->line('lista_visibilidad');
		$data['lista_idiomas_perfil'] = $this->lang->line('lista_idiomas_perfil');
		$data['tags_lista_idiomas'] = array_values($this->lang->line('lista_idiomas'));
//		$data['tags_lista_temas_interes'] = array_values($this->lang->line('lista_ejemplo'));
		$data['tags_lista_temas_interes'] = array();
		$arreglo_temas=modules::run('tema_interes/tema_interes_c/_consultar_temas_interes_tipo','usuario');
		foreach($arreglo_temas as $tema){
			array_push($data['tags_lista_temas_interes'],$tema['descripcion']);
		}
		
		$data['main_content'] = 'interfaz/crear_cuenta_v.php';
		$this->load->view('template', $data);
	
	}
	
	function crear_cuenta(){
			
		if($this->input->is_ajax_request()){
			
			$datos_personales = array();
			//$this->form_validation->set_rules('ruta_foto_perfil', 'Foto de Perfil', 'trim|xss_clean|required');
			$this->form_validation->set_rules('id_usuario', $this->lang->line('msg_label_usuario'), 'trim|xss_clean|required|integer');
			$this->form_validation->set_rules('nombre_completo', $this->lang->line('msg_label_nombre_completo'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('fecha_nacimiento', $this->lang->line('msg_label_fecha_nacimiento'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('profesion', $this->lang->line('msg_label_profesion'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('temas_interes', $this->lang->line('msg_label_temas_interes'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('correo', $this->lang->line('msg_label_correo'), 'trim|xss_clean|valid_email|required');
			$this->form_validation->set_rules('titulo[]', $this->lang->line('msg_label_titulo'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('institucion[]', $this->lang->line('msg_label_institucion'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('contrasena', $this->lang->line('msg_label_contrasena'), 'trim|xss_clean|required|md5');
			$this->form_validation->set_rules('confirmacion_contrasena', $this->lang->line('msg_label_confirmacion_contrasena'), 'trim|xss_clean|required|matches[contrasena]');
			$this->form_validation->set_rules('visibilidad', $this->lang->line('msg_label_visibilidad'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('idioma_perfil', $this->lang->line('msg_label_idioma_perfil'), 'trim|xss_clean|required');
			
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(array('status'=>0, 'msg'=>validation_errors()));

			}
			else{

				$datos_personales['id_usuario'] = $this->input->post('id_usuario');
				if($this->input->post('ruta_foto_perfil') != "") $datos_personales['ruta_foto_perfil'] = $this->input->post('ruta_foto_perfil');
				$datos_personales['nombre_completo'] = $this->input->post('nombre_completo');
				$datos_personales['fecha_nacimiento'] = $this->input->post('fecha_nacimiento');
				$datos_personales['profesion'] = $this->input->post('profesion');
				$this->form_validation->set_rules('idiomas', 'Idiomas', 'trim|xss_clean|required');
				//TODO revisar es la misma universidad
				$datos_personales['estudios'] = array_combine($this->input->post('institucion'),$this->input->post('titulo')); 
				$datos_personales['adicionales'] = array_combine($this->input->post('etiqueta'),$this->input->post('valor')); 
				$datos_personales['idiomas'] = $this->input->post('idiomas');
				if($this->input->post('pais') != "") $datos_personales['pais'] = $this->input->post('pais');
				if($this->input->post('ciudad') != "") $datos_personales['ciudad'] = $this->input->post('ciudad');
				$datos_personales['temas_interes'] = $this->input->post('temas_interes');
				$datos_personales['correo'] = $this->input->post('correo'); 
				$datos_personales['contrasena'] = $this->input->post('contrasena');
				$datos_personales['privacidad'] = $this->input->post('visibilidad');
				$datos_personales['idioma_perfil'] = $this->input->post('idioma_perfil');

 				$mensaje = modules::run('usuario/usuario_c/_crear_cuenta',$datos_personales);
 				echo json_encode($mensaje);
				
				if($mensaje['status'] == "1"){
					
					//$this->session->set_flashdata('notificacion', 'Recuerde realiza la activacion de la cuenta');
					//redirect('/interfaz/interfaz_c/index');
				}  
			}	
		}
	}
	
	function cerrar_sesion (){
	
		modules::run('sesion/sesion_c/_cerrar_sesion');
		$this->index();
		
	}
	
	function visualizar_usuario ($usuario){
	
		$data['notificaciones']= modules::run('notificacion/notificacion_c/_consultar_notificaciones_activas',$usuario);
		$data['usuario']=modules::run('usuario/usuario_c/_consultar_usuario',$usuario);
		$data['proyectos'] = modules::run('usuario/usuario_c/_consultar_proyectos',$usuario);
	
		if(isset($data['usuario'][0])){
			
			$data['lista_paises'] = $this->lang->line('lista_paises');
			$data['comentarios']=modules::run('usuario/usuario_c/_consultar_comentarios',$usuario);
			$data['usuario']['calificacion'] = modules::run('usuario/usuario_c/_consultar_calificacion_promedio',$usuario);
			$usuario_actual=$this->session->userdata('id_usuario');
			$data['usuario']['micalificacion'] = modules::run('usuario/usuario_c/_consultar_calificacion_hecha',$usuario_actual,$usuario);

			$data['titulo'] = $data['usuario'][0]['nombre_completo'];

			$data['main_content'] = 'interfaz/perfil_usuario_v.php';
			$this->load->view('template', $data);
			
		}		
	}
	
	function visualizar_formulario_perfil($usuario){
		
		if($usuario == $this->session->userdata('id_usuario')){
			
			$data['notificaciones']= modules::run('notificacion/notificacion_c/_consultar_notificaciones_activas',$usuario);
			$data['titulo'] =  $this->lang->line('msg_label_actualizar_perfil');
			$data['lista_paises'] = $this->lang->line('lista_paises');
			$data['tags_lista_idiomas'] = array_values($this->lang->line('lista_idiomas'));
//			$data['tags_lista_temas_interes'] = array_values($this->lang->line('lista_ejemplo'));
			$data['tags_lista_temas_interes'] = array();
			$arreglo_temas=modules::run('tema_interes/tema_interes_c/_consultar_temas_interes_tipo','usuario');
			foreach($arreglo_temas as $tema){
				array_push($data['tags_lista_temas_interes'],$tema['descripcion']);
			}

			$data['usuario']=modules::run('usuario/usuario_c/_consultar_usuario',$usuario);
			$data['main_content'] = 'interfaz/perfil_usuario_editar_v.php';
			$this->load->view('template', $data);
			
		}
	}
	
	function visualizar_opciones_cuenta($usuario){
		
		if($usuario == $this->session->userdata('id_usuario')){
			
			$data['titulo'] =  $this->lang->line('msg_label_modificar_opciones_cuenta');
			$data['lista_visibilidad'] = $this->lang->line('lista_visibilidad');
			$data['lista_idiomas_perfil'] = $this->lang->line('lista_idiomas_perfil');
		
			$data['usuario']=modules::run('usuario/usuario_c/_consultar_usuario',$usuario);
			$data['main_content'] = 'interfaz/opciones_cuenta_editar_v.php';
			$this->load->view('template', $data);
			
		}
	}
	
	function modificar_perfil(){
		
		if($this->input->is_ajax_request()){
			
			//$this->form_validation->set_rules('foto_perfil', 'Foto de Perfil', 'trim|xss_clean|required');
			$this->form_validation->set_rules('nombre_completo', $this->lang->line('msg_label_nombre_completo'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('fecha_nacimiento', $this->lang->line('msg_label_fecha_nacimiento'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('profesion', $this->lang->line('msg_label_profesion'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('temas_interes', $this->lang->line('msg_label_temas_interes'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('idiomas', $this->lang->line('msg_label_idiomas'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('correo', $this->lang->line('msg_label_correo'), 'trim|xss_clean|valid_email|required');
			$this->form_validation->set_rules('titulo[]', $this->lang->line('msg_label_titulo'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('institucion[]', $this->lang->line('msg_label_institucion'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('etiqueta[]', $this->lang->line('msg_label_etiqueta'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('valor[]', $this->lang->line('msg_label_valor'), 'trim|xss_clean|required');
		
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(array('status'=>0, 'msg'=>validation_errors()));

			}
			else{

				$usuario = $this->input->post('id_usuario');
				if($this->input->post('ruta_foto_perfil') != "") $datos_personales['ruta_foto_perfil'] = $this->input->post('ruta_foto_perfil');
				$datos_personales['nombre_completo'] = $this->input->post('nombre_completo');
				$datos_personales['fecha_nacimiento'] = $this->input->post('fecha_nacimiento');
				$datos_personales['profesion'] = $this->input->post('profesion');
				//TODO revisar es la misma universidad
				$datos_personales['estudios'] = array_combine($this->input->post('institucion'),$this->input->post('titulo')); 
				$datos_personales['adicionales'] = array_combine($this->input->post('etiqueta'),$this->input->post('valor')); 
				$datos_personales['idiomas'] = $this->input->post('idiomas');
				$datos_personales['pais'] = $this->input->post('pais');
				$datos_personales['ciudad'] = $this->input->post('ciudad');
				$datos_personales['temas_interes'] = $this->input->post('temas_interes');
				$datos_personales['correo'] = $this->input->post('correo'); 
				
				$mensaje = modules::run('usuario/usuario_c/_modificar_perfil',$usuario,$datos_personales);
				echo json_encode($mensaje);

			}			
		}		
	}
	
	function modificar_cuenta(){
		if($this->input->is_ajax_request()){
			
			if($this->input->post('nueva_contrasena') != "" || $this->input->post('contrasena') != ""){
				
				$this->form_validation->set_rules('nueva_contrasena', 'Nueva Contrasena', 'trim|xss_clean|required|md5');
				$this->form_validation->set_rules('confirmacion_nueva_contrasena', 'Confirmacion nueva Contrasena', 'trim|xss_clean|required|matches[nueva_contrasena]');	
			}
			
			$this->form_validation->set_rules('id_usuario', $this->lang->line('msg_label_id_usuario'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('visibilidad', $this->lang->line('msg_label_visibilidad'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('idioma_perfil', $this->lang->line('msg_label_idioma_perfil'), 'trim|xss_clean|required');
		
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(array('status'=>0, 'msg'=>validation_errors()));

			}
			else{
				
				$usuario = $this->input->post('id_usuario');
				if($this->input->post('nueva_contrasena') != "") $datos['contrasena'] = $this->input->post('nueva_contrasena');
				$datos['privacidad'] = $this->input->post('visibilidad');
				$datos['idioma_perfil'] = $this->input->post('idioma_perfil');
				
				$mensaje = modules::run('usuario/usuario_c/_modificar_cuenta',$usuario,$datos);
				
				echo json_encode($mensaje);
				
			}			
		}		
	}
	
	function activar_cuenta($usuario,$llave_validacion){
		
		if($usuario != "" && $llave_validacion != ""){
		
			$data['mensaje'] = modules::run('usuario/usuario_c/_activar_cuenta',$usuario,$llave_validacion);
			
			$this->load->view('interfaz/activar_cuenta_v.php', $data);
			
		}
	}
		
	function comentar_usuario(){
		
		if($this->input->is_ajax_request()){
			
			$this->form_validation->set_rules('comentario', $this->lang->line('msg_label_comentario'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('usuario_to', 'Usuario To', 'trim|xss_clean|required');
			
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(array('status'=>0, 'msg'=>validation_errors()));

			}
			else{
				
				$comentario = $this->input->post('comentario');
				$usuario_to = $this->input->post('usuario_to');
				
				modules::run('usuario/usuario_c/_comentar_usuario',$usuario_to,$comentario);
				
				echo json_encode(array('status'=>1, 'msg'=>"Comentario creado exitosamente"));
				
			}
		}
	}
	
	function calificar_usuario(){
		
		if($this->input->is_ajax_request()){
			
			$this->form_validation->set_rules('usuario_to_ca', 'Usuario To', 'trim|xss_clean|required');
			
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(array('status'=>0, 'msg'=>validation_errors()));

			}
			else{
				
				$calificacion = $this->input->post('calificacion');
				$usuario_to = $this->input->post('usuario_to_ca');
				
				modules::run('usuario/usuario_c/_calificar_usuario',$usuario_to,$calificacion);
				
				echo json_encode(array('status'=>1, 'msg'=>"Calificación actualizada exitosamente"));
				
			}
		}
	}
	
	function comentar_proyecto(){
		
		if($this->input->is_ajax_request()){
			
			$this->form_validation->set_rules('comentario', $this->lang->line('msg_label_comentario'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('proyecto_to', 'Proyecto To', 'trim|xss_clean|required');
			
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(array('status'=>0, 'msg'=>validation_errors()));

			}
			else{
				
				$comentario = $this->input->post('comentario');
				$proyecto_to = $this->input->post('proyecto_to');
				
				modules::run('proyecto/proyecto_c/_comentar_proyecto',$proyecto_to,$comentario);
				
				echo json_encode(array('status'=>1, 'msg'=>"Comentario creado exitosamente"));
				
			}
		}
	}
	
	function calificar_proyecto(){
		
		if($this->input->is_ajax_request()){
			
			$this->form_validation->set_rules('proyecto_to_ca', 'Proyecto To', 'trim|xss_clean|required');
			
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(array('status'=>0, 'msg'=>validation_errors()));

			}
			else{
				
				$calificacion = $this->input->post('calificacion');
				$proyecto_to = $this->input->post('proyecto_to_ca');
				
				modules::run('proyecto/proyecto_c/_calificar_proyecto',$proyecto_to,$calificacion);
				
				echo json_encode(array('status'=>1, 'msg'=>"Calificación actualizada exitosamente"));
				
			}
		}
	}
	
	function visualizar_tema_interes($tema_interes){
		
		$tema_interes=urldecode($tema_interes);
	
		$data['perfiles']=modules::run('tema_interes/tema_interes_c/_consultar_tema_interes',$tema_interes);

		$data['usuarios']=$data['perfiles']['usuarios'];

		$data['proyectos']=$data['perfiles']['proyectos'];
		
		$data['titulo'] = $tema_interes;
		
		$data['busqueda'] = $tema_interes;
		
		$data['main_content'] = 'interfaz/tema_interes_v.php';

		$this->load->view('template', $data);
		
	}
	
	function formulario_proyecto(){
				
		$data['usuarios'] = array();
		$data['lista_paises'] = $this->lang->line('lista_paises');
		$arreglo_usuarios= modules::run('usuario/usuario_c/_consultar_usuarios');
		
		foreach($arreglo_usuarios as $llave => $usuario){
			
			array_push($data['usuarios'],array("id"=>$usuario['id_usuario'] ,"name"=>$usuario['nombre_completo']));			
			
		}
		$data['lista_ciudades'] = $this->lang->line('lista_ejemplo');
		$data['lista_visibilidad'] = $this->lang->line('lista_visibilidad');
		//$data['lista_idiomas_perfil'] = $this->lang->line('lista_idiomas_perfil');
		$data['tags_lista_temas_interes'] = array();
		$arreglo_temas=modules::run('tema_interes/tema_interes_c/_consultar_temas_interes_tipo','usuario');
		foreach($arreglo_temas as $tema){
			array_push($data['tags_lista_temas_interes'],$tema['descripcion']);
		}

		$data['titulo'] =  $this->lang->line('msg_label_crear_proyecto');
		$data['main_content'] = 'interfaz/crear_proyecto_v.php';

		$this->load->view('template', $data);
		
	}

	function crear_proyecto(){
		
		if($this->input->is_ajax_request()){
			
			$datos_personales = array();
			
			$this->form_validation->set_rules('nombre_proyecto', $this->lang->line('msg_label_nombre_proyecto'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('visibilidad', $this->lang->line('msg_label_visibilidad'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('temas_interes', $this->lang->line('msg_label_temas_interes'), 'trim|xss_clean|required');
			//$this->form_validation->set_rules('integrantes[]', 'Integrantes', 'trim|xss_clean');
			//$this->form_validation->set_rules('roles[]', 'Roles', 'trim|xss_clean');
			
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(array('status'=>0, 'msg'=>validation_errors()));

			}
			else{

				$datos_proyecto['nombre_proyecto'] = $this->input->post('nombre_proyecto');
				$datos_proyecto['temas_interes'] = $this->input->post('temas_interes');
				$datos_proyecto['visibilidad'] = $this->input->post('visibilidad');
				if($this->input->post('descripcion_general') != "") $datos_proyecto['descripcion_general'] = $this->input->post('descripcion_general');
				if($this->input->post('objetivo') != "") $datos_proyecto['objetivo'] = $this->input->post('objetivo');
				if($this->input->post('sector') != "") $datos_proyecto['sector'] = $this->input->post('sector');
				if($this->input->post('tipo_proyecto') != "") $datos_proyecto['tipo_proyecto'] = $this->input->post('tipo_proyecto');
				if($this->input->post('fuente_financiacion') != "") $datos_proyecto['fuente_financiacion'] = $this->input->post('fuente_financiacion');
				if($this->input->post('poblacion_objetivo') != "") $datos_proyecto['poblacion_objetivo'] = $this->input->post('poblacion_objetivo');
				if($this->input->post('institucion') != "") $datos_proyecto['institucion'] = $this->input->post('institucion');
				if($this->input->post('fecha_inicio_p') != "") $datos_proyecto['fecha_inicio_p'] = $this->input->post('fecha_inicio_p');
				if($this->input->post('fecha_fin_p') != "") $datos_proyecto['fecha_fin_p'] = $this->input->post('fecha_fin_p');
				if($this->input->post('pais') != "") $datos_proyecto['pais'] = $this->input->post('pais');
				if($this->input->post('ciudad') != "") $datos_proyecto['ciudad'] = $this->input->post('ciudad');

				$datos_proyecto['propietario']=array();
				if($this->input->post('integrantes') != "") $datos_proyecto['integrantes'] = $this->input->post('integrantes'); 
				if($this->input->post('id_usuario_integrantes') != "") $datos_proyecto['id_usuario_integrantes'] = $this->input->post('id_usuario_integrantes'); 
				if($this->input->post('roles') != "") $datos_proyecto['roles'] = $this->input->post('roles'); 
				if($this->input->post('fecha_inicio') != "") $datos_proyecto['fecha_inicio'] = $this->input->post('fecha_inicio'); 
				if($this->input->post('fecha_fin') != "") $datos_proyecto['fecha_fin'] = $this->input->post('fecha_fin'); 
				if($this->input->post('propietario') != "") $datos_proyecto['propietario'] = $this->input->post('propietario'); 
				
				if($this->input->post('adicionales') != "") $datos_proyecto['adicionales'] = array_combine($this->input->post('etiqueta'),$this->input->post('valor')); 
				
				
				$mensaje = modules::run('proyecto/proyecto_c/_crear_proyecto',$datos_proyecto);
				echo json_encode($mensaje);
					
			}
		}
		
	}
	
	function visualizar_proyecto ($id_proyecto){
	
		$data['lista_tipo_contabilidad'] = $this->lang->line('lista_tipo_contabilidad');
		$data['propietarios_proyecto'] = array();
		$data['proyecto']=modules::run('proyecto/proyecto_c/_consultar_proyecto',$id_proyecto);
		$usuarios_proyecto=modules::run('proyecto/proyecto_c/_consultar_usuarios_proyecto',$id_proyecto); 
		$data['integrantes'] = $usuarios_proyecto['integrante'];
		$data['integrantes_validacion'] = array();
		
		if(count($usuarios_proyecto['propietario']>0 )){
			
			foreach($usuarios_proyecto['propietario'] as $usuario_proyecto){
				
				array_push($data['propietarios_proyecto'],$usuario_proyecto['id_usuario']);
			}
		}
		
		if(count($data['integrantes']>0 )){
			
			foreach($data['integrantes'] as $usuario_proyecto){
				
				array_push($data['integrantes_validacion'],$usuario_proyecto['id_usuario']);
			}
		}
		
		if(isset($data['proyecto'][0])){
		
			$data['comentarios']=modules::run('proyecto/proyecto_c/_consultar_comentarios',$id_proyecto);
			$data['proyecto']['calificacion'] = modules::run('proyecto/proyecto_c/_consultar_calificacion_promedio',$id_proyecto);
			$usuario_actual=$this->session->userdata('id_usuario');
			$data['proyecto']['micalificacion'] = modules::run('proyecto/proyecto_c/_consultar_calificacion_hecha',$usuario_actual,$id_proyecto);

			$data['seguimientos'] = modules::run("proyecto/proyecto_c/_consultar_seguimientos",$id_proyecto);
			$data['contabilidad'] = modules::run("proyecto/proyecto_c/_consultar_contabilidad",$id_proyecto);
			$data['titulo'] = $data['proyecto'][0]['nombre_proyecto'];

			$data['main_content'] = 'interfaz/perfil_proyecto_v.php';
			$this->load->view('template', $data);
			
		}		
	}
	
	function visualizar_formulario_proyecto ($id_proyecto){
	
		$data['proyecto']=modules::run('proyecto/proyecto_c/_consultar_proyecto',$id_proyecto);
		
		$usuario = $this->session->userdata('id_usuario');
		$data['usuarios'] = array();
		$data['tags_lista_temas_interes'] = array();
		$arreglo_temas=modules::run('tema_interes/tema_interes_c/_consultar_temas_interes_tipo','usuario');		
		$usuarios_proyecto=modules::run('proyecto/proyecto_c/_consultar_usuarios_proyecto',$id_proyecto);
		$data['integrantes'] = $usuarios_proyecto['integrante'];
		$data['propietarios_proyecto'] = $usuarios_proyecto['propietario'];
		$data['propietarios'] = array();
		$propietario_existente = array();
		
		//Se obtiene la lista de propietarios del proyecto
		if(count($usuarios_proyecto['propietario']>0 )){
			
			foreach($usuarios_proyecto['propietario'] as $usuario_proyecto){
				
				$propietario_existente[$usuario_proyecto['id_usuario']]=$usuario_proyecto['nombre_completo'];
				
			}
		}
		
		foreach($arreglo_temas as $tema){
			array_push($data['tags_lista_temas_interes'],$tema['descripcion']);
		}
		
		//Se valida que el usuario que ingresa sea el propietario del proyecto
		if(isset($data['proyecto'][0]) && in_array($usuario,array_keys($propietario_existente))){
					
			$arreglo_usuarios= modules::run('usuario/usuario_c/_consultar_usuarios');
		
			foreach($arreglo_usuarios as $llave => $usuario){
			
				//Se crea el arreglo de los usuarios
				array_push($data['usuarios'],array("id"=>$usuario['id_usuario'] ,"name"=>$usuario['nombre_completo']));			
				
			}	
			foreach($data['integrantes'] as $llave => $usuario){
				
				array_push($data['propietarios'],array("id"=>$usuario['id_usuario'],"name"=>$usuario['nombre_completo']));			
			}
			
			$data['lista_paises'] = $this->lang->line('lista_paises');
			$data['lista_visibilidad'] = $this->lang->line('lista_visibilidad');
			$data['titulo'] = $data['proyecto'][0]['nombre_proyecto'];
			$data['main_content'] = 'interfaz/perfil_proyecto_editar_v.php';
			$this->load->view('template', $data);

		}		
	}
	
	function modificar_proyecto(){

		if($this->input->is_ajax_request()){

			
			//Si se diligencia algún campo del integrante el resto debe ser diligenciado
			if( $this->input->post('integrantes') != "" || $this->input->post('roles')  != "" 
			  || $this->input->post('fecha_inicio')  != "" || $this->input->post('fecha_fin')  != ""){

				$this->form_validation->set_rules('integrantes[]', $this->lang->line('msg_label_integrantes'), 'trim|xss_clean|required');
				$this->form_validation->set_rules('roles[]', $this->lang->line('msg_label_roles'), 'trim|xss_clean|required');
				$this->form_validation->set_rules('fecha_inicio[]', $this->lang->line('msg_label_fecha_inicio'), 'trim|xss_clean|required');
				$this->form_validation->set_rules('fecha_fin[]', $this->lang->line('msg_label_fecha_fin'), 'trim|xss_clean|required');
				
			}
			
			$this->form_validation->set_rules('nombre_proyecto', $this->lang->line('msg_label_nombre_proyecto'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('visibilidad', $this->lang->line('msg_label_visibilidad'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('temas_interes',$this->lang->line('msg_label_temas_interes'), 'trim|xss_clean|required');
			
		//	$this->form_validation->set_rules('id_usuario_propietarios[]',$this->lang->line('msg_label_propietarios'), 'Propietarios', 'trim|xss_clean|required');
			$this->form_validation->set_rules('porcentaje_avance',$this->lang->line('msg_label_porcentaje_avance'), 'is_decimal|less_than[100]|greater_than[0]');
		//	$this->form_validation->set_rules('propietarios[]', 'Propietarios', 'trim|xss_clean|required');
				
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(array('status'=>0, 'msg'=>validation_errors()));

			}
			else{

				$id_proyecto = $this->input->post('id_proyecto');
				$datos_proyecto['nombre_proyecto'] = $this->input->post('nombre_proyecto');
				$datos_proyecto['temas_interes'] = $this->input->post('temas_interes');
				$datos_proyecto['visibilidad'] = $this->input->post('visibilidad');
								
				if($this->input->post('descripcion_general') != "") $datos_proyecto['descripcion_general'] = $this->input->post('descripcion_general');
				if($this->input->post('servicios_productos') != "") $datos_proyecto['servicios_productos'] = $this->input->post('servicios_productos');
				if($this->input->post('objetivo') != "") $datos_proyecto['objetivo'] = $this->input->post('objetivo');
				if($this->input->post('sector') != "") $datos_proyecto['sector'] = $this->input->post('sector');
				if($this->input->post('tipo_proyecto') != "") $datos_proyecto['tipo_proyecto'] = $this->input->post('tipo_proyecto');
				if($this->input->post('fuente_financiacion') != "") $datos_proyecto['fuente_financiacion'] = $this->input->post('fuente_financiacion');
				if($this->input->post('poblacion_objetivo') != "") $datos_proyecto['poblacion_objetivo'] = $this->input->post('poblacion_objetivo');
				if($this->input->post('institucion') != "") $datos_proyecto['institucion'] = $this->input->post('institucion');
				if($this->input->post('p_fecha_inicio') != "") $datos_proyecto['fecha_inicio_p'] = $this->input->post('p_fecha_inicio');
				if($this->input->post('p_fecha_fin') != "") $datos_proyecto['fecha_fin_p'] = $this->input->post('p_fecha_fin');
				if($this->input->post('pais') != "") $datos_proyecto['pais'] = $this->input->post('pais');
				if($this->input->post('ciudad') != "") $datos_proyecto['ciudad'] = $this->input->post('ciudad');
				//if($this->input->post('avances') != "") $datos_proyecto['avances'] = $this->input->post('avances');
				if($this->input->post('resultados') != "") $datos_proyecto['resultados'] = $this->input->post('resultados');
				if($this->input->post('lecciones_aprendidas') != "") $datos_proyecto['lecciones_aprendidas'] = $this->input->post('lecciones_aprendidas');
				if($this->input->post('porcentaje_avance') != "") $datos_proyecto['porcentaje_avance'] = $this->input->post('porcentaje_avance');
				
				if(!in_array("",array_values($this->input->post('etiqueta')))) $datos_proyecto['adicionales'] = array_combine($this->input->post('etiqueta'),$this->input->post('valor')); 
				
				$datos_proyecto['propietario']=array();
				if($this->input->post('integrantes') != "") $datos_proyecto['integrantes'] = $this->input->post('integrantes'); 
				if($this->input->post('id_usuario_integrantes') != "") $datos_proyecto['id_usuario_integrantes'] = $this->input->post('id_usuario_integrantes'); 
				if($this->input->post('roles') != "") $datos_proyecto['roles'] = $this->input->post('roles'); 
				if($this->input->post('fecha_inicio') != "") $datos_proyecto['fecha_inicio'] = $this->input->post('fecha_inicio'); 
				if($this->input->post('fecha_fin') != "") $datos_proyecto['fecha_fin'] = $this->input->post('fecha_fin'); 
				if($this->input->post('propietario') != "") $datos_proyecto['propietario'] = $this->input->post('propietario'); 
				
				
				$mensaje = modules::run('proyecto/proyecto_c/_modificar_proyecto',$id_proyecto,$datos_proyecto);
				echo json_encode($mensaje);

			}			
		}		
	}	
		
	function visualizar_mis_proyectos(){
		
		$id_usuario= $this->session->userdata('id_usuario');
		
		$data['proyectos'] = modules::run('usuario/usuario_c/_consultar_proyectos',$id_usuario);
		
		$data['titulo'] =  $this->lang->line('msg_label_mis_proyectos');
		$data['main_content'] = 'interfaz/mis_proyectos_v.php';
		$this->load->view('template', $data);
		
	}
	
	function visualizar_formulario_seguimiento($id_proyecto){
		
		$data['usuarios'] = array();
		$proyecto =modules::run('proyecto/proyecto_c/_consultar_proyecto',$id_proyecto);
		$arreglo_usuarios= modules::run('usuario/usuario_c/_consultar_usuarios');
		$usuarios_proyecto=modules::run('proyecto/proyecto_c/_consultar_usuarios_proyecto',$id_proyecto);
		
		foreach($usuarios_proyecto['integrante'] as $llave => $usuario){
			
			array_push($data['usuarios'],array("id"=>$usuario['id_usuario'] ,"name"=>$usuario['nombre_completo']));			

		}
		
		$data['titulo'] =  $this->lang->line('msg_label_crear_seguimiento');
		$data['id_proyecto'] = $id_proyecto;
		$data['main_content'] = 'interfaz/crear_seguimiento_v.php';
		$this->load->view('template', $data);
		
	}
	
	function visualizar_formulario_contabilidad($id_proyecto){

		$data['lista_tipo_contabilidad'] = $this->lang->line('lista_tipo_contabilidad');
		$data['titulo'] =  $this->lang->line('msg_label_crear_contabilidad');
		$data['main_content'] = 'interfaz/crear_contabilidad_v.php';
		$this->load->view('template', $data);
		
	}
	
	function crear_seguimiento(){
		
		if($this->input->is_ajax_request()){
	
			$this->form_validation->set_rules('descripcion', $this->lang->line('msg_label_description'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('id_proyecto',$this->lang->line('msg_label_id_proyecto'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('id_usuario_responsable', $this->lang->line('msg_label_responsable'), 'trim|xss_clean|required');
			
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(array('status'=>0, 'msg'=>validation_errors()));

			}
			else{
				
				$id_proyecto = $this->input->post('id_proyecto');
				$proyecto =modules::run('proyecto/proyecto_c/_consultar_proyecto',$id_proyecto);
				$id_usuario= $this->session->userdata('id_usuario');
				$usuarios_proyecto=modules::run('proyecto/proyecto_c/_consultar_usuarios_proyecto',$id_proyecto);
				$integrantes_validacion = array();
				
				if(count($usuarios_proyecto['propietario'])>0 ){
			
					foreach($usuarios_proyecto['propietario'] as $usuario_proyecto){
				
						array_push($integrantes_validacion,$usuario_proyecto['id_usuario']);
					}
				}
				
				//Se verifica si el usuario es propietario del proyecto para realizar el seguimiento
				if(in_array($id_usuario,array_values($integrantes_validacion))){
					
					$datos['descripcion'] = $this->input->post('descripcion');
					$datos['responsable'] = $this->input->post('responsable');
					$datos['id_usuario_responsable'] = $this->input->post('id_usuario_responsable');
					$datos['archivos'] = array_combine($this->input->post('file_name_documentos_seguimiento'),$this->input->post('desc_documentos_seguimiento'));
					

					$mensaje = modules::run('proyecto/proyecto_c/_crear_seguimiento',$id_proyecto,$datos);
					echo json_encode($mensaje);
					
					
				}
			}	
		}
	}
	
	function crear_contabilidad(){
		
		if($this->input->is_ajax_request()){
			
			$this->form_validation->set_rules('detalle', $this->lang->line('msg_label_detalle'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('valor', $this->lang->line('msg_label_valor'), 'trim|xss_clean|required|is_decimal');
			$this->form_validation->set_rules('fecha', $this->lang->line('msg_label_fecha'), 'trim|xss_clean|required');
			$this->form_validation->set_rules('tipo', $this->lang->line('msg_label_tipo'), 'trim|xss_clean|required');
			
			if ($this->form_validation->run($this) == FALSE)
			{
				echo json_encode(array('status'=>0, 'msg'=>validation_errors()));

			}
			else{
				
				$id_proyecto = $this->input->post('id_proyecto');
				$proyecto =modules::run('proyecto/proyecto_c/_consultar_proyecto',$id_proyecto);
				$id_usuario= $this->session->userdata('id_usuario');
				$usuarios_proyecto=modules::run('proyecto/proyecto_c/_consultar_usuarios_proyecto',$id_proyecto);
				$integrantes_validacion = array();
				
				if(count($usuarios_proyecto['propietario'])>0 ){
			
					foreach($usuarios_proyecto['propietario'] as $usuario_proyecto){
				
						array_push($integrantes_validacion,$usuario_proyecto['id_usuario']);
					}
				}
				
				//Se verifica si el usuario es propietario del proyecto para realizar el seguimiento
				if(in_array($id_usuario,array_values($integrantes_validacion))){
					
					$datos['detalle'] = $this->input->post('detalle');
					$datos['valor'] = $this->input->post('valor');
					$datos['fecha'] = $this->input->post('fecha');
					$datos['tipo'] = $this->input->post('tipo');

					$mensaje = modules::run('proyecto/proyecto_c/_crear_contabilidad',$id_proyecto,$datos);
					echo json_encode($mensaje);
					
					
				}
			}	
		}
	}

	function solicitar_asociacion(){
		
		$id_usuario_from=$id_usuario= $this->session->userdata('id_usuario');
		$id_proyecto=$this->input->post('id_proyecto');
		
		$mensaje = modules::run('notificacion/notificacion_c/_crear_solicitud',$id_usuario,$id_proyecto);
		echo json_encode($mensaje);
	}
	
	function marcar_notificacion(){
		
		$notificacion['id_notificacion'] = $this->input->post('id_notificacion');
		$notificacion['accion'] = $this->input->post('accion');
		
		$mensaje = modules::run('notificacion/notificacion_c/_marcar_notificacion',$notificacion);
		echo json_encode($mensaje);
	}
	
	function gestionar_asociacion(){
		
		$asociacion=array();
		$id_notificacion = $this->input->post('id_notificacion');
		$asociacion['id_usuario'] = $this->input->post('id_usuario');
		$asociacion['id_proyecto'] = $this->input->post('id_proyecto');
		$asociacion['rol'] = $this->input->post('rol');
		$asociacion['nombre_proyecto'] = $this->input->post('nombre_proyecto');
		$asociacion['nombre_completo'] = $this->input->post('nombre_completo');
		$asociacion['fecha_inicio'] = $this->input->post('fecha_inicio');
		$asociacion['fecha_fin'] = $this->input->post('fecha_fin');
		if($this->input->post('es_propietario')== "on" || $this->input->post('es_propietario')== "Sí")
			$asociacion['es_propietario'] = true;
		else
			$asociacion['es_propietario'] = false;
		
 		modules::run('notificacion/notificacion_c/_gestionar_asociacion',$asociacion);

		$notificacion['id_notificacion'] = $id_notificacion;
		$mensaje = modules::run('notificacion/notificacion_c/_marcar_notificacion',$notificacion);
		
		//TODO enviar correos
//		
		
		echo json_encode($mensaje);
	}
	
	function correo(){
		echo modules::run('correo/correo_c/_enviar_correo',"arcam2@gmail.com","Asunto corr","Mensaje");

	}

}