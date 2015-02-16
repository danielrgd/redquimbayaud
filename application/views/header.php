<!DOCTYPE html> 
<html>
<head>
  	<title><?php echo $titulo ?></title>
  	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="<?php echo base_url('css/jquery-ui-1.10.4.min.css'); ?>" rel="stylesheet"  media="all" type="text/css"> 
 	<link href="<?php echo base_url('css/bootstrap.css'); ?>" rel="stylesheet"  media="all" type="text/css">
 	<link href="<?php echo base_url('css/bootstrap.css.map'); ?>" rel="stylesheet"  media="all" type="text/css">
 	<link href="<?php echo base_url('css/jquery.jqplot.min.css'); ?>" rel="stylesheet"  media="all" type="text/css">
 	<link href="<?php echo base_url('css/custom.css'); ?>" rel="stylesheet"  media="all" type="text/css">
	<link href="<?php echo base_url('css/jquery.tagit.css'); ?>" rel="stylesheet"  media="all" type="text/css">
	<link href="<?php echo base_url('css/star-rating.min.css'); ?>" rel="stylesheet"  media="all" type="text/css">
	<link href="<?php echo base_url('css/fileinput.min.css'); ?>" rel="stylesheet"  media="all" type="text/css">
   
	 <style>
        body{padding-top:70px}
      </style>
 </head>

  <body>
    <div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			  <a class="navbar-brand" href="<?php echo site_url(); ?>" draggable="true">Red Quimbaya-UD</a>
			</div>
			<div class="collapse navbar-collapse navbar-ex1-collapse">
			  	<?php echo form_open('interfaz/buscar_perfiles_por_palabras_clave',array('id'=>'formulario_palabras_clave','class'=>'navbar-form navbar-left text-justify')); ?>
				<div class="form-group">
				  <input type="text" class="form-control" id="palabras_clave" name="palabras_clave" placeholder="<?php echo $this->lang->line('msg_label_buscar'); ?>">
				</div>
				<button type="submit" class="btn btn-default"><?php echo $this->lang->line('msg_label_enviar'); ?></button>
			  <?php echo form_close(); ?>  

