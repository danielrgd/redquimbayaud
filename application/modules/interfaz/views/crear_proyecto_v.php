<div class="container">
	 <legend><?php echo $this->lang->line('msg_label_crear_proyecto'); ?></legend>
   <div class="row">
		<?php echo form_open('interfaz/crear_proyecto',array('id'=>'form_crear_proyecto','class'=>'form-horizontal')); ?>
	     <div class="alert alert-danger" id="error_crear_proyecto" style="display: none;"></div>	      	
		 <div class="col-md-12">
			 <div class="col-md-8 col-md-offset-2">
				<div class="form-group">
					<label class="control-label col-md-4" for="nombre_proyecto"><?php echo $this->lang->line('msg_label_nombre_proyecto'); ?></label>
						 <div class="col-md-4"> 
							<input class="form-control"  id="nombre_proyecto"  name="nombre_proyecto" type="text">
						 </div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="descripcion_general"><?php echo $this->lang->line('msg_label_descripcion_general'); ?></label>
					<div class="col-md-6">
						<textarea class="form-control" id="descripcion_general"  name="descripcion_general" rows="5" cols="20"></textarea>
					</div>
				</div>
				 <div class="form-group">
					<label class="control-label col-md-4" for="objetivo"><?php echo $this->lang->line('msg_label_objetivo'); ?></label>
					<div class="col-md-6">
						<textarea class="form-control" id="objetivo"  name="objetivo" rows="5" cols="20"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="sector"><?php echo $this->lang->line('msg_label_sector'); ?></label>
					<div class="col-md-4">
						<input  class="form-control" id="sector" name="sector">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="servicios_productos"><?php echo $this->lang->line('msg_label_servicios_productos'); ?></label>
					<div class="col-md-4">
						<input class="form-control" id="servicios_productos" name="servicios_productos">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="tipo_proyecto"><?php echo $this->lang->line('msg_label_tipo_proyecto'); ?></label>
					<div class="col-md-4">
						<input  class="form-control" id="tipo_proyecto" name="tipo_proyecto">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="temas_interes"><?php echo $this->lang->line('msg_label_temas_interes'); ?></label>
					<div class="col-md-6">
						<input class="form-control" id="temas_interes" name="temas_interes"  type="text">
					 </div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="fuente_financiacion"><?php echo $this->lang->line('msg_label_fuente_financiacion'); ?></label>
					<div class="col-md-5">
						<input class="form-control" id="fuente_financiacion" name="fuente_financiacion" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="poblacion_objetivo"><?php echo $this->lang->line('msg_label_poblacion_objetivo'); ?></label>
					<div class="col-md-5">
						<input class="form-control" id="poblacion_objetivo" name="poblacion_objetivo" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="institucion"><?php echo $this->lang->line('msg_label_institucion'); ?></label>
					<div class="col-md-5">
						<input class="form-control" id="institucion" name="institucion" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="fecha_inicio_p"><?php echo $this->lang->line('msg_label_fecha_inicio'); ?></label>
					<div class="col-md-4">
						<input type=date class="form-control" id="fecha_inicio_p" name="fecha_inicio_p">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="fecha_fin_p"><?php echo $this->lang->line('msg_label_fecha_fin'); ?></label>
					<div class="col-md-4">
						<input type=date class="form-control" id="fecha_fin_p" name="fecha_fin_p">
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
			</div>
			
			 <legend><?php echo $this->lang->line('msg_label_integrantes'); ?></legend>
			<button type="button" class="btn btn-default btn-sm" id="insertar_integrantes">
				<span class="glyphicon glyphicon-plus"></span>
			</button>
			<div class="form-group">
				<div class="col-md-2">
					<label for="usuario"><?php echo $this->lang->line('msg_label_integrante'); ?></label>
				</div>
				<div class="col-md-2">
					<label for="rol"><?php echo $this->lang->line('msg_label_rol'); ?></label>
				</div>
				<div class="col-md-3">
					<label for="rol"><?php echo $this->lang->line('msg_label_fecha_inicio'); ?></label>
				</div>
				<div class="col-md-3">
					<label for="rol"><?php echo $this->lang->line('msg_label_fecha_fin'); ?></label>
				</div>
				<div class="col-md-1">
					<label for="rol"><?php echo $this->lang->line('msg_label_propietario'); ?></label>
				</div>
			</div>
			<div id="div_integrantes">
				<div class="form-group">
					<div class="col-md-2">
						<input class="form-control" id="integrantes"  name="integrantes[]" data-provide="typeahead" type="text">
						<input type="hidden" class="form-control" id="id_usuario_integrantes"  name="id_usuario_integrantes[]" type="text">
					</div>
					<div class="col-md-2">
						<input class="form-control" id="roles"  name="roles[]" type="text">
					</div>
					<div class="col-md-3">
						<input type=date class="form-control" id="fecha_inicio" name="fecha_inicio[]">
			 		</div>
					<div class="col-md-3">
						<input type=date class="form-control" id="fecha_fin" name="fecha_fin[]">
			 		</div>
					<div class="col-md-1">
						<input name="propietario[]" id="propietario" type="checkbox"  >
					</div>
			 	</div>
		  	</div>
			 <div class="col-md-8 col-md-offset-2">
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
					 <label class="control-label col-md-4" for="visibilidad"><?php echo $this->lang->line('msg_label_visibilidad'); ?></label>
					 <div class="col-md-3">
						<?php echo form_dropdown('visibilidad',$lista_visibilidad, "", 'class="form-control" id= "visibilidad"'); ?>
					 </div>
				  </div>
				</div>
      <div class="form-group">
         <div class="col-md-offset-4 col-md-8">
            <button type="button" id="boton_crear_proyecto" class="btn btn-primary"><?php echo $this->lang->line('msg_label_crear'); ?></button>
            <a class="btn btn-default" href="<?php echo site_url()."/interfaz/interfaz_c" ?> "><?php echo $this->lang->line('msg_label_cancelar'); ?></a>
         </div>
      </div>
	   <?php echo form_close(); ?>  
		</div>
   </div>
</div>