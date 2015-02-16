<div class="container">
	 <legend><?php  echo $this->lang->line('msg_label_actualizar_proyecto').": ".$proyecto[0]['nombre_proyecto'] ?></legend>
   <div class="row">
		<?php echo form_open('interfaz/modificar_proyecto',array('id'=>'form_modificar_proyecto','class'=>'form-horizontal')); ?>
	   <input type="hidden" class="form-control" id="id_proyecto"  name="id_proyecto" value="<?php echo $proyecto[0]['id_proyecto']; ?>" type="text">
	     <div class="alert alert-danger" id="error_modificar_proyecto" style="display: none;"></div>	      	
		 <div class="col-md-12">
			<div class="col-md-8 col-md-offset-2">
				<div class="form-group">
					<label class="control-label col-md-4" for="nombre_proyecto"><?php echo $this->lang->line('msg_label_nombre_proyecto'); ?></label>
						 <div class="col-md-4">
							<input class="form-control" id="nombre_proyecto"  name="nombre_proyecto" value="<?php echo $proyecto[0]['nombre_proyecto']; ?>" type="text">
						 </div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="descripcion_general"><?php echo $this->lang->line('msg_label_descripcion_general'); ?></label>
					<div class="col-md-6">
						<textarea class="form-control" id="descripcion_general"  name="descripcion_general" rows="5" cols="20"><?php echo $proyecto[0]['descripcion_general']; ?></textarea>
					</div>
				</div>
				 <div class="form-group">
					<label class="control-label col-md-4" for="objetivo"><?php echo $this->lang->line('msg_label_objetivo'); ?></label>
					<div class="col-md-6">
						<textarea class="form-control" id="objetivo"  name="objetivo"  rows="5" cols="20"><?php echo $proyecto[0]['objetivo']; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="sector"><?php echo $this->lang->line('msg_label_sector'); ?></label>
					<div class="col-md-4">
						<input  class="form-control" id="sector" name="sector"  value="<?php echo $proyecto[0]['sector']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="servicios_productos"><?php echo $this->lang->line('msg_label_servicios_productos'); ?></label>
					<div class="col-md-4">
						<input class="form-control" id="servicios_productos" name="servicios_productos"  value="<?php echo $proyecto[0]['servicios_productos']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="tipo_proyecto"><?php echo $this->lang->line('msg_label_tipo_proyecto'); ?></label>
					<div class="col-md-4">
						<input  class="form-control" id="tipo_proyecto" name="tipo_proyecto"  value="<?php echo $proyecto[0]['tipo_proyecto']; ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="temas_interes"><?php echo $this->lang->line('msg_label_temas_interes'); ?></label>
					<div class="col-md-6">
						<ul id="temas_interes" name="temas_interes">
						<?php foreach($proyecto[0]['temas_interes'] as $tema_interes){

								echo "<li>".$tema_interes."</li>";

							}
						?>
						</ul>
					 </div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="fuente_financiacion"><?php echo $this->lang->line('msg_label_fuente_financiacion'); ?></label>
					<div class="col-md-5">
						<input class="form-control" id="fuente_financiacion" name="fuente_financiacion"  value="<?php echo $proyecto[0]['fuente_financiacion']; ?>" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="poblacion_objetivo"><?php echo $this->lang->line('msg_label_poblacion_objetivo'); ?></label>
					<div class="col-md-5">
						<input class="form-control" id="poblacion_objetivo" name="poblacion_objetivo"  value="<?php echo $proyecto[0]['poblacion_objetivo']; ?>" type="text">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="institucion"><?php echo $this->lang->line('msg_label_institucion'); ?></label>
					<div class="col-md-5">
						<input class="form-control" id="institucion" name="institucion"  value="<?php echo $proyecto[0]['institucion']; ?>" type="text">
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
			<!--	<div class="form-group">
					<div class="col-md-2">
						<input class="form-control" id="integrantes"  name="integrantes[]" data-provide="typeahead" type="text">
						<input type="hidden" class="form-control" id="id_usuario_integrantes"  name="id_usuario_integrantes[]" type="text">
					</div>
					<div class="col-md-2">
						<input class="form-control" id="roles"  name="roles[]" type="text">
					</div>
					<div class="col-md-3">
						<input type=date class="form-control" id="fecha_inicio" name="fecha_inicio">
			 		</div>
					<div class="col-md-3">
						<input type=date class="form-control" id="fecha_fin" name="fecha_fin">
			 		</div>
					<div class="col-md-1">
						<input name="propietario[]" id="propietario" type="checkbox"  >
					</div>
			 	</div>-->
				<?php if(count($integrantes) > 0){
						
	
							foreach($integrantes as $key => $integrante ){
								
				?>
								<fieldset disabled>
								<div class='form-group'>
									<div class='col-md-2'>
										<input class="form-control" id='c_integrantes_"<?php echo $contador_integrantes;?>"' name="c_integrantes[]" value="<?php echo $integrante['nombre_completo']; ?>" type="text">
									</div>
									<div class="col-md-2">
										<input class="form-control" id='c_roles_"<?php echo $contador_integrantes;?>"' name="c_roles[]" value="<?php echo $integrante['rol']; ?>" type="text">
									</div>
									<div class="col-md-3">
										<input type=text class="form-control" id='c_fecha_inicio_"<?php echo $contador_integrantes;?>"' name="c_fecha_inicio" value="<?php echo date("d/m/Y",$integrante['fecha_inicio']); ?>">
			 						</div>
									<div class="col-md-3">
										<input type=text class="form-control" id='c_fecha_fin_"<?php echo $contador_integrantes;?>"' name="c_fecha_fin" value="<?php echo date("d/m/Y",$integrante['fecha_fin']); ?>">
			 						</div>
									<div class="col-md-1">
										<input type="checkbox" id="c_propietario" name="propietario[]" <?php if($integrante['es_propietario']){ echo "checked";} ?>  >
									</div>
								</div>
								</fieldset>
				<?php
							}
						}
				?>
		  	</div>
	   </div>
	   <legend><?php echo $this->lang->line('msg_label_informacion_avanzada'); ?></legend>
	  <div class="col-md-8 col-md-offset-2">
		 	<div class="form-group">
				<label class="control-label col-md-4" for="p_fecha_inicio"><?php echo $this->lang->line('msg_label_fecha_inicio'); ?></label>
				<div class="col-md-4">
					<input type=date class="form-control" id="p_fecha_inicio" name="p_fecha_inicio">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="p_fecha_fin"><?php echo $this->lang->line('msg_label_fecha_fin'); ?></label>
				<div class="col-md-4">
					<input type=date class="form-control" id="p_fecha_fin" name="p_fecha_fin">
			 	</div>
		  	</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="porcentaje_avance"><?php echo $this->lang->line('msg_label_porcentaje_avance'); ?></label>
				<div class="col-md-2">
					<input class="form-control" id="porcentaje_avance" name="porcentaje_avance"  value="<?php echo $proyecto[0]['porcentaje_avance']; ?>" type="number">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="pais"><?php echo $this->lang->line('msg_label_pais'); ?></label>
				<div class="col-md-4">
					<?php echo form_dropdown('pais',$lista_paises,$proyecto[0]['pais'] , 'class="form-control" id= "pais"'); ?>
				 </div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="ciudad"><?php echo $this->lang->line('msg_label_ciudad'); ?></label>
				<div class="col-md-4">
					<input class="form-control" id="ciudad" name="ciudad"  value="<?php echo $proyecto[0]['ciudad']; ?>" type="text">
					<?php //echo form_dropdown('ciudad',$lista_ciudades, "", 'class="form-control" id= "ciudad"'); ?>
				</div>
			</div>
			<!--  <div class="form-group">
				<label class="control-label col-md-4" for="avances"><?php //echo $this->lang->line('msg_label_avances'); ?></label>
				<div class="col-md-6">
					<textarea class="form-control" id="avances"  name="avances"  rows="5" cols="20"><?php echo $proyecto[0]['avances']; ?></textarea>
				</div>
		  	</div>
			-->
			<div class="form-group">
				<label class="control-label col-md-4" for="resultados"><?php echo $this->lang->line('msg_label_resultados'); ?></label>
				<div class="col-md-6">
					<textarea class="form-control" id="resultados"  name="resultados"  rows="5" cols="20"><?php echo $proyecto[0]['resultados']; ?></textarea>
				</div>
		  	</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="lecciones_aprendidas"><?php echo $this->lang->line('msg_label_lecciones_aprendidas'); ?></label>
				<div class="col-md-6">
					<textarea class="form-control" id="lecciones_aprendidas"  name="lecciones_aprendidas"  rows="5" cols="20"><?php echo $proyecto[0]['lecciones_aprendidas']; ?></textarea>
				</div>
		  	</div>
		
