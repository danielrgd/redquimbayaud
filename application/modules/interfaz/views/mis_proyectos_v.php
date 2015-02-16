<div class="container">
	<legend><?php echo $this->lang->line('msg_label_mis_proyectos'); ?>
	<a class="btn btn-default" href="<?php echo site_url()."/interfaz/formulario_proyecto" ?> "><?php echo $this->lang->line('msg_label_crear'); ?></a>
	</legend> 
	
		<div class="col-md-8 col-md-offset-2">
			
			<?php 
			if(count($proyectos['propietario']) >0 || count($proyectos['integrante']) >0){
				if(count($proyectos['propietario']) >0){
			?>
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title"><?php echo $this->lang->line('msg_label_propietario'); ?></h3>
						</div>
						<div class="panel-body">
							<ul>
							<?php 

								foreach($proyectos['propietario'] as $key => $arreglo_proyecto){

										echo "<li>";
										echo "<a href=". site_url() ."/interfaz/visualizar_proyecto/".$arreglo_proyecto['id_proyecto'].">".$arreglo_proyecto['nombre_proyecto']."</a>";
										echo "<a class='btn btn-default btn-sm'  data-toggle='tooltip' data-placement='up' title='".$this->lang->line('msg_label_seguimiento')."' href=".site_url()."/interfaz/visualizar_formulario_seguimiento/".$arreglo_proyecto['id_proyecto']."> <span class='glyphicon glyphicon-list-alt'></span> </a>";
										echo "<a class='btn btn-default btn-sm' data-toggle='tooltip' data-placement='up' title='".$this->lang->line('msg_label_contabilidad')."' href=".site_url()."/interfaz/visualizar_formulario_contabilidad/".$arreglo_proyecto['id_proyecto']."> <span class='glyphicon glyphicon-usd'></span> </a>";
										echo "<br>".$arreglo_proyecto['rol']." ".$this->lang->line('msg_label_desde')." ".date("d-m-Y",$arreglo_proyecto['fecha_inicio'])." ".$this->lang->line('msg_label_hasta')." ".date("d-m-Y",$arreglo_proyecto['fecha_fin']);
										echo "</li>";
									}
							  ?>
							</ul>
						</div>
					</div>
			<?php
				}
				if(count($proyectos['propietario']) >0){
			?>
					<div class="panel panel-primary">
						<div class="panel-heading">
							<h3 class="panel-title"><?php echo $this->lang->line('msg_label_integrante'); ?></h3>
						</div>
						<div class="panel-body">
							<ul>
							<?php 

								foreach($proyectos['integrante'] as $key => $arreglo_proyecto){

										echo "<li>";
										echo "<a href=". site_url() ."/interfaz/visualizar_proyecto/".$arreglo_proyecto['id_proyecto'].">".$arreglo_proyecto['nombre_proyecto']."</a>"." - ".$arreglo_proyecto['rol']." ".$this->lang->line('msg_label_desde')." ".date("d-m-Y",$arreglo_proyecto['fecha_inicio'])." ".$this->lang->line('msg_label_hasta')." ".date("d-m-Y",$arreglo_proyecto['fecha_fin']);
										echo "</li>";
									}
							  ?>
							</ul>
						</div>
					</div>
			<?php
					
				}
					
			}
			else{
				echo $this->lang->line('msg_label_sin_proyectos');
			}
			?>
	</div>
</div>
