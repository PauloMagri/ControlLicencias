function funcionesUsuarioPermisos(app){
	//Se desabilitaran todas aquellas opciones de las cuales el usuario no tenga permisos
	app.activarPermisos = function(){
		var url = "../controlador/ruteador/Ruteador.php?accion=datosUsuario&Formulario=Usuario";
		$.ajax({
			url: url,
			method: 'POST',
			dataType: 'json',
			success: function(datosUsuario){
				url = "../controlador/ruteador/Ruteador.php?accion=listar&Formulario=UsuarioPermiso";
				var datosEnviar = ({id: datosUsuario['id']});
				$.ajax({
					url: url,
					method: 'POST',
					dataType: 'json',
					data: datosEnviar,
					success: function(usuarioPermisos){
						$.each(usuarioPermisos, function(key, registro){
							if (registro.descripcion.substring(0, 4) == 'link'){
								$("#" + registro.descripcion).parent().removeAttr('class', 'disabled');
								$("#" + registro.descripcion).removeAttr('class', 'disabled');
								$("#" + registro.descripcion).removeAttr('onclick');
							} else{
								$("#" + registro.descripcion).removeAttr('disabled');
							}
							
							
						});						
						
					},
					error: function(){
						alert("Error al buscar los permisos del usuario");
					}

				});

			},
			error: function(){
				alert("Error al obtener el id del usuario");
			}
		});
	};
};