<!--			<legend><?php //echo $this->lang->line('msg_label_propietarios'); ?></legend>
			<button type="button" class="btn btn-default btn-sm" id="insertar_propietarios">
				<span class="glyphicon glyphicon-plus"></span>
			</button>
			 <div>
				<div class="form-group">
					<div class="col-md-4 col-md-offset-1">
						<label for="propietarios"><?php ///echo $this->lang->line('msg_label_propietario'); ?></label>
					</div>
				</div>
			 </div>
			 <div id="div_propietarios">
				 <?php /*if(count($propietarios_proyecto) > 0){
						
							$contador_propietarios = 0;
							foreach($propietarios_proyecto as $key => $propietario ){
								
				?>
								<div class='form-group'>
									<div class='col-md-4 col-md-offset-1'>
										<input class="form-control" id="propietarios_<?php echo $contador_propietarios;?>" name="propietarios[]" value="<?php echo $propietario['nombre_completo']; ?>" type="text">
										<input type="hidden" class="form-control" id="id_usuario_propietarios_<?php echo $contador_propietarios;?>"  name="id_usuario_propietarios[]" value="<?php echo $propietario['id_usuario']; ?>" type="text">
									</div>
										<button type="button" class="btn btn-default btn-sm" name="eliminar_propietario" id="eliminar_integrante_"+contador_propietarios+"" >
										<span class="glyphicon glyphicon-minus"></span>
										</button>
									</div>
	
				<?php		
							$contador_propietarios++;
							}
						}*/
				?>

			 </div>