<?php 
	//Si no se ha iniciado sesion se muestran los botonoes iniciar sesion y crear cuenta
	if ( !$this->session->userdata('logged_in')){
?>
		
			<a class="btn btn-primary btn-sm navbar-btn navbar-right" data-target="#modal_iniciar_sesion" data-toggle="modal"><?php echo $this->lang->line('msg_label_iniciar_sesion'); ?></a>
			<a class="btn btn-primary btn-sm navbar-btn navbar-right" href="<?php echo site_url(); ?>/interfaz/formulario_registro" ><?php echo $this->lang->line('msg_label_crear_cuenta'); ?></a>
<?php
	}
	else{
		
		$notificaciones= modules::run('notificacion/notificacion_c/_consultar_notificaciones_activas',$this->session->userdata('id_usuario'));
	//Si existe una sesion se muestran las notificaciones y configuración del usuario

		form_open('interfaz/crear_cuenta',array('id'=>'form_crear_cuenta','class'=>'form-horizontal'));
?>	
				
				<ul class="nav navbar-nav navbar-right">
				<li class="dropdown" id="lista_notificaciones">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $this->lang->line('msg_label_notificaciones'); ?> 
						<span class="badge" id ="notificaciones_sin_leer"><?php echo count($notificaciones); ?></span>
						<span class="caret"></span>
					</a>
					<?php 	if(count($notificaciones) > 0 ){
		
								echo "<ul class='dropdown-menu' role='menu'>";
								$contador = 0; 
			//echo "<pre>".print_r($notificaciones)."</pre>";
								foreach($notificaciones as $key => $notificacion){

									echo "<li>";
									
									if($notificacion['tipo'] == "invitacion"){
										
										echo "<input type='hidden' id='id_usuario_".$contador."' name='id_usuario[]' value='".$notificacion['asociacion']['id_usuario']."' >";
										echo "<input type='hidden' id='id_proyecto_".$contador."' name='id_proyecto[]' value='".$notificacion['asociacion']['id_proyecto']."' >";
										echo "<input type='hidden' id='nombre_proyecto_".$contador."' name='nombre_proyecto[]' value='".$notificacion['asociacion']['nombre_proyecto']."' >";
										echo "<input type='hidden' id='nombre_completo_".$contador."' name='nombre_completo[]' value='".$notificacion['asociacion']['nombre_completo']."' >";
										echo "<input type='hidden' id='es_propietario_".$contador."' name='es_propietario[]' value='".$notificacion['asociacion']['es_propietario']."' >";
										echo "<input type='hidden' id='rol_".$contador."' name='rol[]' value='".$notificacion['asociacion']['rol']."' >";
										echo "<input type='hidden' id='fecha_inicio_".$contador."' name='fecha_inicio[]' value='".$notificacion['asociacion']['fecha_inicio']."' >";
										echo "<input type='hidden' id='fecha_fin_".$contador."' name='fecha_fin[]' value='".$notificacion['asociacion']['fecha_fin']."' >";
										echo "<input type='hidden' id='tipo_".$contador."' name='tipo[]' value='invitacion' >";
										
										echo "<a href='#'>".$notificacion['mensaje'];
										echo "<button type='button' class='btn btn-default btn-sm' id='aceptar_".$contador."' name='aceptar[]' value='aceptar'>";
										echo "<span class='glyphicon glyphicon-ok'></span>";
										echo "</button>";
										
									}
									else if ($notificacion['tipo'] == "solicitud"){
									
										echo "<input type='hidden' id='id_usuario_".$contador."' name='id_usuario[]' value='".$notificacion['asociacion']['id_usuario']."' >";
										echo "<input type='hidden' id='id_proyecto_".$contador."' name='id_proyecto[]' value='".$notificacion['asociacion']['id_proyecto']."' >";
										echo "<input type='hidden' id='nombre_proyecto_".$contador."' name='nombre_proyecto[]' value='".$notificacion['asociacion']['nombre_proyecto']."' >";
										echo "<input type='hidden' id='nombre_completo_".$contador."' name='nombre_completo[]' value='".$notificacion['asociacion']['nombre_completo']."' >";
										echo "<input type='hidden' id='tipo_".$contador."' name='tipo[]' value='solicitud' >";
									
										echo "<a href='#'>".$notificacion['mensaje'];
										echo "<button type='button' class='btn btn-default btn-sm' id='aceptar_".$contador."' name='aceptar[]' value='aceptar'>";
										echo "<span class='glyphicon glyphicon-ok'></span>";
										echo "</button>";
										
									}
									else if($notificacion['tipo'] == "notificacion_usuario"){
										echo "<a href=".site_url()."/interfaz/visualizar_usuario/".$notificacion['id_usuario_to'][0].">".$notificacion['mensaje'];
										
									}
									
									else if($notificacion['tipo'] == "notificacion_proyecto"){
										echo "<a href=".site_url()."/interfaz/visualizar_proyecto/".$notificacion['asociacion']['id_proyecto'].">".$notificacion['mensaje'];
										
									}
									
									?>
										
											<button type="button" class="btn btn-default btn-sm" id="eliminar_<?php echo $contador; ?>" name="eliminar[]" value="eliminar">
											<span class="glyphicon glyphicon-remove"></span>
											</button>
										</a>
									
										 <input type="hidden" id="id_notificacion_<?php echo $contador; ?>" name="id_notificacion[]" value="<?php echo $notificacion['id_notificacion'];?> ">
									</li>
					<?php		}
								echo "</ul>";
							}
		 				form_close(); 
					?>	
				
				</li>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <?php echo $this->session->userdata('nombre_completo'); ?> <span class="caret"></span></a>
				  <ul class="dropdown-menu" role="menu">
					<li>
						<a href="<?php echo site_url()."/interfaz/visualizar_usuario/".$this->session->userdata('id_usuario'); ?>">
							<p class="text-center"><?php echo $this->lang->line('msg_label_mi_perfil'); ?></p>
						   <img src="<?php echo base_url("uploads/images/".$this->session->userdata('ruta_foto_perfil') ); ?>" class="img-circle center-block"  width="110" height="120"></li>
							
					  	</a>
					</li>
					<li class="divider"></li>
					<li><a href="<?php echo site_url()."/interfaz/visualizar_formulario_perfil/".$this->session->userdata('id_usuario'); ?>"><?php echo $this->lang->line('msg_label_actualizar_perfil'); ?></a></li>
					<li><a href="<?php echo site_url()."/interfaz/visualizar_opciones_cuenta/".$this->session->userdata('id_usuario'); ?>"><?php echo $this->lang->line('msg_label_modificar_opciones_cuenta'); ?></a></li>
					<li class="divider"></li>
					<li><a href="<?php echo site_url()."/interfaz/visualizar_mis_proyectos" ?>"><?php echo $this->lang->line('msg_label_mis_proyectos'); ?></a></li>
					<li class="divider"></li>
					<li><a href="<?php echo site_url(); ?>/interfaz/interfaz_c/cerrar_sesion"><?php echo $this->lang->line('msg_label_salir'); ?></a></li>
				  </ul>
				</li>
			</ul>
<?php	
	}
?>
			</div>
		</div>
	</div>