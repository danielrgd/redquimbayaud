<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notificacion_c extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('notificacion_m');
	}
	
	function _crear_solicitud($id_usuario_from, $id_proyecto){
		
		$datos_notificacion['id_usuario_to']= array();
		$datos_notificacion['tipo']="solicitud";
		$datos_notificacion['id_usuario_from']=$id_usuario_from;
		$datos_notificacion['leida'] = '0';
		
		$usuarios_proyecto=modules::run('proyecto/proyecto_c/_consultar_usuarios_proyecto',$id_proyecto);

		
		foreach( $usuarios_proyecto['propietario'] as $key => $propietario){
			
			if($propietario['es_propietario']){
				array_push($datos_notificacion['id_usuario_to'],$propietario['id_usuario']);
			}
		}
		
		$datos_notificacion['fecha']=date("Y-m-d H:i:s");
		
		$datos_usuario_from = modules::run('usuario/usuario_c/_consultar_usuario',$id_usuario_from);
		$nombre_completo_from=$datos_usuario_from[0]['nombre_completo'];
		$datos_proyecto =modules::run('proyecto/proyecto_c/_consultar_proyecto',$id_proyecto);
		$nombre_proyecto=$datos_proyecto[0]['nombre_proyecto'];
		
		//Crear Tipo Asociación (Like a map)
		$claves_asociacion = array('id_usuario','nombre_completo','id_proyecto','nombre_proyecto');
		$valores_asociacion = array($id_usuario_from,$nombre_completo_from,$id_proyecto,$nombre_proyecto);
		$asociacion=array_combine($claves_asociacion,$valores_asociacion);
		
		$datos_notificacion['mensaje']=$nombre_completo_from." ha solicitado asociación al proyecto ".$nombre_proyecto;
		$datos_notificacion['asociacion']=$asociacion;

		$this->notificacion_m->insertar_notificacion($datos_notificacion);
		
		//Enviar correo
		$correo=array();
		foreach( $datos_notificacion['id_usuario_to'] as $propietario){
			
			$datos_usuario_to = modules::run('usuario/usuario_c/_consultar_usuario',$propietario);
			array_push($correo,$datos_usuario_to[0]['correo']);
		}
		$correo=implode(", ",$correo);
		$asunto="Red Quimbaya-UD - ".$nombre_completo_from." ha solicitado asociación al proyecto ".$nombre_proyecto;
		$mensaje="Un saludo de Red Quimbaya-UD!\n\nEl usuario ".$nombre_completo_from." ha solicitado asociacion al proyecto ".$nombre_proyecto."\nPor favor acceda a las notificaciones en la plataforma si desea realizar la asociación\n\n".site_url()."\n\nSe ha enviado este correo automáticamente por ser propietario del proyecto.\n\nCordial saludo,\n\nEl equipo Red Quimbaya-UD";
		
		echo modules::run('correo/correo_c/_enviar_correo',$correo,$asunto,$mensaje);

	}
	
	function _crear_invitacion($id_usuario_from, $datos_asociacion){
		
		$datos_notificacion['asociacion']=$datos_asociacion;
		$datos_notificacion['fecha']=date("Y-m-d H:i:s");
		$datos_notificacion['id_usuario_from']=$id_usuario_from;
		$datos_notificacion['id_usuario_to']=array($datos_asociacion['id_usuario']);
		$datos_notificacion['leida'] = '0';		
		$datos_notificacion['mensaje']="Ha sido invitado al proyecto ".$datos_asociacion['nombre_proyecto'];
		$datos_notificacion['tipo']="invitacion";
		
		$this->notificacion_m->insertar_notificacion($datos_notificacion);
		
		//Enviar correo
		$correo=array();
		foreach( $datos_notificacion['id_usuario_to'] as $integrante){
			
			$datos_usuario_to = modules::run('usuario/usuario_c/_consultar_usuario',$integrante);
			array_push($correo,$datos_usuario_to[0]['correo']);
		}
		$nombre_proyecto=$datos_asociacion['nombre_proyecto'];
		$correo=implode(", ",$correo);
		$asunto="Red Quimbaya-UD - Ha sido invitado al proyecto ".$nombre_proyecto;
		$mensaje="Un saludo de Red Quimbaya-UD!\n\nEl propietario del proyecto ".$nombre_proyecto." lo ha invitado a ser integrante del mismo\nPor favor acceda a las notificaciones en la plataforma si desea aceptar la asociación\n\n".site_url()."\n\nSe ha enviado este correo automáticamente como parte de la invitación.\n\nCordial saludo,\n\nEl equipo Red Quimbaya-UD";
		
		echo modules::run('correo/correo_c/_enviar_correo',$correo,$asunto,$mensaje);
	}
	
	function _crear_notificacion_usuario($id_usuario_to,$mensaje,$id_usuario_from){
			
		$datos_notificacion['id_usuario_to']= array($id_usuario_to);
		$datos_notificacion['tipo']="notificacion_usuario";
		$datos_notificacion['id_usuario_from']=$id_usuario_from;
		$datos_notificacion['leida'] = '0';
		$datos_notificacion['fecha']=date("Y-m-d H:i:s");
		
		$datos_notificacion['mensaje']=$mensaje;

		$this->notificacion_m->insertar_notificacion($datos_notificacion);
		
		//Enviar correo
		$correo=array();
		foreach( $datos_notificacion['id_usuario_to'] as $integrante){
			
			$datos_usuario_to = modules::run('usuario/usuario_c/_consultar_usuario',$integrante);
			array_push($correo,$datos_usuario_to[0]['correo']);
		}
		$correo=implode(", ",$correo);
		$asunto="Red Quimbaya-UD - ".$mensaje;
		$mensaje="Un saludo de Red Quimbaya-UD!\n\nSe ha registrado la siguiente actividad en su perfil de usuario:\n\n".$mensaje."\nPor favor acceda a las notificaciones en la plataforma para ver el detalle\n\n".site_url()."\n\nSe ha enviado este correo automáticamente como parte de la notificación.\n\nCordial saludo,\n\nEl equipo Red Quimbaya-UD";
		
		echo modules::run('correo/correo_c/_enviar_correo',$correo,$asunto,$mensaje);

	}
	
	function _crear_notificacion_proyecto($id_proyecto,$nombre_proyecto,$mensaje,$id_usuario_from){
			
		$datos_notificacion['id_usuario_to']= array($usuario);
		$usuarios_proyecto=modules::run('proyecto/proyecto_c/_consultar_usuarios_proyecto',$id_proyecto);
		
		foreach( $usuarios_proyecto['propietario'] as $key => $propietario){
			
			if($propietario['es_propietario']){
				array_push($datos_notificacion['id_usuario_to'],$propietario['id_usuario']);
			}
		}

		$datos_notificacion['tipo']="notificacion_proyecto";
		$datos_notificacion['id_usuario_from']=$id_usuario_from;
		$datos_notificacion['leida'] = '0';
		$datos_notificacion['fecha']=date("Y-m-d H:i:s");		
		$datos_notificacion['mensaje']=$mensaje;

		$this->notificacion_m->insertar_notificacion($datos_notificacion);
		
		//Enviar correo
		$correo=array();
		foreach( $datos_notificacion['id_usuario_to'] as $integrante){
			
			$datos_usuario_to = modules::run('usuario/usuario_c/_consultar_usuario',$integrante);
			array_push($correo,$datos_usuario_to[0]['correo']);
		}
		$nombre_proyecto=$datos_asociacion['nombre_proyecto'];
		$correo=implode(", ",$correo);
		$asunto="Red Quimbaya-UD - ".$mensaje;
		$mensaje="Un saludo de Red Quimbaya-UD!\n\nSe ha registrado la siguiente actividad en el perfil del proyecto ".$nombre_proyecto.":\n\n".$mensaje."\nPor favor acceda a las notificaciones en la plataforma para ver el detalle\n\n".site_url()."\n\nSe ha enviado este correo automáticamente por ser propietario del proyecto.\n\nCordial saludo,\n\nEl equipo Red Quimbaya-UD";
		
		echo modules::run('correo/correo_c/_enviar_correo',$correo,$asunto,$mensaje);

	}
	
	function _consultar_notificaciones_activas($id_usuario){
			
		$notificaciones = $this->notificacion_m->consultar_notificaciones($id_usuario);
		
		foreach($notificaciones as $key => $notificacion){
			
			if($notificacion['leida'] == "true"){
				
				unset($notificaciones[$key]);
			}
			
		}
		
		return $notificaciones;
		
	}
	
	function _marcar_notificacion($notificacion){

		$notificaciones = $this->notificacion_m->marcar_notificacion($notificacion);
		
		return $notificaciones;
		
	}
	
	function _gestionar_asociacion($datos_asociacion){
		
		$this->notificacion_m->insertar_relacion_asociacion($datos_asociacion);
		
	}
	
}