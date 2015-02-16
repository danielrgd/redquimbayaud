<div class="container">
	<div class="row">
        <div class="col-md-10">
			<div class="form-group">
				<?php 
					if($this->session->userdata('logged_in')){
						if(in_array($this->session->userdata('id_usuario'),array_values($propietarios_proyecto))){	
					?>				
						<a href="<?php echo site_url("/interfaz/interfaz_c/visualizar_formulario_proyecto/".$proyecto[0]['id_proyecto']) ?>" class="btn btn-default btn-sm" id="editar_proyecto">
							<span class="glyphicon glyphicon-pencil"></span>
						</a>

					<?php
						}
						if(!in_array($this->session->userdata('id_usuario'),array_values($integrantes_validacion))){
					?>
							<button type="button" class="btn btn-default" id="boton_solicitar_asociacion" name="boton_solicitar_asociacion" ><?php echo $this->lang->line('msg_label_solicitar_asociacion'); ?></button>
					<?php
						}	
					}
				?>
				
			</div>
			<div class="row">
				<div class="col-md-12">
				  <hr>
				</div>
			</div>
	 <div class="panel with-nav-tabs panel-default">
		<div class="panel-heading">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#informacion_basica" data-toggle="tab"><?php echo $this->lang->line('msg_label_informacion_basica'); ?></a></li>
				<?php 
					if ( $this->session->userdata('logged_in') &&  ($proyecto[0]['visibilidad']== "Publico" )){ //TODO validar acceso del propietario del proyecto?
				?>
					<li><a href="#informacion_avanzada" data-toggle="tab"><?php echo $this->lang->line('msg_label_informacion_avanzada'); ?></a></li>
					<li><a href="#seguimientos" data-toggle="tab"><?php echo $this->lang->line('msg_label_seguimientos'); ?></a></li>
					<li><a href="#contabilidad" data-toggle="tab"><?php echo $this->lang->line('msg_label_contabilidad'); ?></a></li>
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
						<li class="list-group-item"><?php echo $this->lang->line('msg_label_id_proyecto').": ". $proyecto[0]['id_proyecto']; ?> </li>
						<li class="list-group-item"><?php echo $this->lang->line('msg_label_nombre_proyecto').": ". $proyecto[0]['nombre_proyecto']; ?> </li>

						<?php 
							if(isset($proyecto[0]['descripcion_general'])){

								echo "<li class='list-group-item'>".$this->lang->line('msg_label_descripcion_general').': '.$proyecto[0]['descripcion_general']."</li>";

							}
							if(isset($proyecto[0]['objetivo'])){

								echo "<li class='list-group-item'>".$this->lang->line('msg_label_objetivo').': '.$proyecto[0]['objetivo']."</li>";

							}						
							if(isset($proyecto[0]['sector'])){

								echo "<li class='list-group-item'>".$this->lang->line('msg_label_sector').': '.$proyecto[0]['sector']."</li>";
							}
							if(isset($proyecto[0]['servicios_productos'])){

								echo "<li class='list-group-item'>".$this->lang->line('msg_label_servicios_productos').': '.$proyecto[0]['servicios_productos']."</li>";
							}
							if(isset($proyecto[0]['tipo_proyecto'])){

								echo "<li class='list-group-item'>".$this->lang->line('msg_label_tipo_proyecto').': '.$proyecto[0]['tipo_proyecto']."</li>";
							}

							echo "<li class='list-group-item'>".$this->lang->line('msg_label_temas_interes').":";
								echo "<ul>";
								foreach($proyecto[0]['temas_interes'] as $tema_interes){

									echo "<li><a href='". site_url() ."/interfaz/visualizar_tema_interes/".$tema_interes."'>".$tema_interes."</a></li>";

								}							
								echo "</ul>";
							echo "</li>";

							if(isset($proyecto[0]['fuente_financiacion'])){

								echo "<li class='list-group-item'>".$this->lang->line('msg_label_fuente_financiacion').': '.$proyecto[0]['fuente_financiacion']."</li>";
							}
							if(isset($proyecto[0]['poblacion_objetivo'])){

								echo "<li class='list-group-item'>".$this->lang->line('msg_label_poblacion_objetivo').': '.$proyecto[0]['poblacion_objetivo']."</li>";
							}
							if(isset($proyecto[0]['institucion'])){

								echo "<li class='list-group-item'>".$this->lang->line('msg_label_institucion').': '.$proyecto[0]['institucion']."</li>";
							}

							if(isset($integrantes)){

								echo "<li class='list-group-item'>".$this->lang->line('msg_label_integrantes');
									echo "<ul>";

									foreach($integrantes as $integrante){

										echo "<li><a href=".site_url() ."/interfaz/visualizar_usuario/".$integrante['id_usuario'].">".$integrante['nombre_completo']."</a> - ".$integrante['rol']." (".date("d-m-Y",$integrante['fecha_inicio'])."/".date("d-m-Y",$integrante['fecha_fin']).") </li>";

									}
									echo "</ul>";
								echo "</li>";
							}						
						?>
					</ul>
				</div>
				<div class="tab-pane fade" id="informacion_avanzada">
					<ul class="list-group">
					<?php 

						if(isset($proyecto[0]['propietarios'])){

							echo "<li class='list-group-item'>".$this->lang->line('msg_label_propietarios');
								echo "<ul>";

								foreach($proyecto[0]['propietarios'] as $id_usuario=>$nombre_completo){

									echo "<li><a href=".site_url() ."/interfaz/visualizar_usuario/".$id_usuario.">".$nombre_completo."</a> </li>";

								}
								echo "</ul>";
							echo "</li>";
						}

						if(isset($proyecto[0]['fecha_inicio'])){

							echo "<li class='list-group-item'>".$this->lang->line('msg_label_fecha_inicio').': '.date("d-m-Y",$proyecto[0]['fecha_inicio'])."</li>";
						}
						if(isset($proyecto[0]['fecha_fin'])){

							echo "<li class='list-group-item'>".$this->lang->line('msg_label_fecha_fin').': '.date("d-m-Y",$proyecto[0]['fecha_fin'])."</li>";
						}
						if(isset($proyecto[0]['porcentaje_avance'])){

							echo "<li class='list-group-item'>".$this->lang->line('msg_label_porcentaje_avance').': '.$proyecto[0]['porcentaje_avance']."</li>";
						}
						if(isset($proyecto[0]['adicionales'] )){

								 foreach($proyecto[0]['adicionales'] as $clave => $valor ){

									echo"<li>".$clave."-".$valor;"</li>";

								 }
						}
					?>
					</ul>
				</div>
				<?php 
				if ( $this->session->userdata('logged_in') &&  ($proyecto[0]['visibilidad']== "Publico" )){ //TODO validar acceso del propietario del proyecto?

				?>
					<div class="tab-pane fade" id="seguimientos">

						<?php
						if(count($seguimientos)>0){
						?>

						<?php 
							foreach($seguimientos as $seguimiento){

						?>
								<li class="list-group-item"><?php echo $this->lang->line('msg_label_descripcion').": ". $seguimiento['descripcion']; ?>
								<br><?php echo $this->lang->line('msg_label_fecha_seguimiento').": ". $seguimiento['fecha_seguimiento']; ?> 	
								<br><?php echo $this->lang->line('msg_label_responsable').": ". $seguimiento['responsable']; ?> 


						<?php 
								if(count($seguimiento['archivos'])>0){

									echo "<br>".$this->lang->line('msg_label_archivos').": ";
									echo "<ul>"	;

									foreach($seguimiento['archivos'] as $key => $value){						

										echo "<li><a href=".base_url() ."/uploads/documents/".$key.">".$value."</a></li>";

									}
									echo "</ul>"	;
								}
							}
								echo "</li>";

						}
						?>
					</div>
					<div class="tab-pane fade" id="contabilidad">
					<?php
					if(count($contabilidad)>0){

						echo "<ul>";

						foreach($contabilidad as $valor_contabilidad){

						?>
							<li class="list-group-item"><?php echo $this->lang->line('msg_label_detalle').": ". $valor_contabilidad['detalle']; ?>
								<br><?php 
										if($valor_contabilidad['tipo'] =='Ingreso') {
											echo "<span class='label label-success'>";
										}
										else{

											echo "<span class='label label-warning'>";
										}
										echo $this->lang->line('msg_label_tipo').": ".$lista_tipo_contabilidad[$valor_contabilidad['tipo']]; ?></span>	
							<br><?php echo $this->lang->line('msg_label_fecha').": ". $valor_contabilidad['fecha']; ?> 
							<br><?php echo $this->lang->line('msg_label_valor').": $ ". number_format($valor_contabilidad['valor']); ?> 
							</li>
						<?php
						}

						echo "</ul>";
					}
					?>
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
	<div class="col-md-10 col-md-offset-1">
		<div class="form-group">	
			<label class="control-label col-md-2" for="calificacion_promedio"><?php echo $this->lang->line('msg_label_Calificacion_promedio'); ?>:</label>
			<div class="col-md-4">	
				<input id="proyecto_rating" type="number" >
			</div>
		</div>
	</div>

	<?php 
			if ( $this->session->userdata('logged_in') ){ //TODO validar acceso del propietario del proyecto?
		?>
			<?php echo form_open('interfaz/interfaz_c/calificar_proyecto',array('id'=>'calificar_proyecto','class'=>'form-horizontal')); ?>
			<div class="form-group">
				<input type="hidden" id="proyecto_to_ca" name="proyecto_to_ca" value="<?php echo $proyecto[0]['id_proyecto'] ?>" >
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<div class="form-group">	
						<label class="control-label col-md-2" for="calificacion"><?php echo $this->lang->line('msg_label_calificar'); ?>:</label>
							<div class="col-md-4">	
								<input id="proyecto_calificar" type="number" > 
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
 //TODO unicamente los propietarios?
									if ( $this->session->userdata('logged_in')){
								?>
									<?php echo form_open('interfaz/interfaz_c/comentar_proyecto',array('id'=>'form_comentar_proyecto','class'=>'form-horizontal')); ?>
										<div class="row">
											<div class="col-md-1 col-md-offset-1">
												<img src="<?php echo base_url("uploads/images/".$this->session->userdata('ruta_foto_perfil') ); ?>" class="img-circle img-responsive">
												 <input type="hidden" id="ruta_foto_perfil_usuario_from" name="ruta_foto_perfil_usuario_from" value="<?php echo base_url("uploads/images/".$this->session->userdata('ruta_foto_perfil') ); ?>" >
												 <input type="hidden" id="proyecto_to" name="proyecto_to" value="<?php echo $proyecto[0]['id_proyecto'] ?>" >
											</div>
											<div class="col-md-4">

												<textarea id="comentario" name="comentario" rows ="3" cols ="50"></textarea>
											</div>
											<div class="col-md-1 col-md-offset-1">
												<button type="button" class="btn btn-default" id="boton_comentar_proyecto" name="comentar" ><?php echo $this->lang->line('msg_label_comentar'); ?></button>
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
								if(count($comentarios )>4){
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
