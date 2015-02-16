<div class="container">
	 <legend><?php echo $this->lang->line('msg_label_crear_seguimiento'); ?></legend>
   <div class="row">
		<?php echo form_open('interfaz/crear_seguimiento',array('id'=>'form_crear_seguimiento','class'=>'form-horizontal')); ?>
		<input type="hidden" class="form-control" id="id_proyecto"  name="id_proyecto" value="<?php echo $id_proyecto; ?>" type="text">
	     <div class="alert alert-danger" id="error_crear_seguimiento" style="display: none;"></div>	      		   
		<div class="col-md-8 col-md-offset-2">
			<div class="form-group">
				<label class="control-label col-md-4" for="objetivo"><?php echo $this->lang->line('msg_label_descripcion'); ?></label>
				<div class="col-md-6">
					<textarea class="form-control" id="descripcion"  name="descripcion"  rows="5" cols="20"></textarea>
				</div>
		  	</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="responsable"><?php echo $this->lang->line('msg_label_responsable'); ?></label>
					<div class="col-md-4">
						<input class="form-control" id="responsable"  name="responsable"  type="text">
						<input type="hidden" class="form-control" id="id_usuario_responsable"  name="id_usuario_responsable" type="text">
					 </div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="archivos"><?php echo $this->lang->line('msg_label_archivos'); ?></label>
					 <div class="col-md-6">
						<input id="archivos_seguimiento" type="file" name="userfile">
					 </div>
			</div>
			<div id="div_archivos_cargados" >
			</div>
		</div>
	</div>
	<hr>
    <div class="form-group">
		<div class="col-md-offset-4 col-md-8">
		<button type="button" id="boton_crear_seguimiento" class="btn btn-primary"><?php echo $this->lang->line('msg_label_crear'); ?></button>
			<a class="btn btn-default" href="<?php echo site_url()."/interfaz/interfaz_c" ?> "><?php echo $this->lang->line('msg_label_cancelar'); ?></a>
		</div>
	</div>
	<?php echo form_close(); ?>  
	</div>
</div>