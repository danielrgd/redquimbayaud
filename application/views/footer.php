

	<script src="<?php echo base_url('scripts/jquery-2.1.1.min.js'); ?>"></script>
	<script src="<?php echo base_url('scripts/jquery-ui-1.10.4.min.js'); ?>"></script>

	<script src="<?php echo base_url('scripts/bootstrap3-typeahead.js '); ?>"></script>
	<script src="<?php echo base_url('scripts/tooltip.js'); ?>"></script>
	<script src="<?php echo base_url('scripts/popover.js'); ?>"></script>
	<script src="<?php echo base_url('scripts/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('scripts/tag-it.js'); ?>"></script>
	<script src="<?php echo base_url('scripts/star-rating.js'); ?>"></script>
	<script src="<?php echo base_url('scripts/fileinput.min.js'); ?>"></script>

	<script>

	$(document).ready(function() {
		
		var contador_estudios = 0;
		var contador_adicionales = 0;
		var tags_lista_idiomas = <?php if(isset($tags_lista_idiomas)) {echo json_encode($tags_lista_idiomas); } else{ echo json_encode(array(""));} ?>;
		var tags_lista_temas_interes = <?php if(isset($tags_lista_temas_interes)) {echo json_encode($tags_lista_temas_interes); } else{ echo json_encode(array(""));} ?>;
		//var usuario_calificacion = <?php //if(isset($usuario['calificacion'])) {echo json_encode($usuario['calificacion']); } else{echo json_encode(array(""));} ?>;
		var usuario_calificacion_general = <?php if(isset($usuario['calificacion'])) {echo $usuario['calificacion']; } else{echo "0";} ?>;
		var proyecto_calificacion_general = <?php if(isset($proyecto['calificacion'])) {echo $proyecto['calificacion']; } else{echo "0";} ?>;
		var mi_calificacion_usuario = <?php if(isset($usuario['micalificacion'])) {echo $usuario['micalificacion']; } else{echo "0";} ?>;
		var mi_calificacion_proyecto = <?php if(isset($proyecto['micalificacion'])) {echo $proyecto['micalificacion']; } else{echo "0";} ?>;
		var propietarios = <?php if(isset($propietarios)) {echo json_encode($propietarios); } else{echo json_encode(array(""));} ?>;
		
		var usuarios = <?php if(isset($usuarios)){echo json_encode($usuarios);} else{ echo json_encode(array(""));} ?>;


		$('input[name="integrantes[]"]').typeahead({source: usuarios});
		$('input[name="propietarios[]"]').typeahead({source: propietarios});
		$('#responsable').typeahead({source: usuarios});
	
		$('button[name="aceptar[]"]').click(function(){
			
			var index = $('button[name="aceptar[]"]').index(this);
			var tipo = $("input[name='tipo[]'").eq(index).val();
			var id_notificacion  = $("input[name='id_notificacion[]'").eq(index).val();
			var id_usuario  = $("input[name='id_usuario[]'").eq(index).val();
			var id_proyecto  = $("input[name='id_proyecto[]'").eq(index).val();
			var nombre_completo = $("input[name='nombre_completo[]'").eq(index).val();
			var nombre_proyecto = $("input[name='nombre_proyecto[]'").eq(index).val();
/* 			
			var index = $('button[name="aceptar[]"]').index(this); 
			$("ul.dropdown-menu > li").eq(index).remove();
 */
			
			if(tipo == "solicitud"){
								
				$('#modal_solicitar_usuario #id_notificacion').val(id_notificacion);
				$('#modal_solicitar_usuario #id_usuario').val(id_usuario);
				$('#modal_solicitar_usuario #id_proyecto').val(id_proyecto);
				$('#modal_solicitar_usuario #nombre_completo').val(nombre_completo);
				$('#modal_solicitar_usuario #nombre_proyecto').val(nombre_proyecto);
				
				$('#modal_solicitar_usuario').modal('show');
			}
			else if(tipo =="invitacion"){
				
				var rol = $("input[name='rol[]'").eq(index).val();
				var es_propietario = $("input[name='es_propietario[]'").eq(index).val();
				var fecha_inicio = $("input[name='fecha_inicio[]'").eq(index).val();
				var fecha_fin = $("input[name='fecha_fin[]'").eq(index).val();

				$('#modal_invitar_usuario #id_notificacion').val(id_notificacion);
				$('#modal_invitar_usuario #id_usuario').val(id_usuario);
				$('#modal_invitar_usuario #id_proyecto').val(id_proyecto);
				$('#modal_invitar_usuario #nombre_completo').val(nombre_completo);
				$('#modal_invitar_usuario #nombre_proyecto').val(nombre_proyecto);
				$('#modal_invitar_usuario #rol').val(rol);
				$('#modal_invitar_usuario #fecha_inicio').val(fecha_inicio);
				$('#modal_invitar_usuario #fecha_fin').val(fecha_fin);
				
				if(es_propietario == "1")
					//$("#modal_invitar_usuario #es_propietario").attr('checked',true);
					$("#modal_invitar_usuario #es_propietario").val("Sí");
				else
					$("#modal_invitar_usuario #es_propietario").val("No");
				
				$('#modal_invitar_usuario').modal('show');
			}		
		});
		
		//Ajax asociar usuario
		$('#boton_solicitar_usuario').click( function(e){
			
			var numero_notificaciones = $("#notificaciones_sin_leer").html();
			var myData = $("#form_solicitar_usuario").serialize();
						
			$.ajax({
				 type: "POST",
				 data:myData, 
				 async: false,
				 dataType: "json",
				 url: '<?php echo site_url('interfaz/interfaz_c/gestionar_asociacion'); ?>',
				 success: function(data){
					if(data['status'] == 0){
						
						$('#error_solicitar_usuario').html(data['msg']);
						$('#error_solicitar_usuario').show('slow');
						
					}
					else{
					
						$('#modal_solicitar_usuario').modal('hide');
						$("#notificaciones_sin_leer").html(parseInt(numero_notificaciones,10)-1);
																	
					}
					
				},
			 });
		}); 
		
		//Ajax invitar usuario
		$('#boton_invitar_usuario').click( function(e){
			
			var numero_notificaciones = $("#notificaciones_sin_leer").html();
			var myData = $("#form_invitar_usuario").serialize();
			
			$.ajax({
				 type: "POST",
				 data:myData, 
				 async: false,
				 dataType: "json",
				 url: '<?php echo site_url('interfaz/interfaz_c/gestionar_asociacion'); ?>',
				 success: function(data){
					if(data['status'] == 0){
						
						$('#error_invitar_usuario').html(data['msg']);
						$('#error_invitar_usuario').show('slow');
						
					}
					else{
					
						$('#modal_invitar_usuario').modal('hide');
						$("#notificaciones_sin_leer").html(parseInt(numero_notificaciones,10)-1);
						//
					}
					
				},
			 });
		}); 
		
		//Autocompletar integrantes
		$(document).on('change','input[name="integrantes[]"]', function() {
			
			var current = $('input[name="integrantes[]"]').typeahead("getActive"); 
			var duplicado = false;
			if (current) {
				
				// Some item from your model is active!
				if (current.name == $('input[name="integrantes[]"]').val()) {
				
					var index = $('input[name="integrantes[]"]').index(this);
					
					$('input[name="id_usuario_integrantes[]"]').each(function(){
						
						if($(this).val() == current.id){
							
							duplicado = true;
						}
					})
					if(duplicado == false){						
						
						$("input[name='id_usuario_integrantes[]'").eq(index).val(current.id);
						
						$("input[name='propietario[]'").eq(index).val(current.id);
						
					}
					else{
						
						$('#modal_integrante_duplicado').modal('show');
						$(this).val("");
						$("input[name='id_usuario_integrantes[]'").eq(index).val("");
						
					}
				} else {
					// This means it is only a partial match, you can either add a new item 
					// or take the active if you don't want new items
				}
			} else {
				// Nothing is active so it is a new value (or maybe empty value)
			}
		});

		//Autocompletar propietarios
		$(document).on('change','input[name="propietarios[]"]', function() {
			
			var current = $('input[name="propietarios[]"]').typeahead("getActive"); 
			var duplicado = false;
			if (current) {
				
				// Some item from your model is active!
				if (current.name == $('input[name="propietarios[]"]').val()) {
				
					var index = $('input[name="propietarios[]"]').index(this);
					
					$('input[name="id_usuario_propietarios[]"]').each(function(){
						
						if($(this).val() == current.id){
							
							duplicado = true;
						}
					})
					if(duplicado == false){						
						
						$("input[name='id_usuario_propietarios[]'").eq(index).val(current.id);
						
					}
					else{
						
						$('#modal_propietario_duplicado').modal('show');
						$(this).val("");
						$("input[name='id_usuario_propietarios[]'").eq(index).val("");
						
					}
					// This means the exact match is found. Use toLowerCase() if you want case insensitive match.
				} else {
					// This means it is only a partial match, you can either add a new item 
					// or take the active if you don't want new items
				}
			} else {
				// Nothing is active so it is a new value (or maybe empty value)
			}
		});
			
		//Autocompletar usuarios
		$("#responsable").change( function() {
	
			var current = $('#responsable').typeahead("getActive"); 
			if (current) {
				
				// Some item from your model is active!
				if (current.name == $('#responsable').val()) {
				
					var index = $('input[name="propietarios[]"]').index(this);
		
						$("#id_usuario_responsable").val(current.id);
						
				} else {

				}
			} else {

			}
		});
	
		
	//Eliminar mensajes y marcar como leido
	$('button[name="eliminar[]"]').click(function(){
		
		var numero_notificaciones = $("#notificaciones_sin_leer").html();
		var index = $('#lista_notificaciones button').index(this);
		var id_notificacion = $("input[name='id_notificacion[]']").eq(index).val(); 
		var accion = $(this).val();
		$(this).parents("ul.dropdown-menu > li").remove();
		
		  $.ajax({
				 type: "POST",
				 data:{id_notificacion: id_notificacion, accion:accion},
				 async: false,
				 dataType: "json",
				 url: '<?php  echo site_url('interfaz/interfaz_c/marcar_notificacion'); ?>',
				 success: function(data){
					if(data['status'] == 0){


					}
					else{



					}

				},
		 }); 
		
		$("#notificaciones_sin_leer").html(parseInt(numero_notificaciones,10)-1);
	}); 
		
		//Ajax inicio de sesion
		$('#boton_iniciar_sesion').click( function(e){
		
			 var myData = $("#form_iniciar_sesion").serialize();

			  $.ajax({
					 type: "POST",
					 data:myData, 
					 async: false,
					 dataType: "json",
					 url: '<?php echo site_url('interfaz/interfaz_c/iniciar_sesion'); ?>',
					 success: function(data){
						if(data['status'] == 0){
							
							$('#error_iniciar_sesion').html(data['msg']);
							$('#error_iniciar_sesion').show('slow');
							
						}
						else{
						
							$(location).attr('href','<?php echo site_url('interfaz/interfaz_c'); ?>');
							
						
						}
						
					},
				 }); 
			});
			
		//Ajax creacion de cuenta
		$('#boton_crear_cuenta').click( function(e){
			
			 var myData = $("#form_crear_cuenta").serialize();

			$.ajax({
				 type: "POST",
				 data:myData, 
				 async: false,
				 dataType: "json",
				 url: '<?php echo site_url('interfaz/interfaz_c/crear_cuenta'); ?>',
				 success: function(data){
					if(data['status'] == 0){
						
						$('#error_crear_cuenta').html(data['msg']);
						$('#error_crear_cuenta').show('slow');
						
					}
					else{
					
						$('#modal_activar_cuenta').modal('show')
											
					}
					
				},
			 }); 
		}); 
		//Ajax creacion seguimiento
		$('#boton_crear_seguimiento').click( function(e){
			
			 var myData = $("#form_crear_seguimiento").serialize();

			$.ajax({
				 type: "POST",
				 data:myData, 
				 async: false,
				 dataType: "json",
				 url: '<?php echo site_url('interfaz/interfaz_c/crear_seguimiento'); ?>',
				 success: function(data){
					if(data['status'] == 0){
						
						$('#error_crear_seguimiento').html(data['msg']);
						$('#error_crear_seguimiento').show('slow');
						
					}
					else{
					
						$('#modal_crear_seguimiento').modal('show')					
					
					}
					
				},
			 }); 
		}); 
		//Ajax creacion contabilidad
		$('#boton_crear_contabilidad').click( function(e){
			
			 var myData = $("#form_crear_contabilidad").serialize();

			$.ajax({
				 type: "POST",
				 data:myData, 
				 async: false,
				 dataType: "json",
				 url: '<?php echo site_url('interfaz/interfaz_c/crear_contabilidad'); ?>',
				 success: function(data){
					if(data['status'] == 0){
						
						$('#error_crear_contabilidad').html(data['msg']);
						$('#error_crear_contabilidad').show('slow');
						
					}
					else{
					
						$('#modal_crear_contabilidad').modal('show')					
					
					}
					
				},
			 }); 
		}); 
		
		//Ajax modificar opciones cuenta
		$('#boton_modificar_cuenta').click( function(e){
			
			 var myData = $("#form_modificar_cuenta").serialize();

			$.ajax({
				 type: "POST",
				 data:myData, 
				 async: false,
				 dataType: "json",
				 url: '<?php echo site_url('interfaz/interfaz_c/modificar_cuenta'); ?>',
				 success: function(data){
					if(data['status'] == 0){
						
						$('#error_modificar_cuenta').html(data['msg']);
						$('#error_modificar_cuenta').show('slow');
						
					}
					else{
					
						$('#modal_modificar_cuenta').modal('show')
						
						//$(location).attr('href','<?php //echo site_url('interfaz/interfaz_c'); ?>');
						
					
					}
					
				},
			 }); 
		}); 
		
		$('#mostrar_mas_comentarios').click( function(e){
			
			$("#div_comentarios").append("<hr>"
										+"<div class='row'>"
										+"<div class='col-md-1 col-md-offset-1'>"
											+"<img src='<?php echo base_url('images/usuario.jpg'); ?>' class='img-circle img-responsive'>"
											+"</div>"
										+"<div class='col-md-9'>"
											+"<p>Lorem ipsum dolor sit amet, consectetur adipisici elit,"
											+"<br>sed eiusmod tempor incidunt ut labore et dolore magna aliqua."
											+"<br>Ut enim ad minim veniam, quis nostrud</p>"
											+"<small>1 <?php echo $this->lang->line('msg_label_dias'); ?></small>"
										+"</div>"
									+"</div>");
			
		});
		
		
		//Ajax actualizar perfil
		$('#boton_actualizar_perfil').click( function(e){
		
			 var myData = $("#form_actualizar_perfil").serialize();

			  $.ajax({
					 type: "POST",
					 data:myData, 
					 async: false,
					 dataType: "json",
					 url: '<?php echo site_url('interfaz/interfaz_c/modificar_perfil'); ?>',
					 success: function(data){
						if(data['status'] == 0){
							
							$('#error_actualizar_perfil').html(data['msg']);
							$('#error_actualizar_perfil').show('slow');
							
						}
						else{
						
							$('#modal_actualizar_perfil').modal('show')
							
						
						}
						
					},
				 }); 
			});
		
		//Ajax actualizar proyecto
		$('#boton_actualizar_proyecto').click( function(e){
		
			 var myData = $("#form_modificar_proyecto").serialize();

			  $.ajax({
					 type: "POST",
					 data:myData, 
					 async: false,
					 dataType: "json",
					 url: '<?php echo site_url('interfaz/interfaz_c/modificar_proyecto'); ?>',
					 success: function(data){
						if(data['status'] == 0){
							
							$('#error_modificar_proyecto').html(data['msg']);
							$('#error_modificar_proyecto').show('slow');
							
						}
						else{
						
							$('#modal_actualizar_proyecto').modal('show');			
						
						}
						
					},
				 }); 
			});
		//Idiomas tagit
	   $('#idiomas').tagit({
		   fieldName: "idiomas",
			availableTags: tags_lista_idiomas,
		   singleFieldDelimiter: "|",
		   singleField: true,
			beforeTagAdded: function(event, ui) { 
				
				if ($.inArray(ui.tagLabel, tags_lista_idiomas) == "-1") { 
				  return false;
				}
			 }
		}); 
		
	   $('#temas_interes').tagit({
		   
			fieldName: "temas_interes",
			availableTags: tags_lista_temas_interes,
			singleFieldDelimiter: "|",
		   singleField: true,
		   allowSpaces: true
/* 			beforeTagAdded: function(event, ui) { 

				if ($.inArray(ui.tagLabel, tags_lista_temas_interes) == "-1") { 
				  return false;
				}
			 } */
		});
		
		//Insertar adicional
		$("#insertar_adicional").click(function(){
						
				if(contador_adicionales <=9){
					
					$( "#div_adicionales" ).prepend( "<div class='form-group'>"
												+"<div class='col-md-4 col-md-offset-1'>"
													+"<input class='form-control' id='etiqueta_"+contador_adicionales+"'  name='etiqueta[]' type='text'>"
												+"</div>"	
												+"<div class='col-md-4'>"
													+"<input class='form-control' id='valor_"+contador_adicionales+"'  name='valor[]' type='text'>"
												+"</div>"
												+"<button type='button' class='btn btn-default btn-sm' name='eliminar_adicional' id='eliminar_adicional_"+contador_adicionales+"' >"
												+"<span class='glyphicon glyphicon-minus'></span>"
												+"</button>"
												+"</div>" );
					contador_adicionales ++;				
					
				}					 
		});
		
		$("#modal_cerrar_activar_cuenta").click()
		//Eliminar adicional
		$(document).on('click', 'button[name=eliminar_adicional]', function() {

			$(this).parents('div.form-group').remove();
			contador_adicionales--;

		});
		
		//Insertar estudios
		$("#insertar_estudio").click(function(){
						
				if(contador_estudios <=4){
					
					$( "#div_estudios" ).prepend( "<div class='form-group'>"
												+"<div class='col-md-4 col-md-offset-1'>"
													+"<input class='form-control' id='institucion_"+contador_estudios+"'  name='institucion[]' type='text'>"
												+"</div>"	
												+"<div class='col-md-4'>"
													+"<input class='form-control' id='titulo_"+contador_estudios+"'  name='titulo[]' type='text'>"
												+"</div>"
												+"<button type='button' class='btn btn-default btn-sm' name='eliminar_estudio' id='eliminar_estudio_"+contador_estudios+"' >"
												+"<span class='glyphicon glyphicon-minus'></span>"
												+"</button>"
												+"</div>" );
					contador_estudios ++;				
					
				}					 
		});
		
		//Insertar integrantes
		$("#insertar_integrantes").click(function(){
				
			contador_integrantes = $('input[name="integrantes[]"]').size();		
			//alert(contador_integrantes);
				
				if(contador_integrantes <=20){
					
					$( "#div_integrantes" ).prepend( "<div class='form-group'>"
												+"<div class='col-md-2'>"
													+"<input class='form-control' id='integrantes_"+contador_integrantes+"'  name='integrantes[]' data-provide='typeahead' type='text'>"
													+"<input type='hidden' class='form-control' id='id_usuario_integrantes_"+contador_integrantes+"'  name='id_usuario_integrantes[]'  type='text'>"
												+"</div>"	
												+"<div class='col-md-2'>"
												+"<input class='form-control' id='roles'  name='roles[]' type='text'>"
												+"</div>"
												+"<div class='col-md-3'>"
												+"<input type=date class='form-control' id='fecha_inicio_"+contador_integrantes+"' name='fecha_inicio[]'>"
			 									+"</div>"
												+"<div class='col-md-3'>"
													+"<input type=date class='form-control' id='fecha_fin_"+contador_integrantes+"' name='fecha_fin[]'>"
												+"</div>"
												+"<div class='col-md-1'>"
													+"<input name='propietario[]' id='propietario_"+contador_integrantes+"' type='checkbox' >"
												+"</div>"
												+"<button type='button' class='btn btn-default btn-sm' name='eliminar_integrante' id='eliminar_integrante_"+contador_integrantes+"' >"
												+"<span class='glyphicon glyphicon-minus'></span>"
												+"</button>"
												+"</div>" );
					//contador_integrantes ++;		
					$('input[name="integrantes[]"]').typeahead({source: usuarios});
				}					 
		});
		
		//Insertar propietarios
		$("#insertar_propietarios").click(function(){
						
				contador_propietarios = $('input[name="propietarios[]"]').size();
			
				if(contador_propietarios <=20){
					
					$( "#div_propietarios" ).prepend( "<div class='form-group'>"
													+"<div class='col-md-4 col-md-offset-1'>"
													+"<input class='form-control' id='propietarios' name='propietarios[]' type='text'>"
													+"<input type='hidden' class='form-control' id='id_usuario_propietarios'  name='id_usuario_propietarios[]' type='text'>"
													+"</div>"
													+"<button type='button' class='btn btn-default btn-sm' name='eliminar_propietario' id='eliminar_integrante_"+contador_propietarios+"' >"
													+"<span class='glyphicon glyphicon-minus'></span>"
													+"</button>"
													+"</div>" );
					$('input[name="propietarios[]"]').typeahead({source: propietarios});
				}					 
		});
		
		//Eliminar propietarios
		$(document).on('click', 'button[name=eliminar_propietario]', function() {

			$(this).parents('div.form-group').remove();
			

		});		
		//Eliminar integrante
		$(document).on('click', 'button[name=eliminar_integrante]', function() {

			$(this).parents('div.form-group').remove();
			//contador_integrantes--;

		});		
		//Eliminar estudio
		$(document).on('click', 'button[name=eliminar_estudio]', function() {

			$(this).parents('div.form-group').remove();
			contador_estudios--;

		});
		//Campo cargar foto perfil
		$("#userfile").fileinput({
			
			uploadAsync: false,
			uploadUrl: '<?php echo site_url('upload/upload/cargar_imagen'); ?>',
			'showUpload':true,
			'allowedPreviewTypes':['image'],
			allowedFileExtensions:['jpg', 'png']}
		);
		//Campo cargar archivos seguimiento
		$("#archivos_seguimiento").fileinput({
			
			uploadAsync: false,
			uploadUrl: '<?php echo site_url('upload/upload/do_upload'); ?>',
			'showUpload':false,
			
			allowedFileExtensions:['doc', 'docx','pdf','xls','xlsx','txt','odt']}
		);
		
		//Imagen cargada exitosamente
		$('#userfile').on('fileuploaded', function(event, data, previewId, index) {
			var form = data.form, files = data.files, extra = data.extra, response = data.response, reader = data.reader;
			
			$("#ruta_foto_perfil").val(response.file_name);
		});

		//Imagen cargada exitosamente
		$("#archivos_seguimiento").on('fileuploaded', function(event, data, previewId, index) { 
			var form = data.form, files = data.files, extra = data.extra, response = data.response, reader = data.reader;
	
			$("#div_archivos_cargados").prepend("<input type='hidden' class='form-control' id='file_name_documentos_seguimiento' name='file_name_documentos_seguimiento[]' value='"+response.file.file_name+"' type='text'>"
										 +"<input type='hidden' class='form-control' id='desc_documentos_seguimiento' name='desc_documentos_seguimiento[]' value='"+response.file.client_name+"' type='text'>"
										);
		});

		//Rating estrellas para calificar un usuario
		$('#usuario_calificar').rating({
              min: 0,
              max: 5,
              step: 1,
              size: 'xs',
			  showClear: false,
			  showCaption: false,
           });
		
		$('#usuario_calificar').rating(
			'update',mi_calificacion_usuario);
		
		//envio de la información para calificar
		$('#usuario_calificar').on('rating.change', function(event, value, caption) {
			
			var usuario_to_ca = $("#usuario_to_ca").val();
			
		  	$.ajax({
				 type: "POST",
				 data:{calificacion:value, usuario_to_ca:usuario_to_ca},
				 async: false,
				 dataType: "json",
				 url: '<?php echo site_url('interfaz/interfaz_c/calificar_usuario'); ?>',
				 success: function(data){
					if(data['status'] == 0){

					}
					else{
					}
				},
			});
		});
		
		//Calificacion 
		$('#usuario_rating').rating({
			
              min: 0,
              max: 5,
              step: 1,
              size: 'xs',
			  readonly: true,
			  showClear: false,
			  showCaption: false,
           });
		
		 $('#usuario_rating').rating(
			'update',usuario_calificacion_general);
		
	//Ajax inicio de sesion
	$('#boton_comentar_usuario').click( function(e){

		 var myData = $("#form_comentar_usuario").serialize();

		  $.ajax({
				 type: "POST",
				 data:myData, 
				 async: false,
				 dataType: "json",
				 url: '<?php echo site_url('interfaz/interfaz_c/comentar_usuario'); ?>',
				 success: function(data){
					if(data['status'] == 0){

					}
					else{
						
						var ruta_foto_perfil_usuario_from = $("#ruta_foto_perfil_usuario_from").val();
						var comentario = $("#comentario").val();
						$("#comentario").val("");
						
						$("#div_comentarios").prepend("<div class='row' >"
														+"<div class='col-md-1 col-md-offset-1'>"
															+"<img src="+ruta_foto_perfil_usuario_from+" class='img-circle img-responsive'>"
															+"</div>"
														+"<div class='col-md-9'>"
															+"<p>"+comentario+"</p>"
															+"<small>Ahora</small>"
														+"</div>"
													+"</div>"
													+"<hr>");
					}

				},
			 }); 
	});
		
		
		//Rating estrellas para calificar un PROYECTO
		$('#proyecto_calificar').rating({
              min: 0,
              max: 5,
              step: 1,
              size: 'xs',
			  showClear: false,
			  showCaption: false,
           });
		
		$('#proyecto_calificar').rating(
			'update',mi_calificacion_proyecto);
		
		//envio de la información para calificar PROYECTO
		$('#proyecto_calificar').on('rating.change', function(event, value, caption) {
			
			var proyecto_to_ca = $("#proyecto_to_ca").val();
			
		  	$.ajax({
				 type: "POST",
				 data:{calificacion:value, proyecto_to_ca:proyecto_to_ca},
				 async: false,
				 dataType: "json",
				 url: '<?php echo site_url('interfaz/interfaz_c/calificar_proyecto'); ?>',
				 success: function(data){
					if(data['status'] == 0){

					}
					else{
					}
				},
			});
		});
		
		//Calificacion PROYECTO
		$('#proyecto_rating').rating({
			
              min: 0,
              max: 5,
              step: 1,
              size: 'xs',
			  readonly: true,
			  showClear: false,
			  showCaption: false,
           });
		
		 $('#proyecto_rating').rating(
			'update',proyecto_calificacion_general);
		
		
	//Ajax inicio de sesion PROYECTO
	$('#boton_comentar_proyecto').click( function(e){

		 var myData = $("#form_comentar_proyecto").serialize();

		  $.ajax({
				 type: "POST",
				 data:myData, 
				 async: false,
				 dataType: "json",
				 url: '<?php echo site_url('interfaz/interfaz_c/comentar_proyecto'); ?>',
				 success: function(data){
					if(data['status'] == 0){

					}
					else{
						
						var ruta_foto_perfil_usuario_from = $("#ruta_foto_perfil_usuario_from").val();
						var comentario = $("#comentario").val();
						$("#comentario").val("");
						
						$("#div_comentarios").prepend("<div class='row' >"
														+"<div class='col-md-1 col-md-offset-1'>"
															+"<img src="+ruta_foto_perfil_usuario_from+" class='img-circle img-responsive'>"
															+"</div>"
														+"<div class='col-md-9'>"
															+"<p>"+comentario+"</p>"
															+"<small>Ahora</small>"
														+"</div>"
													+"</div>"
													+"<hr>");
					}

				},
			 }); 
	}); 
		
	$('#boton_solicitar_asociacion').click( function(e){
		
		var id_proyecto = $("#proyecto_to").val();
	
		$.ajax({
			type: "POST",
			data:{id_proyecto:id_proyecto}, 
			async: false,
			dataType: "json",
			url: '<?php echo site_url('interfaz/interfaz_c/solicitar_asociacion'); ?>',
			success: function(data){
				if(data['status'] == 0){

				
					
				}
				else{
					$('#modal_asociacion_proyecto').modal('show');
					$("#boton_solicitar_asociacion").attr("disabled", true);

				}
			},
		}); 
	});
		
		
		//Ajax crear proyecto
	$('#boton_crear_proyecto').click( function(e){

		 var myData = $("#form_crear_proyecto").serialize();

		  $.ajax({
				 type: "POST",
				 data:myData, 
				 async: false,
				 dataType: "json",
				 url: '<?php echo site_url('interfaz/interfaz_c/crear_proyecto'); ?>',
				 success: function(data){
					if(data['status'] == 0){
							
							$('#error_crear_proyecto').html(data['msg']);
							$('#error_crear_proyecto').show('slow');
							
						}
						else{
							$(location).attr('href','<?php echo site_url('interfaz/interfaz_c'); ?>');
							
						
						}
				},
			 }); 
		});
		
	/*	$("#palabras_clave").click(function(){
			
			$('#modal_asociar_usuario').modal('show');
			
			
		});*/
	});
		</script>
  <div class="fade modal" id="modal_iniciar_sesion" style="">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-body">
            <form role="form" id="form_iniciar_sesion">
			  <div class="alert alert-danger" id="error_iniciar_sesion" style="display: none;"></div>	      	
              <div class="form-group">
                <label class="control-label" for="id_usuario"><?php echo $this->lang->line('msg_label_usuario'); ?></label>
                <input class="form-control" id="id_usuario" name="id_usuario" placeholder="<?php echo $this->lang->line('msg_label_usuario'); ?>" type="text">
              </div>
              <div class="form-group">
                <label class="control-label" for="contrasena"><?php echo $this->lang->line('msg_label_contrasena'); ?></label>
                <input class="form-control" id="contrasena" name="contrasena" placeholder="<?php echo $this->lang->line('msg_label_contrasena'); ?>" type="password">
              </div>
              <button type="button" id="boton_iniciar_sesion" class="btn btn-primary"><?php echo $this->lang->line('msg_label_iniciar_sesion'); ?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('msg_label_cancelar'); ?></button>
            </form>
          </div>
        </div>
      </div>
    </div>
 <div class="fade modal" id="modal_solicitar_usuario" style="">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-body">
            <form role="form" id="form_solicitar_usuario" class="form-horizontal">
			  <div class="alert alert-danger" id="error_solicitar_usuario" style="display: none;"></div>	  
				<input type="hidden" class="form-control" id="id_notificacion" name="id_notificacion" type="text">
				<input type="hidden" class="form-control" id="id_usuario" name="id_usuario" type="text">
				<input type="hidden" class="form-control" id="id_proyecto" name="id_proyecto" type="text">
				<fieldset>
					<div class="form-group">
						<label class="control-label col-md-4" for="nombre_completo"><?php echo $this->lang->line('msg_label_usuario'); ?></label>
						<div class="col-md-4">
							<input class="form-control" id="nombre_completo" name="nombre_completo" type="text" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4" for="proyecto"><?php echo $this->lang->line('msg_label_proyecto'); ?></label>
						<div class="col-md-4">
							<input class="form-control" id="nombre_proyecto" name="nombre_proyecto" type="text" readonly>
						</div>
					</div>
				</fieldset>
				<div class="form-group">
                <label class="control-label col-md-4" for="es_propietario"><?php echo $this->lang->line('msg_label_propietario'); ?></label>
                <div class="col-md-4">
					<input name="es_propietario" id="es_propietario" type="checkbox"  >
				</div>
              </div>
			<div class="form-group">
				<label class="control-label col-md-4" for="rol"><?php echo $this->lang->line('msg_label_rol'); ?></label>
                <div class="col-md-4">
					<input class="form-control" id="rol" name="rol" >
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="fecha_inicio"><?php echo $this->lang->line('msg_label_fecha_inicio'); ?></label>
                <div class="col-md-4">
					<input class="form-control" id="fecha_inicio" name="fecha_inicio" type="date">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-4" for="fecha_fin"><?php echo $this->lang->line('msg_label_fecha_fin'); ?></label>
				<div class="col-md-4">
                	<input class="form-control" id="fecha_fin" name="fecha_fin" type="date">
				</div>
			</div>
              <button type="button" id="boton_solicitar_usuario" class="btn btn-primary"><?php echo $this->lang->line('msg_label_aceptar'); ?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('msg_label_cancelar'); ?></button>
            </form>
          </div>
        </div>
      </div>
    </div>
