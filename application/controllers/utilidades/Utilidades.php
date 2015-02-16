<?php

class Utilidades extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function hola($dd)
	{
		echo $dd;
	}
	function _tiempo_transcurrido($time)
	{
		
		
		//$periods = array("segundo", "minuto", "hora", "día", "semadna", "meses", "año", "decada");
		$periods =   $this->lang->line('lista_periodos');
   		$lengths = array("60","60","24","7","4.35","12","10");
		$now = time();
		
		$difference     = $now - $time;
		$tense         = "ago";

		for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
			$difference /= $lengths[$j];
		}

	   $difference = round($difference);

	   if($difference != 1) {
		   $periods[$j].= "s";
	   }

	   return "$difference $periods[$j]";
	}
}
?>