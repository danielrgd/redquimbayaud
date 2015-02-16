<div class="container">
	 <legend><?php echo $this->lang->line('msg_label_modificar_opciones_cuenta'); ?></legend>
   <div class="row">
		<?php echo form_open('interfaz/modificar_perfil',array('id'=>'form_modificar_cuenta','class'=>'form-horizontal')); ?>
	    <div class="alert alert-danger" id="error_modificar_cuenta" style="display: none;"></div>	
	    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $usuario[0]['id_usuario']; ?>">
		<div class="col-md-8 col-md-offset-2">
			<div class="form-group">
				<label class="control-label col-md-4" for="nueva_contrasena"><?php echo $this->lang->line('msg_label_nueva_contrasena'); ?></label>
				<div class="col-md-4">
					<input class="form-control" id="nueva_contrasena" name="nueva_contrasena" placeholder="<?php echo $this->lang->line('msg_label_nueva_contrasena'); ?>" type="password">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="confirmacion_nueva_contrasena"><?php echo $this->lang->line('msg_label_confirmacion_nueva_contrasena'); ?></label>
				 <div class="col-md-4">
				<input class="form-control" id="confirmacion_nueva_contrasena" name="confirmacion_nueva_contrasena" placeholder="<?php echo $this->lang->line('msg_label_confirmacion_nueva_contrasena'); ?>" type="password">
			</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="visibilidad"><?php echo $this->lang->line('msg_label_visibilidad'); ?></label>
				<div class="col-md-3">
					<?php echo form_dropdown('visibilidad',$lista_visibilidad, $usuario[0]['privacidad'], 'class="form-control" id= "visibilidad"'); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="idioma_perfil"><?php echo $this->lang->line('msg_label_idioma_perfil'); ?></label>
				<div class="col-md-3">
					<?php echo form_dropdown('idioma_perfil',$lista_idiomas_perfil, $usuario[0]['idioma_perfil'], 'class="form-control" id= "idioma_perfil"'); ?>
				</div>
			</div>
			<hr>
			<div class="form-group">
				<div class="col-md-offset-4 col-md-8">
					<button type="button" id="boton_modificar_cuenta" class="btn btn-primary"><?php echo $this->lang->line('msg_label_actualizar'); ?></button>
					<a class="btn btn-default" href="<?php echo site_url()."/interfaz/interfaz_c" ?> "><?php echo $this->lang->line('msg_label_cancelar'); ?></a>
				</div>
			</div>
	   <?php echo form_close(); ?>  
		</div>
	</div>
</div>