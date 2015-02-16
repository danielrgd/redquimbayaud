<div class="container">
	 <legend><?php echo $this->lang->line('msg_label_crear_cuenta'); ?></legend>
   <div class="row">
		<?php echo form_open('interfaz/crear_cuenta',array('id'=>'form_crear_cuenta','class'=>'form-horizontal')); ?>
	     <div class="alert alert-danger" id="error_crear_cuenta" style="display: none;"></div>	      	
		 <input type="hidden" id="ruta_foto_perfil" name="ruta_foto_perfil" >
	   
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
						<input class="form-control" id="id_usuario"  name="id_usuario"  type="text">
					 </div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="nombre_completo"><?php echo $this->lang->line('msg_label_nombre_completo'); ?></label>
				<div class="col-md-6">
					<input class="form-control" id="nombre_completo"  name="nombre_completo" type="text">
			</div>
		  </div>
		  <div class="form-group">
			 <label class="control-label col-md-4" for="fecha_nacimiento"><?php echo $this->lang->line('msg_label_fecha_nacimiento'); ?></label>
			 <div class="col-md-4">
				<input type=date class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
			 </div>
		  </div>
		  <div class="form-group">
			 <label class="control-label col-md-4" for="profesion"><?php echo $this->lang->line('msg_label_profesion'); ?></label>
			 <div class="col-md-5">
				<input class="form-control" id="profesion" name="profesion"type="text">
			 </div>
		  </div>
		  <div class="form-group">
			 <label class="control-label col-md-4" for="idiomas"><?php echo $this->lang->line('msg_label_idiomas'); ?></label>
			 <div class="col-md-6">
				<input class="form-control" id="idiomas" name="idiomas" type="text">
			 </div>
		  </div>
		  <div class="form-group">
			 <label class="control-label col-md-4" for="pais"><?php echo $this->lang->line('msg_label_pais'); ?></label>
			 <div class="col-md-4">
				<?php echo form_dropdown('pais',$lista_paises, "", 'class="form-control" id= "pais"'); ?>
			 </div>
		  </div>
		  <div class="form-group">
			 <label class="control-label col-md-4" for="ciudad"><?php echo $this->lang->line('msg_label_ciudad'); ?></label>
			 <div class="col-md-4">
				<input class="form-control" id="ciudad" name="ciudad" type="text">
				<?php //echo form_dropdown('ciudad',$lista_ciudades, "", 'class="form-control" id= "ciudad"'); ?>
			 </div>
		  </div>
		  <div class="form-group">
			 <label class="control-label col-md-4" for="temas_interes"><?php echo $this->lang->line('msg_label_temas_interes'); ?></label>
			 <div class="col-md-6">
				<input class="form-control" id="temas_interes" name="temas_interes"  type="text">
			 </div>
		  </div>
		  <div class="form-group">
			 <label class="control-label col-md-4" for="correo"><?php echo $this->lang->line('msg_label_correo'); ?></label>
			 <div class="col-md-5">
				<input class="form-control" id="correo" name="correo" type="email">
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
			  <div class="form-group">
				<div class="col-md-4 col-md-offset-1">
					<input class="form-control" id="institucion"  name="institucion[]" type="text">
				</div>

				<div class="col-md-4">
					<input class="form-control" id="titulo"  name="titulo[]" type="text">
				</div>
			 </div>
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
         <div class="form-group">
            <div class="col-md-4 col-md-offset-1">
                <input class="form-control" id="etiqueta"  name="etiqueta[]" type="text">
            </div>
            <div class="col-md-4">
               <input class="form-control" id="valor"  name="valor[]" type="text">
            </div>
         </div>
      </div>
       <legend><?php echo $this->lang->line('msg_label_configuracion_perfil'); ?></legend>
			
      <div class="form-group">
         <label class="control-label col-md-4" for="contrasena"><?php echo $this->lang->line('msg_label_contrasena'); ?></label>
         <div class="col-md-4">
            <input class="form-control" id="contrasena" name="contrasena" placeholder="<?php echo $this->lang->line('msg_label_contrasena'); ?>" type="password">
         </div>
      </div>
      <div class="form-group">
         <label class="control-label col-md-4" for="confirmacion_contrasena"><?php echo $this->lang->line('msg_label_confirmacion_contrasena'); ?></label>
         <div class="col-md-4">
            <input class="form-control" id="confirmacion_contrasena" name="confirmacion_contrasena" placeholder="<?php echo $this->lang->line('msg_label_confirmacion_contrasena'); ?>" type="password">
         </div>
      </div>
      <div class="form-group">
         <label class="control-label col-md-4" for="visibilidad"><?php echo $this->lang->line('msg_label_visibilidad'); ?></label>
         <div class="col-md-3">
            <?php echo form_dropdown('visibilidad',$lista_visibilidad, "", 'class="form-control" id= "visibilidad"'); ?>
         </div>
      </div>
      <div class="form-group">
         <label class="control-label col-md-4" for="idioma_perfil"><?php echo $this->lang->line('msg_label_idioma_perfil'); ?></label>
         <div class="col-md-3">
            <?php echo form_dropdown('idioma_perfil',$lista_idiomas_perfil, "", 'class="form-control" id= "idioma_perfil"'); ?>
         </div>
      </div>
	<hr>
      <div class="form-group">
         <div class="col-md-offset-4 col-md-8">
            <button type="button" id="boton_crear_cuenta" class="btn btn-primary"><?php echo $this->lang->line('msg_label_crear'); ?></button>
            <a class="btn btn-default" href="<?php echo site_url()."/interfaz/interfaz_c" ?> "><?php echo $this->lang->line('msg_label_cancelar'); ?></a>
         </div>
      </div>
	   <?php echo form_close(); ?>  
		</div>
   </div>
</div>