<div class="fade modal" id="modal_invitar_usuario" style="">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-body">
            <form role="form" id="form_invitar_usuario" class="form-horizontal">
				<input type="hidden" class="form-control" id="id_notificacion" name="id_notificacion" type="text">
				<input type="hidden" class="form-control" id="id_usuario" name="id_usuario" type="text">
				<input type="hidden" class="form-control" id="id_proyecto" name="id_proyecto" type="text">
				<fieldset>
				  <div class="alert alert-danger" id="error_invitar_usuario" style="display: none;"></div>	      	
				  <div class="form-group">
					<label class="control-label col-md-4" for="nombre_completo"><?php echo $this->lang->line('msg_label_usuario'); ?></label>
					<div class="col-md-4">
						<input class="form-control" id="nombre_completo" name="nombre_completo" type="text" readonly>
					</div>
				  </div>
				  <div class="form-group">
					<label class="control-label col-md-4" for="proyecto"><?php echo $this->lang->line('msg_label_proyecto'); ?></label>
					<div class="col-md-4">
						<input class="form-control" id="nombre_proyecto" name="nombre_proyecto" type="text" readonly>
					</div>
				  </div>
					<div class="form-group">
					<label class="control-label col-md-4" for="es_propietario"><?php echo $this->lang->line('msg_label_propietario'); ?></label>
					<div class="col-md-4">
						<input class="form-control" name="es_propietario" id="es_propietario" type="text" readonly>
					</div>
				  </div>
				<div class="form-group">
					<label class="control-label col-md-4" for="rol"><?php echo $this->lang->line('msg_label_rol'); ?></label>
					<div class="col-md-4">
						<input class="form-control" id="rol" name="rol" type="text" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="fecha_inicio"><?php echo $this->lang->line('msg_label_fecha_inicio'); ?></label>
					<div class="col-md-4">
						<input class="form-control" id="fecha_inicio" name="fecha_inicio" type="text" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4" for="fecha_fin"><?php echo $this->lang->line('msg_label_fecha_fin'); ?></label>
					<div class="col-md-4">
						<input class="form-control" id="fecha_fin" name="fecha_fin" type="text" readonly>
					</div>
				</div>
				</fieldset>
              <button type="button" id="boton_invitar_usuario" class="btn btn-primary"><?php echo $this->lang->line('msg_label_aceptar'); ?></button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('msg_label_cancelar'); ?></button>
            </form>
          </div>
        </div>
      </div>
    </div>
	<div class="modal fade" id="modal_modificar_cuenta" tabindex="-1">
	  <div class="modal-dialog modal-md">
		<div class="modal-content">
		  <div class="modal-header">

			<h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('msg_label_modificar_opciones_cuenta'); ?></h4>
		  </div>
		  <div class="modal-body">
			<p><?php echo $this->lang->line('msg_cuerpo_modal_modificar_cuenta_exito'); ?></p>
		  </div>
		  <div class="modal-footer">
			<a class="btn btn-default" href="<?php echo site_url('interfaz/interfaz_c'); ?>" ><?php echo $this->lang->line('msg_label_cerrar'); ?></a>
		  </div>
		</div>
	  </div>
	</div>

	<div class="modal fade" id="modal_activar_cuenta" tabindex="-1">
	  <div class="modal-dialog modal-md">
		<div class="modal-content">
		  <div class="modal-header">

			<h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('msg_label_notificacion'); ?></h4>
		  </div>
		  <div class="modal-body">
			<p><?php echo $this->lang->line('msg_cuerpo_activar_cuenta'); ?></p>
		  </div>
		  <div class="modal-footer">
			<a class="btn btn-default" href="<?php echo site_url('interfaz/interfaz_c'); ?>" ><?php echo $this->lang->line('msg_label_cerrar'); ?></a>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="modal_actualizar_perfil" tabindex="-1">
	  <div class="modal-dialog modal-md">
		<div class="modal-content">
		  <div class="modal-header">

			<h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('msg_label_actualizar_perfil'); ?></h4>
		  </div>
		  <div class="modal-body">
			<p><?php echo $this->lang->line('msg_cuerpo_modal_actualiza_perfil_exito'); ?></p>
		  </div>
		  <div class="modal-footer">
			<a class="btn btn-default" href="<?php echo site_url('interfaz/interfaz_c'); ?>" ><?php echo $this->lang->line('msg_label_cerrar'); ?></a>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="modal_asociacion_proyecto" tabindex="-1">
	  <div class="modal-dialog modal-md">
		<div class="modal-content">
		  <div class="modal-header">

			<h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('msg_label_notificacion'); ?></h4>
		  </div>
		  <div class="modal-body">
			<p><?php echo $this->lang->line('msg_cuerpo_asociacion_proyecto'); ?></p>
		  </div>
		  <div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('msg_label_cerrar'); ?></button>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="modal_integrante_duplicado" tabindex="-1">
	  <div class="modal-dialog modal-md">
		<div class="modal-content">
		  <div class="modal-header">

			<h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('msg_label_notificacion'); ?></h4>
		  </div>
		  <div class="modal-body">
			<p><?php echo $this->lang->line('msg_cuerpo_integrante_duplicado'); ?></p>
		  </div>
		  <div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('msg_label_cerrar'); ?></button>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="modal_propietario_duplicado" tabindex="-1">
	  <div class="modal-dialog modal-md">
		<div class="modal-content">
		  <div class="modal-header">

			<h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('msg_label_notificacion'); ?></h4>
		  </div>
		  <div class="modal-body">
			<p><?php echo $this->lang->line('msg_cuerpo_propietario_duplicado'); ?></p>
		  </div>
		  <div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line('msg_label_cerrar'); ?></button>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="modal_actualizar_proyecto" tabindex="-1">
	  <div class="modal-dialog modal-md">
		<div class="modal-content">
		  <div class="modal-header">

			<h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('msg_label_notificacion'); ?></h4>
		  </div>
		  <div class="modal-body">
			<p><?php echo $this->lang->line('msg_cuerpo_actualizar_proyecto'); ?></p>
		  </div>
		  <div class="modal-footer">
			  <a href="<?php echo site_url('interfaz/interfaz_c'); ?>" class="btn btn-default"><?php echo $this->lang->line('msg_label_cerrar'); ?></a>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="modal_crear_seguimiento" tabindex="-1">
	  <div class="modal-dialog modal-md">
		<div class="modal-content">
		  <div class="modal-header">

			<h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('msg_label_notificacion'); ?></h4>
		  </div>
		  <div class="modal-body">
			<p><?php echo $this->lang->line('msg_cuerpo_crear_seguimiento'); ?></p>
		  </div>
		  <div class="modal-footer">
			  <a href="<?php echo site_url('interfaz/visualizar_mis_proyectos'); ?>" class="btn btn-default"><?php echo $this->lang->line('msg_label_cerrar'); ?></a>
		  </div>
		</div>
	  </div>
	</div>
	<div class="modal fade" id="modal_crear_contabilidad" tabindex="-1">
	  <div class="modal-dialog modal-md">
		<div class="modal-content">
		  <div class="modal-header">

			<h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('msg_label_notificacion'); ?></h4>
		  </div>
		  <div class="modal-body">
			<p><?php echo $this->lang->line('msg_modal_cuerpo_exito_crear_contabilidad'); ?></p>
		  </div>
		  <div class="modal-footer">
			  <a href="<?php echo site_url('interfaz/visualizar_mis_proyectos'); ?>" class="btn btn-default"><?php echo $this->lang->line('msg_label_cerrar'); ?></a>
		  </div>
		</div>
	  </div>
	</div>
	</body>
</html>