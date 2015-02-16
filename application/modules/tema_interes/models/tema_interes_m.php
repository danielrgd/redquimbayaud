<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tema_interes_m extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}
	
    /**
    * Check if the user is logged in, if he's not, 
    * send him to the login page
    * @return void
    */	
	function consultar_tema_interes($tema_interes){
	
		$resultado['usuarios'] = array();
		$resultado['proyectos'] = array();
		
		$arreglo_usuarios=$this->db->db->query("select asociados from temas_interes WHERE descripcion='".$tema_interes."' AND tipo='usuario'");
		foreach($arreglo_usuarios as $usuario){
			array_push($resultado['usuarios'],$usuario['asociados']);
		}

		$arreglo_proyectos=$this->db->db->query("select asociados from temas_interes WHERE descripcion='".$tema_interes."' AND tipo='proyecto'"); 
		foreach($arreglo_proyectos as $proyecto){
			array_push($resultado['proyectos'],$proyecto['asociados']);
		}

		return $resultado;
	
	}
	
	function consultar_temas_interes_tipo($tipo){
		//tipo=usuario|proyecto
	
		$resultado = $this->db->db->query("select descripcion from temas_interes WHERE tipo='".$tipo."' ALLOW FILTERING"); 

		return $resultado;
	
	}

}