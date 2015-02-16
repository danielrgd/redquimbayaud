<div class="container">
	<legend><?php echo $this->lang->line('msg_label_perfiles_tema_interes').": ".$busqueda; ?></legend>
		<div class="col-md-8 col-md-offset-2">
			<?php 

			if(isset($usuarios[0]) || isset($proyectos[0])){
				
				if(isset($usuarios[0])){
			?>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo $this->lang->line('msg_label_usuarios'); ?></h3>
					</div>
					<div class="panel-body">
						<ol>
						<?php 
					
							foreach($usuarios[0] as $id_usuario => $nombre_completo){

									echo "<li>";
									echo "<a href=". site_url() ."/interfaz/visualizar_usuario/".$id_usuario.">".$nombre_completo."</a>";
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
				if(isset($proyectos[0])){
			?>
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><?php echo $this->lang->line('msg_label_proyectos'); ?></h3>
					</div>
					<div class="panel-body">
						<ol>
						<?php 

							foreach($proyectos[0] as $id_proyecto => $nombre_proyecto){

									echo "<li>";
									echo "<a href=". site_url() ."/interfaz/visualizar_proyecto/".$id_proyecto.">".$nombre_proyecto."</a>";
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
