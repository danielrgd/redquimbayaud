<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tema_interes_c extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('tema_interes_m');
	}
	
	function _consultar_tema_interes($tema_interes){
		$resultado = $this->tema_interes_m->consultar_tema_interes($tema_interes);
		return $resultado;
	}
	
	function _consultar_temas_interes_tipo($tipo){
		$resultado = $this->tema_interes_m->consultar_temas_interes_tipo($tipo);
		return $resultado;
	}
	
}