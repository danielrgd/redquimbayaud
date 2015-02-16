    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo $this->lang->line('msg_label_proyectos_mejor_valorados'); ?></h3>
            </div>
            <div class="panel-body">
              <ol>
			  <?php 

					foreach($proyectos_mejor_valorados as $proyecto){
						
						echo "<li>";
						echo "<a href=". site_url() ."/interfaz/visualizar_proyecto/".$proyecto['id_proyecto'].">".$proyecto['nombre_proyecto']."</a>";
						echo "</li>";
					}
			  ?>
              </ol>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="panel panel-primary" style="">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo $this->lang->line('msg_label_proyectos_mas_comentados'); ?></h3>
            </div>
            <div class="panel-body">
              <ol>
					<?php 
						foreach($proyectos_mas_comentados as $proyecto){
							
							echo "<li>";
							echo "<a>".$proyecto['nombre_proyecto']."</a>";
							echo "</li>";
						}
					?>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo $this->lang->line('msg_label_usuarios_mejor_valorados'); ?></h3>
            </div>
            <div class="panel-body">
              <ol>
                	<?php 
						foreach($usuarios_mejor_valorados as $usuario){
							
							echo "<li>";
							echo "<a href=". site_url() ."/interfaz/visualizar_usuario/".$usuario['id_usuario'].">".$usuario['nombre_completo']."</a>";
							echo " - ". $this->lang->line('msg_label_calificacion_promedio').": ".$usuario['valor'];
							echo "</li>";
						}
					?>
              </ol>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="panel panel-primary" style="">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo $this->lang->line('msg_label_usuarios_mas_comentados'); ?></h3>
            </div>
            <div class="panel-body">
              <ol>
                	<?php 
						foreach($usuarios_mas_comentados as $usuario){
							
							echo "<li>";
							echo "<a href=". site_url() ."/interfaz/visualizar_usuario/".$usuario['id_usuario'].">".$usuario['nombre_completo']."</a>";
							echo " - ".$usuario['valor']." ". $this->lang->line('msg_label_comentarios');
							echo "</li>";
						}
					?>
              </ol>
            </div>
          </div>
        </div>
      </div>
    </div>