-->
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
						<input class="form-control" id="etiqueta"  name="etiqueta[]" type="text" >
					</div>
					<div class="col-md-4">
						<input class="form-control" id="valor"  name="valor[]" type="text" >
					</div>
				</div>
			   <?php 
				if(count($proyecto[0]['adicionales'])>0){

					$contador_adicionales = 0;
					foreach($proyecto[0]['adicionales'] as $etiqueta => $valor){

					?>	
						<div class="form-group">
							<div class="col-md-4 col-md-offset-1">
								<input class="form-control" id="etiqueta_<?php echo $contador_adicionales;?>"  name="etiqueta[]" type="text" value="<?php echo $etiqueta; ?>">
							</div>
							<div class="col-md-4">
								<input class="form-control" id="valor_<?php echo $contador_adicionales;?>"  name="valor[]" type="text" value="<?php echo $valor; ?>">
							</div>
						</div>
					<?php
					
					$contador_adicionales++;
					}
				}
				?>
		  	</div>
	</div>
	<legend><?php echo $this->lang->line('msg_label_configuracion_perfil'); ?></legend>
	<div class="col-md-8 col-md-offset-2">
      <div class="form-group">
         <label class="control-label col-md-4" for="visibilidad"><?php echo $this->lang->line('msg_label_visibilidad'); ?></label>
         <div class="col-md-3">
            <?php echo form_dropdown('visibilidad',$lista_visibilidad, $proyecto[0]['visibilidad'], 'class="form-control" id= "visibilidad"'); ?>
         </div>
      </div>
		<hr>
      <div class="form-group">
         <div class="col-md-offset-4 col-md-8">
            <button type="button" id="boton_actualizar_proyecto" class="btn btn-primary"><?php echo $this->lang->line('msg_label_actualizar'); ?></button>
            <a class="btn btn-default" href="<?php echo site_url()."/interfaz/interfaz_c" ?> "><?php echo $this->lang->line('msg_label_cancelar'); ?></a>
         </div>
      </div>
	   <?php echo form_close(); ?>  
   </div>
</div>