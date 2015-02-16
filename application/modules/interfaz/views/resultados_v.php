<div class="container">
	<legend><?php echo $this->lang->line('msg_label_resultados').": ".$busqueda; ?></legend>
		<div class="col-md-8 col-md-offset-2">
			<?php 

			if(is_array($usuarios) || is_array($proyectos)){
				
				if(is_array($usuarios)){
			?>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo $this->lang->line('msg_label_usuarios'); ?></h3>
					</div>
					<div class="panel-body">
						<ol>
						<?php 
					
							foreach($usuarios as $usuario){

									echo "<li>";
									echo "<a href=". site_url() ."/interfaz/visualizar_usuario/".$usuario['id_usuario'].">".$usuario['nombre_completo']."</a>";
									echo "</li>";
								}
						  ?>
						</ol>
					</div>
				</div>
			<?php
				}
			?>
			<?php 
				if(is_array($proyectos)){
			?>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo $this->lang->line('msg_label_proyectos'); ?></h3>
					</div>
					<div class="panel-body">
						<ol>
						<?php 

							foreach($proyectos as $proyecto){

									echo "<li>";
									echo "<a href=". site_url() ."/interfaz/visualizar_proyecto/".$proyecto['id_proyecto'].">".$proyecto['nombre_proyecto']."</a>";
									echo "</li>";
								}
						  ?>
						</ol>
					</div>
				</div>
			<?php
				}
			}
			else{
				echo $this->lang->line('msg_label_sin_coincidencias');
			}
			?>
	</div>
</div>
