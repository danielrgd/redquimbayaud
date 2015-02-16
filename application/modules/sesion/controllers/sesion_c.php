<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sesion_c extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
	}
	
    /**
    * 
    * 
    * @return void
    */	
	function _crear_sesion($datos_personales){		
		$newdata = array(
                   'id_usuario'  => $datos_personales['id_usuario'],
				   'nombre_completo'  => $datos_personales['nombre_completo'],
					'ruta_foto_perfil'  => $datos_personales['ruta_foto_perfil'],
					'language' => $datos_personales['idioma_perfil'],
                   'logged_in' => TRUE
               );

		$this->session->set_userdata($newdata);

	}
	
	function _cerrar_sesion (){
		
		$this->session->sess_destroy();
	}
}