$(function(){
	var FuncionesEmpleadosLicencia = {};

	(function (app){
		app.init = function(){
			funcionesUsuarioPermisos(app);
			app.activarPermisos();
			//Se comparten todas las funciones de Emplea
			funcionesVacaciones(app);
			//Se carga la fecha del dia
			var f = new Date();
			$("#tituloEmpleadosLicencia").html('<b>Personal de Licencia al ' + f.getDate()+'/'+(f.getMonth()+1)+'/'+f.getFullYear() + '</b>');
			var fecha = (f.getFullYear() + '-' + (f.getMonth()+1) + '-' + f.getDate());
			console.log(fecha);
			var url = "../controlador/ruteador/Ruteador.php?accion=buscarEmpleadosLicencia&Formulario=Empleado";
            var datosEnviar = ({fecha: fecha});
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: datosEnviar,
                success: function(data){
                    app.cargarEmpleadosLicencia(data);
                },
                error: function(){
                    alert("Error al buscar los empleados de licencia");
                }
            });
			//Se carga la tabla de los empleados de licencia
			
		};

		app.init();

	}) (FuncionesEmpleadosLicencia);
});