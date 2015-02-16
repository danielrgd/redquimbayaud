//$(document).ready(function() {
//	
//	//Inactivacion de la fecha de implementacion
//	function fecha_implementacion (){
//		
//		var valor =$("#ctrl_implementado").val();
//		if(valor == '1'){
//			
//			$("#ctrl_fecha_implementacion").attr('disabled', 'true');
//		}
//		else{
//			
//			$("#ctrl_fecha_implementacion").removeAttr("disabled");
//			
//		}
//	};
//	
//	fecha_implementacion();
//	$("#ctrl_implementado").click(fecha_implementacion);
//	
//	$('#guardar_control').click( function(){
//		
//		 e.preventDefault();
//
//         $.ajax({
//             type: "POST", 
//             async: false,
//             url: '<?php echo site_url('control/control_c/add'); ?>',
//             success: function(){
//            	 		$('#controles').append('<p>prueba</p>');
//            	 		},
//             error: function(){
//            	 	alert('Error');
//            	 	}
//         });     
//	});
//	
//	
//	
// 
//});