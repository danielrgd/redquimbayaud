<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Correo_c extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('email');
	}
	
    /**
    * 
    * 
    * @return void
    */	
	function _enviar_correo($direccion_correo, $asunto, $mensaje){
		$this->email->newline  = "\r\n";
		
		$this->email->from("no-responder@quimbayaud.com", 'Red Quimbaya-UD');
//		$this->email->reply_to('arcam2@gmail.com, danielrgd@gmail.com, malejandrosalamanca@gmail.com', 'Da Team');
		$this->email->reply_to('arcam2@gmail.com', 'Da Team');
		$this->email->to($direccion_correo);
		//$this->email->cc('otro@otro-ejemplo.com'); 
		//$this->email->bcc('ellos@su-ejemplo.com'); 
		
		$this->email->subject($asunto);
		$this->email->message($mensaje);

		$this->email->send();
		
		return $this->email->print_debugger();

	}
	
}