<div class="container">
	<div class="row">
		<div class="col-md-6 text-center" style="">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="form-group">
						<img src="<?php echo base_url("uploads/images/".$usuario[0]['ruta_foto_perfil']); ?>" class="img-circle img-responsive">
					</div>
					<div class="form-group">
							<?php echo $this->lang->line('msg_label_Calificacion_promedio').":"; ?> <input id="usuario_rating" type="number" >
					</div>
				</div>
			</div>
        </div>
        <div class="col-md-6">
			 <div class="panel with-nav-tabs panel-default">
				<div class="panel-heading">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#informacion_basica" data-toggle="tab"><?php echo $this->lang->line('msg_label_informacion_basica'); ?></a></li>
							<?php 
								if ( $this->session->userdata('logged_in') &&  ($usuario[0]['privacidad']== "Publico" )){ //TODO validar acceso del propietario del proyecto?
							?>
								<li><a href="#informacion_avanzada" data-toggle="tab"><?php echo $this->lang->line('msg_label_informacion_avanzada'); ?></a></li>
							<?php 
								}
							?>
						</ul>
				</div>
			<!-- Tab panes -->
			<div class="panel-body">
				<div class="tab-content">
					<div class="tab-pane fade in active" id="informacion_basica">	
						<ul class="list-group">
							<li class="list-group-item"><?php echo $this->lang->line('msg_label_nombre_completo').": ". $usuario[0]['nombre_completo']; ?> </li>
							<?php 
								if(isset($proyectos['integrante'])){
									
									echo "<li class='list-group-item'>".$this->lang->line('msg_label_proyectos');
									echo "<ul>";
									foreach($proyectos['integrante'] as $proyecto){
							?>
									<li><?php echo "<a href=". site_url() ."/interfaz/visualizar_proyecto/".$proyecto['id_proyecto'].">".$proyecto['nombre_proyecto']."</a>"; ?> </li>	
									
							<?php
									}
									echo "</ul>";
									echo "</li>";
									
								}
							?>
							<li class="list-group-item"><?php echo $this->lang->line('msg_label_temas_interes')?>:
								<ul>
								<?php foreach($usuario[0]['temas_interes'] as $tema_interes){
									?>
									<li><?php echo "<a href=". site_url() ."/interfaz/visualizar_tema_interes/".urlencode($tema_interes).">".$tema_interes."</a>"; ?> </li>
								<?php
								}
								?>
								</ul>
							</li>

						</ul>
					</div>

					 <?php

					if ( $this->session->userdata('logged_in') &&  ($usuario[0]['privacidad']== "Publico" )){ //TODO validar acceso del propietario del proyecto?
				?>
					<div class="tab-pane fade" id="informacion_avanzada">
						<ul class="list-group">
							<li class="list-group-item"><?php echo $this->lang->line('msg_label_fecha_nacimiento').": ". date("d/m/Y",$usuario[0]['fecha_nacimiento']); ?> </li>
							<li class="list-group-item"><?php echo $this->lang->line('msg_label_correo').": ". $usuario[0]['correo']; ?> </li>
							<li class="list-group-item"><?php echo $this->lang->line('msg_label_profesion').": ". $usuario[0]['profesion']; ?></li>
							<li class="list-group-item"><?php echo $this->lang->line('msg_label_estudios') ?>:
								<ul>
								<?php foreach($usuario[0]['estudios'] as $institucion => $titulo ){

								?>

									<li><?php echo $institucion."-".$titulo; ?> </li>

								<?php
									}
								?>
								</ul>
							</li>
							<li class="list-group-item"><?php echo $this->lang->line('msg_label_idiomas').": ".implode(", ",$usuario[0]['idiomas']); ?></li>
							<li class="list-group-item"><?php echo $this->lang->line('msg_label_ubicacion').": (".$lista_paises[$usuario[0]['pais']].",".$usuario[0]['ciudad'].")" ?> </li>
							<li class="list-group-item"><?php echo $this->lang->line('msg_label_adicionales') ?> 
								<ul>
								<?php if(isset($usuario[0]['adicionales'] )){
										 foreach($usuario[0]['adicionales'] as $clave => $valor ){

								?>

										<li><?php echo $clave."-".$valor; ?> </li>

									<?php
										 }
									}
									?>
								</ul>
							</li>
						</ul>
					</div>
			<?php	
				}
			?>
				</div>
       		</div>
		</div>
	</div>
    <div class="row">
		<div class="col-md-12">
          <hr>
        </div>
	</div>
	
					<?php 
								if ( $this->session->userdata('logged_in') &&  $usuario[0]['id_usuario'] != $this->session->userdata('id_usuario')){ //TODO validar acceso del propietario del proyecto?
							?>
								<?php echo form_open('interfaz/interfaz_c/calificar_usuario',array('id'=>'calificar_usuario','class'=>'form-horizontal')); ?>
								<div class="form-group">
									<input type="hidden" id="usuario_to_ca" name="usuario_to_ca" value="<?php echo $usuario[0]['id_usuario'] ?>" >
									<div class="row">
										<div class="col-md-10 col-md-offset-1">
											<div class="form-group">	
												<label class="control-label col-md-1" for="calificacion"><?php echo $this->lang->line('msg_label_calificar'); ?>:</label>
												<div class="col-md-4">	

													<input id="usuario_calificar" type="number" > 
												</div>
											</div>
										</div>
									</div>
								</div>
								<?php echo form_close(); ?>  
					<?php }
					?>
	
	<div class="row">
		<div class="col-md-12">
			<div class="container">
				<div class="row"></div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title" draggable="true"><?php echo $this->lang->line('msg_label_comentarios'); ?></h3>
							</div>
							<div class="panel-body">
								<?php 
									if ( $this->session->userdata('logged_in') &&  $usuario[0]['id_usuario'] != $this->session->userdata('id_usuario')){ //TODO validar acceso del propietario del proyecto?
								?>
									<?php echo form_open('interfaz/interfaz_c/comentar_usuario',array('id'=>'form_comentar_usuario','class'=>'form-horizontal')); ?>
										<div class="row">
											<div class="col-md-1 col-md-offset-1">
												<img src="<?php echo base_url("uploads/images/".$this->session->userdata('ruta_foto_perfil') ); ?>" class="img-circle img-responsive">
												 <input type="hidden" id="ruta_foto_perfil_usuario_from" name="ruta_foto_perfil_usuario_from" value="<?php echo base_url("uploads/images/".$this->session->userdata('ruta_foto_perfil') ); ?>" >
												 <input type="hidden" id="usuario_to" name="usuario_to" value="<?php echo $usuario[0]['id_usuario'] ?>" >
											</div>
											<div class="col-md-4">

												<textarea id="comentario" name="comentario" rows ="3" cols ="50"></textarea>
											</div>
											<div class="col-md-1 col-md-offset-1">
												<button type="button" class="btn btn-default" id="boton_comentar_usuario" name="comentar" ><?php echo $this->lang->line('msg_label_comentar'); ?></button>
											</div>
										</div>
									<?php echo form_close(); ?>  
									<hr>
								<?php 
									}
								?>
								<div id="div_comentarios">
									
									<?php 
											//foreach($comentarios as $usuario ){
											if(count($comentarios )>0){
												foreach($comentarios as $comentario){ 
									?>	
													<div class="row">
														<div class="col-md-1 col-md-offset-1">
															<a href="<?php echo site_url() ."/interfaz/visualizar_usuario/".$comentario['id_usuario_from'] ?>"> <img src="<?php echo base_url("uploads/images/".$comentario['ruta_foto']); ?>" class="img-circle img-responsive"></a>
														</div>
														<div class="col-md-9">
															<p><?php echo $comentario['comentario']; ?></p>
															<small><a href="<?php echo site_url() ."/interfaz/visualizar_usuario/".$comentario['id_usuario_from'] ?>"><?php echo $comentario['nombre_completo_from'] ."</a> ".str_replace("{fecha}",modules::run('utilidades/utilidades/_tiempo_transcurrido',$comentario['fecha']),$this->lang->line('msg_label_fecha_comentario')); ?></small>
														</div>
													</div>
													<hr>
									<?php
												}												
											}
											//}
									?>
									
								</div>								
							</div>
							<?php 
								if(count($comentarios) >4){
							?>
								<div class="panel-footer">
									<div class="center-block">
										<button type="button" class="btn btn-default" id="mostrar_mas_comentarios"><?php echo $this->lang->line('msg_label_mostrar_mas'); ?></button>
									</div>

								</div>
							<?php
								}
							?>
					</div>
				</div>
			</div>
		<div class="row"></div>
	</div>
</div>
