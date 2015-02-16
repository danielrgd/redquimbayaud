<div class="container">
	 <legend><?php echo $this->lang->line('msg_label_crear_contabilidad'); ?></legend>
   <div class="row">
		<?php echo form_open('interfaz/crear_contabilidad',array('id'=>'form_crear_contabilidad','class'=>'form-horizontal')); ?>
		<input type="hidden" class="form-control" id="id_proyecto"  name="id_proyecto" value="<?php echo "1" ?>" type="text">
	     <div class="alert alert-danger" id="error_crear_contabilidad" style="display: none;"></div>	      		   
		<div class="col-md-8 col-md-offset-2">
			<div class="form-group">
				<label class="control-label col-md-4" for="detalle"><?php echo $this->lang->line('msg_label_detalle'); ?></label>
				<div class="col-md-6">
					<textarea class="form-control" id="detalle"  name="detalle"  rows="5" cols="20"></textarea>
				</div>
		  	</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="valor"><?php echo $this->lang->line('msg_label_valor'); ?></label>
					<div class="col-md-4">
						<input class="form-control" id="valor"  name="valor"  type="number">						
					 </div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="fecha"><?php echo $this->lang->line('msg_label_fecha'); ?></label>
					<div class="col-md-4">
						<input class="form-control" id="fecha"  name="fecha"  type="date">						
					 </div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="tipo"><?php echo $this->lang->line('msg_label_tipo'); ?></label>
					<div class="col-md-3">
						<?php echo form_dropdown('tipo',$lista_tipo_contabilidad, "", 'class="form-control" id= "tipo"'); ?>					
					 </div>
			</div>
		</div>
	</div>
	<hr>
    <div class="form-group">
		<div class="col-md-offset-4 col-md-8">
		<button type="button" id="boton_crear_contabilidad" class="btn btn-primary"><?php echo $this->lang->line('msg_label_crear'); ?></button>
			<a class="btn btn-default" href="<?php echo site_url()."/interfaz/interfaz_c" ?> "><?php echo $this->lang->line('msg_label_cancelar'); ?></a>
		</div>
	</div>
	<?php echo form_close(); ?>  
	</div>
</div>