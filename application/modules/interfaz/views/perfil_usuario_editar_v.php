<div class="container">
	 <legend><?php echo $this->lang->line('msg_label_actualizar_perfil'); ?></legend>
   <div class="row">
		<?php echo form_open('interfaz/modificar_perfil',array('id'=>'form_actualizar_perfil','class'=>'form-horizontal')); ?>
	   <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $usuario[0]['id_usuario']; ?>">
	    <input type="hidden" id="ruta_foto_perfil" name="ruta_foto_perfil" >
	     <div class="alert alert-danger" id="error_actualizar_perfil" style="display: none;"></div>	      	
	   
		<div class="col-md-8 col-md-offset-2">
			<div class="form-group">
				<label class="control-label col-md-4" for="foto_perfil"><?php echo $this->lang->line('msg_label_foto_perfil'); ?></label>
					 <div class="col-md-6">
						<input id="userfile" type="file" name="userfile">
					 </div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="id_usuario"><?php echo $this->lang->line('msg_label_usuario'); ?></label>
					 <div class="col-md-4">
						<?php echo $usuario[0]['id_usuario']; ?>
					 </div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="nombre_completo"><?php echo $this->lang->line('msg_label_nombre_completo'); ?></label>
				<div class="col-md-6">
					<input class="form-control" id="nombre_completo"  name="nombre_completo" type="text" value="<?php echo $usuario[0]['nombre_completo']; ?>">
			</div>
		  	</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="temas_interes"><?php echo $this->lang->line('msg_label_temas_interes'); ?></label>
				<div class="col-md-6">
					<ul id="temas_interes" name="temas_interes">
						<?php foreach($usuario[0]['temas_interes'] as $tema_interes){

								echo "<li>".$tema_interes."</li>";

							}
						?>
					</ul>
				</div>
			</div>
	   	</div>
		<legend><?php echo $this->lang->line('msg_label_informacion_avanzada'); ?></legend>
	   	<div class="col-md-8 col-md-offset-2">
			<div class="form-group">
				<label class="control-label col-md-4" for="fecha_nacimiento"><?php echo $this->lang->line('msg_label_fecha_nacimiento'); ?></label>
				<div class="col-md-4">
					<input type=date class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value =<?php echo date('Y-m-d',$usuario[0]['fecha_nacimiento']); ?>>
				</div>
		  	</div>
		  <div class="form-group">
			 <label class="control-label col-md-4" for="profesion"><?php echo $this->lang->line('msg_label_profesion'); ?></label>
			 <div class="col-md-5">
				<input class="form-control" id="profesion" name="profesion"type="text" value="<?php echo $usuario[0]['profesion']; ?>">
			 </div>
		  </div>
		  <div class="form-group">
			 <label class="control-label col-md-4" for="idiomas"><?php echo $this->lang->line('msg_label_idiomas'); ?></label>
			 <div class="col-md-6">
				<ul id="idiomas" name="idiomas">
					<?php  foreach($usuario[0]['idiomas'] as $idioma){
						
							echo "<li>".$idioma."</li>";
					
						}
					?>
				</ul>
			 </div>
		  </div>
		  <div class="form-group">
			 <label class="control-label col-md-4" for="pais"><?php echo $this->lang->line('msg_label_pais'); ?></label>
			 <div class="col-md-4">
				<?php echo form_dropdown('pais',$lista_paises, $usuario[0]['pais'], 'class="form-control" id= "pais"'); ?>
			 </div>
		  </div>
		  <div class="form-group">
			 <label class="control-label col-md-4" for="ciudad"><?php echo $this->lang->line('msg_label_ciudad'); ?></label>
			 <div class="col-md-4">
				<input class="form-control" id="ciudad" name="ciudad" type="text" value="<?php echo $usuario[0]['ciudad']; ?>">
				<?php //echo form_dropdown('ciudad',$lista_ciudades, "", 'class="form-control" id= "ciudad"'); ?>
			 </div>
		  </div>
		  <div class="form-group">
			 <label class="control-label col-md-4" for="correo"><?php echo $this->lang->line('msg_label_correo'); ?></label>
			 <div class="col-md-5">
				<input class="form-control" id="correo" name="correo" type="email" value="<?php echo $usuario[0]['correo']; ?>">
			 </div>
		  </div>
			<legend><?php echo $this->lang->line('msg_label_estudios'); ?></legend>
				<button type="button" class="btn btn-default btn-sm" id="insertar_estudio">
					<span class="glyphicon glyphicon-plus"></span>
				</button>

			 <div class="form-group">
				 <div class="col-md-4 col-md-offset-1">
					 <label for="institucion"><?php echo $this->lang->line('msg_label_institucion'); ?></label>
				</div>
				 <div class="col-md-4">
					<label for="titulo"><?php echo $this->lang->line('msg_label_titulo'); ?></label>
				</div>
			 </div>

		  <div id="div_estudios">

			  <?php foreach($usuario[0]['estudios'] as $institucion => $titulo){

				?>	 <div class="form-group">
						<div class="col-md-4 col-md-offset-1">
							<input class="form-control" id="institucion"  name="institucion[]" type="text" value="<?php echo $institucion; ?>">
						</div>

						<div class="col-md-4">
							<input class="form-control" id="titulo"  name="titulo[]" type="text" value="<?php echo $titulo; ?>">
						</div>
					</div>
			  <?php
				}
				?>
		  </div>
	  <div class="col-md-4">
        
         
      </div>
		<legend><?php echo $this->lang->line('msg_label_adicionales'); ?></legend>
			<button type="button" class="btn btn-default btn-sm" id="insertar_adicional">
				<span class="glyphicon glyphicon-plus"></span>
            </button>
	 <div class="form-group">
		<div class="col-md-4 col-md-offset-1">
			 <label for="campo"><?php echo $this->lang->line('msg_label_etiqueta'); ?></label>
		</div>
		<div class="col-md-4">
			<label  for="valor"><?php echo $this->lang->line('msg_label_valor'); ?></label>
		</div>
	 </div>
      <div id="div_adicionales">
		  
		   <?php foreach($usuario[0]['adicionales'] as $etiqueta => $valor){

				?>	 <div class="form-group">
						<div class="col-md-4 col-md-offset-1">
							<input class="form-control" id="etiqueta"  name="etiqueta[]" type="text" value="<?php echo $etiqueta; ?>">
						</div>

						<div class="col-md-4">
							<input class="form-control" id="valor"  name="valor[]" type="text" value="<?php echo $valor; ?>">
						</div>
					</div>
			  <?php
				}
				?>
      </div>
    <hr>
      <div class="form-group">
         <div class="col-md-offset-4 col-md-8">
            <button type="button" id="boton_actualizar_perfil" class="btn btn-primary"><?php echo $this->lang->line('msg_label_actualizar'); ?></button>
            <a class="btn btn-default" href="<?php echo site_url()."/interfaz/interfaz_c" ?> "><?php echo $this->lang->line('msg_label_cancelar'); ?></a>
         </div>
      </div>
	   <?php echo form_close(); ?>  
		</div>
   </div>
</div>